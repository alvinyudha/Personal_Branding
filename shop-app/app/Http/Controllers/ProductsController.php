<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $query = Products::with('category');

        // Filter berdasarkan search
        if ($request->has('search') && $request->search != '') {
            $query->where('product_name', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan kategori
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Sort berdasarkan harga
        if ($request->has('sort_price') && $request->sort_price != '') {
            if ($request->sort_price == 'asc') {
                $query->orderBy('price', 'asc');
            } elseif ($request->sort_price == 'desc') {
                $query->orderBy('price', 'desc');
            }
        }

        $products = $query->paginate(10)->appends($request->except('page')); // Menambahkan appends untuk mempertahankan query string saat paginasi
        $allCategories = Categories::all();

        return view('products.index', compact('products', 'allCategories'));
    }

    public function create()
    {
        // Redirect to index if trying to access create page
        return redirect()->route('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stok' => 'required|numeric|min:0',
            'description' => 'nullable|string'
        ]);

        Products::create([
            'category_id' => $request->category_id,
            'product_name' => $request->product_name,
            'price' => $request->price,
            'description' => $request->description,
            'stok' => $request->stok
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit($id)
    {
        // Redirect to index if trying to access edit page
        return redirect()->route('products.index');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stok' => 'required|numeric|min:0',
            'description' => 'nullable|string'
        ]);

        $product = Products::findOrFail($id);

        $product->update([
            'product_name' => $request->product_name,
            'price' => $request->price,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'stok' => $request->stok
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diupdate');
    }

    public function destroy($id)
    {
        Products::destroy($id);
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus');
    }
}