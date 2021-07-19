<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Wishlist;
use App\Models\Category;
use App\Models\ProductImages;

use Illuminate\Http\Request;

class WishlistController extends Controller
{
  function index()
  {
    $_wishlists = Wishlist::join('users', 'wishlists.user_id', '=', 'users.id')
      ->join('products', 'wishlists.product_id', '=', 'products.id')
      ->select(
        'users.name as user_name',
        'products.id as product_id',
        'products.name as product_name',
        'products.price as price',
        'wishlists.created_at as created_at',
        'wishlists.updated_at as updated_at')
      ->where('user_id', '=', Auth::id())
      ->orderBy('wishlists.created_at', 'desc')->get();

    $categories = Category::orderBy('name', 'asc')->get();
    $wishlists = [];

    foreach ($_wishlists as $wishlist) {

      $_images  = ProductImages::where('product_id', $wishlist->product_id)->select('url')->first();

      $_tempWishlist = (object)[
        'user_name'     => $wishlist->user_name,
        'product_id'    => $wishlist->product_id,
        'product_name'  => $wishlist->product_name,
        'price'         => $wishlist->price,
        'created_at'    => $wishlist->created_at,
        'updated_at'    => $wishlist->updated_at,
        'thumbnail'     => isset($_images) ? $_images->url : "",
      ];

      array_push($wishlists, $_tempWishlist);

    }

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

  function process(Request $request)
  {
    // Form validation
    $request->validate([
      'product_id' => ['required'],
    ]);

    $status = "";
    $action = "";

    $isWishlist = Wishlist::where(['product_id' => $request->product_id, 'user_id'=>Auth::id()])->count();


    if($isWishlist == 0){

      $action = "store";

      $createWishlist = Wishlist::create([
        'product_id' => strtolower($request['product_id']),
        'user_id' => Auth::id(),
      ]);

      $status = $createWishlist != null ? "success" : "failed";

    } else if($isWishlist > 0) {

      $action = "deleted";

      $deletedWishlist = Wishlist::where(['product_id' => $request->product_id, 'user_id'=>Auth::id()])->delete();

      $status = $deletedWishlist != null ? "success" : "failed";

    }

    return response()->json([
      'action' => $action,
      'status' => $status
    ]);
  }

  function update()
  {
    return view('ecommerce.categories');
  }

  function delete($id)
  {
    DB::table('wishlists')->where([['product_id', '=', $id], ['user_id', '=', Auth::id()]])->delete();
      return back()->with('status', 'Product is removed from Wishlist!!');
  }
}
