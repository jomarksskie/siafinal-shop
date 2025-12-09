<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $q = Product::query()->where('is_active', true)->with('category');

        if ($search = $request->get('search')) {
            $q->where('name', 'like', "%{$search}%");
        }

        if ($cat = $request->get('category')) {
            $q->where('category_id', $cat);
        }

        $products = $q->latest()->paginate(12);
        $categories = Category::orderBy('name')->get();

        return view('shop.index', compact('products','categories'));
    }

    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);
        return view('shop.show', compact('product'));
    }
}
