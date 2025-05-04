<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/book')]
final class BookController extends AbstractController{
    #[Route(name: 'app_book_index', methods: ['GET'])]
    #[IsGranted('ROLE_CLIENT')]
    public function index(Request $request, BookRepository $bookRepository): Response
    {
        // Отримуємо параметри з запиту
        $titleFilter = $request->query->get('title', '');
        $isbnFilter = $request->query->get('isbn', '');
        $limit = $request->query->getInt('limit', 10); // кількість елементів на сторінці
        $page = $request->query->getInt('page', 1); // поточна сторінка

        // Запит для фільтрації та пагінації
        $queryBuilder = $bookRepository->createQueryBuilder('b');

        // Додамо фільтрацію
        if ($titleFilter) {
            $queryBuilder->andWhere('b.title LIKE :title')
                ->setParameter('title', '%'.$titleFilter.'%');
        }

        if ($isbnFilter) {
            $queryBuilder->andWhere('b.isbn LIKE :isbn')
                ->setParameter('isbn', '%'.$isbnFilter.'%');
        }

        // Пагінація
        $queryBuilder->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

        $books = $queryBuilder->getQuery()->getResult();

        // Загальна кількість книг для пагінації (без фільтрів)
        $totalBooksQuery = $bookRepository->createQueryBuilder('b');
        if ($titleFilter) {
            $totalBooksQuery->andWhere('b.title LIKE :title')
                ->setParameter('title', '%'.$titleFilter.'%');
        }
        if ($isbnFilter) {
            $totalBooksQuery->andWhere('b.isbn LIKE :isbn')
                ->setParameter('isbn', '%'.$isbnFilter.'%');
        }

        // Загальна кількість записів
        $totalBooks = $totalBooksQuery->select('COUNT(b.id)')->getQuery()->getSingleScalarResult();
        $totalPages = ceil($totalBooks / $limit);

        return $this->render('book/index.html.twig', [
            'books' => $books,
            'title_filter' => $titleFilter,
            'isbn_filter' => $isbnFilter,
            'limit' => $limit,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalCount' => $totalBooks,
        ]);
    }

    #[Route('/new', name: 'app_book_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_MANAGER')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('book/new.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_book_show', methods: ['GET'])]
    #[IsGranted('ROLE_CLIENT')]
    public function show(Book $book): Response
    {
        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_book_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_MANAGER')]
    public function edit(Request $request, Book $book, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('book/edit.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_book_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Book $book, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$book->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($book);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
    }
}
