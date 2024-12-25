<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    // /**
    //  * Show the application dashboard.
    //  *
    //  * @return \Illuminate\Contracts\Support\Renderable
    //  */
   public function index(){
    //    return view('layouts.index');
    $products = Product::with(['category', 'brand'])->orderBy('id', 'desc')->paginate(10);
    return view('frontend.shop', compact('products'));
   }

   public function shop(){
       $products = Product::with(['category', 'brand'])->orderBy('id', 'desc')->paginate(10);
       return view('frontend.shop', compact('products'));
   }

   public function singleProduct($id, $slug)
   {
       $product = Product::with(['category', 'brand'])->find($id);
   
       if (!$product) {
           abort(404, 'Product not found.');
       }
   
       $rproducts = Product::where('slug', '<>', $slug)->limit(8)->get();
   
       // Decode gallery images for each related product
       $rproducts->each(function ($product) {
           $product->galleryImages = $product->images ? json_decode($product->images, true) : [];
       });
   
       return view('frontend.single-product', compact('product', 'rproducts'));
   }
   
   
}
