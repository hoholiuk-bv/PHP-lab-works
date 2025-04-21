<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     * GET /products
     */
    public function index()
    {
        // TODO fetch all products from db
        return view('product.index', [
            'products' => [] // Replace with fetched products
        ]);
    }

    /**
     * Show the form for creating a new product.
     * GET /products/create
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Store a newly created product in storage.
     * POST /products
     */
    public function store(Request $request)
    {
        // TODO create new product from request and save to db
        return redirect()->route('product.index');
    }

    /**
     * Display the specified product.
     * GET /products/{id}
     */
    public function show($id)
    {
        // TODO fetch product by id from db
        return view('product.show', [
            'product' => null // Replace with fetched product
        ]);
    }

    /**
     * Show the form for editing the specified product.
     * GET /products/{id}/edit
     */
    public function edit($id)
    {
        // TODO fetch product by id from db
        return view('product.edit', [
            'product' => null // Replace with fetched product
        ]);
    }

    /**
     * Update the specified product in storage.
     * PUT/PATCH /products/{id}
     */
    public function update(Request $request, $id)
    {
        // TODO update product with request data and save to db
        return redirect()->route('product.show', ['product' => $id]);
    }

    /**
     * Remove the specified product from storage.
     * DELETE /products/{id}
     */
    public function delete($id)
    {
        // TODO delete product by id from db
        return redirect()->route('product.index');
    }
}
