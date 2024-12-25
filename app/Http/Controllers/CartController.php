<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function index()
    {
        $items = Cart::instance('cart')->content();
        return view('frontend.cart', compact('items'));
    }

    public function add_to_cart(Request $request){
      Cart::instance('cart')->add($request->id, $request->name, $request->quantity, $request->price)->associate(Product::find($request->id));

      return redirect()->back();
    }

    // public function increase_cart_quantity($rowId)
    // {
    //     $product = Cart::instance('cart')->get($rowId);
    //     $qty = $product->qty + 1;
    //     Cart::instance('cart')->update($rowId, $qty);

    //     return redirect()->back();
    // }

    // public function decrease_cart_quantity($rowId)
    // {
    //     $product = Cart::instance('cart')->get($rowId);
    //     $qty = $product->qty - 1;
    //     Cart::instance('cart')->update($rowId, $qty);

    //     return redirect()->back();
    // }

    public function increase_cart_quantity($rowId)
{
    $product = Cart::instance('cart')->get($rowId);
    $qty = $product->qty + 1;
    Cart::instance('cart')->update($rowId, $qty);

    return response()->json([
        'subtotal' => Cart::instance('cart')->subtotal(),
        'tax' => Cart::instance('cart')->tax(),
        'total' => Cart::instance('cart')->total(),
    ]);
}

public function decrease_cart_quantity($rowId)
{
    $product = Cart::instance('cart')->get($rowId);
    $qty = max($product->qty - 1, 1); // Ensure quantity doesn't go below 1
    Cart::instance('cart')->update($rowId, $qty);

    return response()->json([
        'subtotal' => Cart::instance('cart')->subtotal(),
        'tax' => Cart::instance('cart')->tax(),
        'total' => Cart::instance('cart')->total(),
    ]);
}

public function remove_from_cart($id)
{
    Cart::instance('cart')->remove($id);
    return redirect()->back();

}

public function allClear()
{
    Cart::instance('cart')->destroy();
    return redirect()->back();

}
}
