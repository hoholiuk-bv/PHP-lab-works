<?php

namespace App\Controller;

use App\Entity\ReturnBook;
use App\Form\ReturnBookType;
use App\Repository\ReturnBookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/return/book')]
final class ReturnBookController extends AbstractController{
    #[Route(name: 'app_return_book_index', methods: ['GET'])]
    public function index(Request $request, ReturnBookRepository $returnBookRepository): Response
    {
        // Отримуємо параметри з запиту
        $returnDateFrom = $request->query->get('returnDateFrom', '');
        $returnDateTo = $request->query->get('returnDateTo', '');
        $limit = $request->query->getInt('limit', 10); // Кількість елементів на сторінці
        $page = $request->query->getInt('page', 1); // Поточна сторінка

        // Запит для фільтрації за returnDate
        $queryBuilder = $returnBookRepository->createQueryBuilder('r');

        // Додати фільтрацію за returnDate (з - по)
        if ($returnDateFrom) {
            $queryBuilder->andWhere('r.returnDate >= :returnDateFrom')
                ->setParameter('returnDateFrom', new \DateTime($returnDateFrom));
        }

        if ($returnDateTo) {
            $queryBuilder->andWhere('r.returnDate <= :returnDateTo')
                ->setParameter('returnDateTo', new \DateTime($returnDateTo));
        }

        // Пагінація
        $queryBuilder->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

        $returnBooks = $queryBuilder->getQuery()->getResult();

        // Загальна кількість записів для пагінації (без фільтрації)
        $totalReturnBooksQuery = $returnBookRepository->createQueryBuilder('r');
        if ($returnDateFrom) {
            $totalReturnBooksQuery->andWhere('r.returnDate >= :returnDateFrom')
                ->setParameter('returnDateFrom', new \DateTime($returnDateFrom));
        }

        if ($returnDateTo) {
            $totalReturnBooksQuery->andWhere('r.returnDate <= :returnDateTo')
                ->setParameter('returnDateTo', new \DateTime($returnDateTo));
        }

        $totalReturnBooks = $totalReturnBooksQuery->select('COUNT(r.id)')->getQuery()->getSingleScalarResult();
        $totalPages = ceil($totalReturnBooks / $limit);

        return $this->render('return_book/index.html.twig', [
            'return_books' => $returnBooks,
            'returnDateFrom_filter' => $returnDateFrom,
            'returnDateTo_filter' => $returnDateTo,
            'limit' => $limit,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalCount' => $totalReturnBooks,
        ]);
    }

    #[Route('/new', name: 'app_return_book_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $returnBook = new ReturnBook();
        $form = $this->createForm(ReturnBookType::class, $returnBook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($returnBook);
            $entityManager->flush();

            return $this->redirectToRoute('app_return_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('return_book/new.html.twig', [
            'return_book' => $returnBook,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_return_book_show', methods: ['GET'])]
    public function show(ReturnBook $returnBook): Response
    {
        return $this->render('return_book/show.html.twig', [
            'return_book' => $returnBook,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_return_book_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ReturnBook $returnBook, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReturnBookType::class, $returnBook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_return_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('return_book/edit.html.twig', [
            'return_book' => $returnBook,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_return_book_delete', methods: ['POST'])]
    public function delete(Request $request, ReturnBook $returnBook, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$returnBook->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($returnBook);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_return_book_index', [], Response::HTTP_SEE_OTHER);
    }
}
