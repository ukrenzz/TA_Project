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
      ->select('products.id as product_id', 'products.name as product_name', 'quantity', 'discount', 'products.price as price', 'carts.created_at as created_at', 'carts.updated_at as updated_at')
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

  function refresh()
  {

  }

  function store(Request $request)
  {
    $isInCart = DB::table('carts')->where([['product_id', '=', $request['product_id']], ['user_id', '=', Auth::id()]])->get();
    $status = "";
    $action = "carting";
    $request->validate([
      'product_id' => ['required'],
      'quantity' => ['required'],
    ]);

    if ($isInCart->isEmpty()) {

      Cart::create([
        'product_id' => $request['product_id'],
        'user_id' => Auth::id(),
        'quantity' => $request['quantity']
      ]);

      $status = "success";

    } else if($isInCart->isEmpty() == false){
      // Form validation
      $carts = Cart::where(['product_id'=> $request['product_id'], 'user_id'=>Auth::id()])->first();

      $carts->quantity = ((int)$request->quantity + (int)$carts->quantity);

      $carts->save();

      $status = "success";

    }

    return response()->json([
      'action' => $action,
      'status' => $status
    ]);

  }

  function update(Request $request)
  {
    Cart::where([
      ['product_id', $request['product_id']],
      ['user_id', Auth::id()]
    ])->update(['quantity' => $request['quantity']]);

    return back()->with('status', 'Data is updated!');
  }

  function delete($id)
  {
    DB::table('carts')->where([['product_id', '=', $id], ['user_id', '=', Auth::id()]])->delete();
    return back()->with('status', 'Product is removed from Cart!!');
  }
}
