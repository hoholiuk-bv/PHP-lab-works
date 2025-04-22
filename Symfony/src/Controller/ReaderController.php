<?php

namespace App\Controller;

use App\Entity\Reader;
use App\Form\ReaderType;
use App\Repository\ReaderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/reader')]
final class ReaderController extends AbstractController{
    #[Route(name: 'app_reader_index', methods: ['GET'])]
    public function index(Request $request, ReaderRepository $readerRepository): Response
    {
        // Отримуємо параметри з запиту
        $fullName = $request->query->get('fullName', '');
        $email = $request->query->get('email', '');
        $limit = $request->query->getInt('limit', 10); // Кількість елементів на сторінці
        $page = $request->query->getInt('page', 1); // Поточна сторінка

        // Запит для фільтрації по FullName та Email
        $queryBuilder = $readerRepository->createQueryBuilder('r');

        // Додати фільтрацію по FullName
        if ($fullName) {
            $queryBuilder->andWhere('r.fullName LIKE :fullName')
                ->setParameter('fullName', '%' . $fullName . '%');
        }

        // Додати фільтрацію по Email
        if ($email) {
            $queryBuilder->andWhere('r.email LIKE :email')
                ->setParameter('email', '%' . $email . '%');
        }

        // Пагінація
        $queryBuilder->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

        $readers = $queryBuilder->getQuery()->getResult();

        // Загальна кількість записів для пагінації (без фільтрації)
        $totalReadersQuery = $readerRepository->createQueryBuilder('r');
        if ($fullName) {
            $totalReadersQuery->andWhere('r.fullName LIKE :fullName')
                ->setParameter('fullName', '%' . $fullName . '%');
        }

        if ($email) {
            $totalReadersQuery->andWhere('r.email LIKE :email')
                ->setParameter('email', '%' . $email . '%');
        }

        $totalReaders = $totalReadersQuery->select('COUNT(r.id)')->getQuery()->getSingleScalarResult();
        $totalPages = ceil($totalReaders / $limit);

        return $this->render('reader/index.html.twig', [
            'readers' => $readers,
            'fullName_filter' => $fullName,
            'email_filter' => $email,
            'limit' => $limit,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalCount' => $totalReaders,
        ]);
    }

    #[Route('/new', name: 'app_reader_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reader = new Reader();
        $form = $this->createForm(ReaderType::class, $reader);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reader);
            $entityManager->flush();

            return $this->redirectToRoute('app_reader_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reader/new.html.twig', [
            'reader' => $reader,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reader_show', methods: ['GET'])]
    public function show(Reader $reader): Response
    {
        return $this->render('reader/show.html.twig', [
            'reader' => $reader,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reader_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reader $reader, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReaderType::class, $reader);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reader_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reader/edit.html.twig', [
            'reader' => $reader,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reader_delete', methods: ['POST'])]
    public function delete(Request $request, Reader $reader, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reader->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($reader);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reader_index', [], Response::HTTP_SEE_OTHER);
    }
}
