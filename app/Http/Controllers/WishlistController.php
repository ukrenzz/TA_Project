<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class WishlistController extends Controller
{
  function index()
  {
    $wishlists = Wishlist::join('users', 'wishlists.user_id', '=', 'users.id')
      ->join('products', 'wishlists.product_id', '=', 'products.id')
      ->select('users.name as user_name', 'products.id as product_id', 'products.name as product_name', 'products.price as price', 'wishlists.created_at as created_at', 'wishlists.updated_at as updated_at')
      ->where('user_id', '=', Auth::id())
      ->orderBy('wishlists.created_at', 'desc')->get();

    $categories = Category::orderBy('name', 'asc')->get();

    $data = (object)[
      'wishlists' => $wishlists,
      'categories' => $categories,
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

  function store(Request $request)
  {
    // Form validation
    $validated = $request->validate([
      'product_id' => ['required'],
    ]);

    Wishlist::create([
      'product_id' => strtolower($request['product_id']),
      'user_id' => Auth::id(),
    ]);

    return redirect()->route('product.show', ['id' => $request['product_id']])->with('status', 'Product is added to Wishlist!!');
  }

  function update()
  {
    return view('ecommerce.categories');
  }

  function delete($id, $from)
  {
    DB::table('wishlists')->where([['product_id', '=', $id], ['user_id', '=', Auth::id()]])->delete();
    if ($from == 'wishlist') return redirect()->route('wishlist.index')->with('status', 'Product is added to Wishlist!!');
    else
      return redirect()->route('product.show', ['id' => $id])->with('status', 'Product is added to Wishlist!!');
  }
}
