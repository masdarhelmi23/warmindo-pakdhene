<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all(); // Ambil semua data kategori
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // 1. Validasi data (Tambahkan 'stock' di sini)
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric', // Stok wajib diisi angka
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Upload Gambar
        $path = $request->file('image')->store('products', 'public');

        // 3. Simpan ke Database
        Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'stock' => $request->stock, // Pastikan ini ada
            'description' => $request->description,
            'image' => $path,
            'status' => $request->has('status') ? 1 : 0,
        ]);

        return redirect()->route('products.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        // 1. Validasi data
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric', // Stok wajib diisi angka
        ]);

        $data = [
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'stock' => $request->stock, // Pastikan ini ada
            'description' => $request->description,
            'status' => $request->has('status') ? 1 : 0,
        ];

        // 2. Cek jika ada gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            // Simpan gambar baru
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // 3. Update data
        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Menu berhasil dihapus!');
    }


}