<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Products;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search     = $request->input('search');
        $category = $request->input('category');
        $sortPrice = $request->input('sort_price');
        $products   = Products::with('category')
            ->when($search, function ($query, $search) {
                return $query->where('product_name', 'like', "%{$search}%");
            })
            ->when($category, function ($query, $category) {
                return $query->where('category_id', $category);
            })
            ->when($sortPrice, function ($query, $sortPrice) {
                if ($sortPrice === 'asc') {
                    return $query->orderBy('price', 'asc');
                } elseif ($sortPrice === 'desc') {
                    return $query->orderBy('price', 'desc');
                }
                return $query;
            })
            ->paginate(6);

        $categories = Categories::all();

        return view('pages.home.index', compact('products', 'categories'));
    }
    public function cart()
    {
        return view('pages.home.cart');
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
