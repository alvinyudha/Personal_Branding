<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Categories::all();
        return view('pages.categories.index', compact('categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'categories_name' => 'required|string|unique:categories|max:255'
        ]);

        Categories::create([
            'categories_name' => $request->categories_name
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan');
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'categories_name' => 'required|string|max:255|unique:categories,categories_name,' . $id
        ]);

        $category = Categories::findOrFail($id);
        $category->update([
            'categories_name' => $request->categories_name
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy($id)
    {
        $category = Categories::findOrFail($id);

        // Check if category has products
        // if ($category->products()->count() > 0) {
        //     return redirect()->route('categories.index')
        //         ->with('error', 'Tidak dapat menghapus kategori yang memiliki produk');
        // }

        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus');
    }
}
