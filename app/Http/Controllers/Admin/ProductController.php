<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:150',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'sometimes|boolean',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products','public');

            // optional resize for consistency
            $img = Image::make(Storage::disk('public')->path($path))
                ->resize(800, 800, fn($c) => $c->aspectRatio()->upsize());
            $img->save();

            $data['image_path'] = $path;
        }

        Product::create($data);
        return redirect()->route('admin.products.index')->with('success','Created');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.edit', compact('product','categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:150',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'sometimes|boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image_path) Storage::disk('public')->delete($product->image_path);
            $path = $request->file('image')->store('products','public');
            $data['image_path'] = $path;
        }

        $product->update($data);
        return back()->with('success','Updated');
    }

    public function destroy(Product $product)
    {
        if ($product->image_path) Storage::disk('public')->delete($product->image_path);
        $product->delete();
        return back()->with('success','Deleted');
    }
}
