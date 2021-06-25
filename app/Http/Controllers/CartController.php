<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;

use Illuminate\Http\Request;

class CartController extends Controller
{
  function index()
  {
    //TODO: Ingat taruh query where id = "", masukkan id user yang login saat ini
    $carts = Cart::join('products','carts.product_id', '=', 'products.id')
		->select('products.id as product_id', 'products.name as product_name', 'quantity', 'carts.price', 'carts.created_at as created_at', 'carts.updated_at as updated_at' )
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

  function store()
  {
    return view('ecommerce.cart');
  }

  function update()
  {
    return view('ecommerce.cart');
  }

  function delete()
  {
    return view('ecommerce.cart');
  }
}
