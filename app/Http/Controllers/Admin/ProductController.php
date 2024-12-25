<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'brand'])->get();
        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.product.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'regular_price' => 'nullable|numeric',
            'sale_price' => 'nullable|numeric',
            'sku' => 'nullable|string',
            'stock_status' => 'nullable|in:instock,outofstock',
            'featured' => 'nullable|boolean',
            'quantity' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images' => 'nullable|array',
            'category_id' => 'nullable|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('product-gallery', 'public');
            }
            $data['images'] = json_encode($images);
        }

        Product::create($data);

        return redirect()->route('admin.product-index')->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.product.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug,' . $product->id,
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'regular_price' => 'nullable|numeric',
            'sale_price' => 'nullable|numeric',
            'sku' => 'nullable|string',
            'stock_status' => 'nullable|in:instock,outofstock',
            'featured' => 'nullable|boolean',
            'quantity' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images' => 'nullable|array',
            'category_id' => 'nullable|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        if ($request->hasFile('images')) {
            if ($product->images) {
                $existingImages = json_decode($product->images);
                foreach ($existingImages as $existingImage) {
                    Storage::disk('public')->delete($existingImage);
                }
            }
            $images = [];
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('product-gallery', 'public');
            }
            $data['images'] = json_encode($images);
        }

        $product->update($data);

        return redirect()->route('admin.product-index')->with('success', 'Product updated successfully.');
    }
    
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.product.show', compact('product'));
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        if ($product->images) {
            $existingImages = json_decode($product->images);
            foreach ($existingImages as $existingImage) {
                Storage::disk('public')->delete($existingImage);
            }
        }

        $product->delete();

        return redirect()->route('admin.product-index')->with('success', 'Product deleted successfully.');
    }
}
