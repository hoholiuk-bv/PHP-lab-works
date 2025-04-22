<?php

namespace App\Controller;

use App\Entity\Loan;
use App\Form\LoanType;
use App\Repository\LoanRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/loan')]
final class LoanController extends AbstractController{
    #[Route(name: 'app_loan_index', methods: ['GET'])]
    public function index(Request $request, LoanRepository $loanRepository): Response
    {
        // Отримуємо параметри з запиту
        $loanDateFrom = $request->query->get('loanDateFrom', '');
        $loanDateTo = $request->query->get('loanDateTo', '');
        $limit = $request->query->getInt('limit', 10); // Кількість елементів на сторінці
        $page = $request->query->getInt('page', 1); // Поточна сторінка

        // Запит для фільтрації за loanDate
        $queryBuilder = $loanRepository->createQueryBuilder('l');

        // Додати фільтрацію за loanDate (з - по)
        if ($loanDateFrom) {
            $queryBuilder->andWhere('l.loanDate >= :loanDateFrom')
                ->setParameter('loanDateFrom', new \DateTime($loanDateFrom));
        }

        if ($loanDateTo) {
            $queryBuilder->andWhere('l.loanDate <= :loanDateTo')
                ->setParameter('loanDateTo', new \DateTime($loanDateTo));
        }

        // Пагінація
        $queryBuilder->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

        $loans = $queryBuilder->getQuery()->getResult();

        // Загальна кількість записів для пагінації (без фільтрації)
        $totalLoansQuery = $loanRepository->createQueryBuilder('l');
        if ($loanDateFrom) {
            $totalLoansQuery->andWhere('l.loanDate >= :loanDateFrom')
                ->setParameter('loanDateFrom', new \DateTime($loanDateFrom));
        }

        if ($loanDateTo) {
            $totalLoansQuery->andWhere('l.loanDate <= :loanDateTo')
                ->setParameter('loanDateTo', new \DateTime($loanDateTo));
        }

        $totalLoans = $totalLoansQuery->select('COUNT(l.id)')->getQuery()->getSingleScalarResult();
        $totalPages = ceil($totalLoans / $limit);

        return $this->render('loan/index.html.twig', [
            'loans' => $loans,
            'loanDateFrom_filter' => $loanDateFrom,
            'loanDateTo_filter' => $loanDateTo,
            'limit' => $limit,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalCount' => $totalLoans,
        ]);
    }

    #[Route('/new', name: 'app_loan_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $loan = new Loan();
        $form = $this->createForm(LoanType::class, $loan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($loan);
            $entityManager->flush();

            return $this->redirectToRoute('app_loan_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('loan/new.html.twig', [
            'loan' => $loan,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_loan_show', methods: ['GET'])]
    public function show(Loan $loan): Response
    {
        return $this->render('loan/show.html.twig', [
            'loan' => $loan,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_loan_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Loan $loan, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LoanType::class, $loan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_loan_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('loan/edit.html.twig', [
            'loan' => $loan,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_loan_delete', methods: ['POST'])]
    public function delete(Request $request, Loan $loan, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$loan->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($loan);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_loan_index', [], Response::HTTP_SEE_OTHER);
    }
}
