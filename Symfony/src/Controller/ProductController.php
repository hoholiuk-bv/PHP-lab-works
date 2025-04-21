<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController{
    #[Route('/product', name: 'product_index', methods: ['GET'])]
    public function index(): Response
    {
        // TODO fetch all products from db
        return $this->render('product/index.html.twig', [
            'products' => [], // Replace with fetched products from DB
        ]);
    }

    #[Route('/product/{id}', name: 'product_show', methods: ['GET'])]
    public function show(int $id): Response
    {
        // TODO fetch product by id from db
        return $this->render('product/show.html.twig', [
            'product' => null, // Replace with the fetched product obj
        ]);
    }

    #[Route('/product/create', name: 'product_create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            // TODO create new product from request and save to db
            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/create.html.twig');
    }

    #[Route('/product/{id}/edit', name: 'product_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, int $id): Response
    {
        // TODO fetch product by id from db
        if ($request->isMethod('POST')) {
            // TODO update product with data from request and save to db
            return $this->redirectToRoute('product_show', ['id' => $id]);
        }

        return $this->render('product/edit.html.twig', [
            'product' => null, // Replace with the fetched Product obj
        ]);
    }

    #[Route('/product/{id}/delete', name: 'product_delete', methods: ['POST'])]
    public function delete(int $id): Response
    {
        // TODO delete product by id from db
        return $this->redirectToRoute('product_index');
    }
}
