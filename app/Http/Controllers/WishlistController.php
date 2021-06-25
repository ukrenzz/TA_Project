<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Category;

use Illuminate\Http\Request;

class WishlistController extends Controller
{
  function index()
  {
    $wishlists = Wishlist::join('users', 'wishlists.user_id', '=', 'users.id')
      ->join('products', 'wishlists.product_id', '=', 'products.id')
      ->select('users.name as user_name', 'products.name as product_name', 'products.price as price', 'wishlists.created_at as created_at', 'wishlists.updated_at as updated_at')
      ->orderBy('wishlists.created_at', 'desc')->get();

    $categories = Category::orderBy('name', 'asc')->get();

    $data = (object)[
      'wishlists' => $wishlists,
      'categories'=> $categories,
    ];
    return view('ecommerce.wishlist', compact('data'));
  }

  function create()
  {
    return view('ecommerce.categories');
  }

  function edit()
  {
    return view('ecommerce.categories');
  }

  function store()
  {
    return view('ecommerce.categories');
  }

  function update()
  {
    return view('ecommerce.categories');
  }

  function delete()
  {
    return view('ecommerce.categories');
  }
}
