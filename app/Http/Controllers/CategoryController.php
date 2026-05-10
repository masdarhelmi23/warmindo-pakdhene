<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:categories,name']);
        Category::create($request->only('name'));
        return back()->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    public function destroy(Category $category)
    {
        // Cek jika kategori masih dipakai di produk
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Gagal! Kategori ini masih digunakan oleh beberapa produk.');
        }
        $category->delete();
        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}