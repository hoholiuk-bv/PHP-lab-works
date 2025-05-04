<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/author')]
final class AuthorController extends AbstractController{
    #[Route(name: 'app_author_index', methods: ['GET'])]
    #[IsGranted('ROLE_CLIENT')]
    public function index(Request $request, AuthorRepository $authorRepository): Response
    {
        // Отримуємо фільтрр
        $nameFilter = $request->query->get('name', '');

        // Номер сторінки з запиту (за замовчуванням 1)
        $page = $request->query->getInt('page', 1);

        // Кількість елементів на сторінці з запиту (за замовчуванням 10, перевіряємо чи це коректне число)
        $limit = $request->query->getInt('limit', 10);
        if ($limit <= 0) {
            $limit = 10; // Встановлюємо значення за замовчуванням, якщо введено неправильне
        }

        // Обчислюємо кількість пропущених записів для пагінації
        $offset = ($page - 1) * $limit;

        // Створюємо запит для фільтрації та пагінації
        $queryBuilder = $authorRepository->createQueryBuilder('a')
            ->where('a.name LIKE :name')
            ->setParameter('name', '%' . $nameFilter . '%')
            ->orderBy('a.name', 'ASC')
            ->setFirstResult($offset) // Встановлюємо початок результатів
            ->setMaxResults($limit); // Встановлюємо кількість елементів на сторінці

        // Отримуємо авторів для поточної сторінки
        $authors = $queryBuilder->getQuery()->getResult();

        // Підрахунок загальної кількості записів (для обчислення кількості сторінок)
        $totalCount = $authorRepository->createQueryBuilder('a')
            ->select('count(a.id)')
            ->where('a.name LIKE :name')
            ->setParameter('name', '%' . $nameFilter . '%')
            ->getQuery()
            ->getSingleScalarResult();

        // Кількість сторінок
        $totalPages = ceil($totalCount / $limit);

        return $this->render('author/index.html.twig', [
            'authors' => $authors,
            'name_filter' => $nameFilter, // Фільтр для форми
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalCount' => $totalCount,
            'limit' => $limit,
        ]);
    }

    #[Route('/new', name: 'app_author_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_MANAGER')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($author);
            $entityManager->flush();

            return $this->redirectToRoute('app_author_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('author/new.html.twig', [
            'author' => $author,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_author_show', methods: ['GET'])]
    #[IsGranted('ROLE_CLIENT')]
    public function show(Author $author): Response
    {
        return $this->render('author/show.html.twig', [
            'author' => $author,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_author_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_MANAGER')]
    public function edit(Request $request, Author $author, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_author_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('author/edit.html.twig', [
            'author' => $author,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_author_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Author $author, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$author->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($author);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_author_index', [], Response::HTTP_SEE_OTHER);
    }
}
