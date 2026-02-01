<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with(['category', 'brand'])
            ->featured()
            ->active()
            ->visible()
            ->take(8)
            ->get();

        $categories = Category::active()
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        return view('home', compact('featuredProducts', 'categories'));
    }

    public function shop(Request $request)
    {
        $query = Product::with(['category', 'brand'])
            ->active()
            ->visible();

        // Filters
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('brand')) {
            $query->where('brand_id', $request->brand);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sortBy = $request->get('sort', 'newest');
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12);
        $categories = Category::active()->get();
        $brands = Brand::active()->get();

        return view('shop', compact('products', 'categories', 'brands'));
    }

    public function product($id)
    {
        $product = Product::with(['category', 'brand', 'reviews.user', 'variants' => function($query) {
            $query->where('is_active', true)->orderBy('color_name');
        }])
            ->findOrFail($id);

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->active()
            ->visible()
            ->take(4)
            ->get();

        return view('product', compact('product', 'relatedProducts'));
    }
}
