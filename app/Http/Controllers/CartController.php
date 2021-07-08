<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Category;

use Illuminate\Http\Request;

class CartController extends Controller
{
  function index()
  {
    $carts = Cart::join('products', 'carts.product_id', '=', 'products.id')
      ->select('products.id as product_id', 'products.name as product_name', 'quantity', 'products.price as price', 'carts.created_at as created_at', 'carts.updated_at as updated_at')
      ->where('user_id', '=', Auth::id())
      ->orderBy('created_at', 'desc')->get();

    $categories = Category::orderBy('name', 'asc')->get();

    $data = (object)[
      'carts' => $carts,
      'categories' => $categories
    ];
    return view('ecommerce.cart', compact('data'));
  }

  function create()
  {
    return view('ecommerce.cart');
  }

  function edit()
  {
    return view('ecommerce.cart');
  }

  function store(Request $request)
  {
    // Form validation
    $request->validate([
      'product_id' => ['required'],
      'quantity' => ['required'],
    ]);

    Cart::create([
      'product_id' => strtolower($request['product_id']),
      'user_id' => Auth::id(),
      'quantity' => strtolower($request['quantity'])
    ]);

    // Delete from Wishlist 
    DB::table('wishlists')->where([['product_id', '=', $request['product_id']], ['user_id', '=', Auth::id()]])->delete();

    return back()->with('status', 'Product is added to Cart!!');
  }

  function update(Request $request)
  {
    $data = Cart::where([
      ['product_id', $request['product_id']],
      ['user_id', Auth::id()]
    ])->first();

    // Form validation
    $request->validate([
      'product_id' => ['required'],
      'quantity' => ['required'],
    ]);
    $data->quantity = $request['quantity'];
    $data->save();

    return back()->with('status', 'Data is updated!');

    // $affected = DB::table('carts')
    //   ->where(['product_id', $request['product_id']])
    //   ->where(['user_id', Auth::id()])
    //   ->update([
    //     ['quantity' => $request['quantity']]
    //   ]);
    // if ($affected) return back()->with('status', 'Data is updated!');
    // else return back()->with('status', 'Update Failed!');
  }

  function delete($id)
  {
    DB::table('carts')->where([['product_id', '=', $id], ['user_id', '=', Auth::id()]])->delete();
    return back()->with('status', 'Product is removed from Cart!!');
  }
}
