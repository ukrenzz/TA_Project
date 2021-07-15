<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
  function index()
  {
    $categories = Category::orderBy('name', 'asc')->take(8)->get();
    $products = Product::join('categories', 'products.category_id', '=', 'categories.id')
      ->select('products.name as product_name', 'categories.name as product_category', 'products.id as id', 'brand', 'unit', 'color', 'products.description as description', 'price', 'stock', 'discount', 'products.created_at', 'products.updated_at')
      ->orderBy('product_name', 'asc')
      ->take(8)
      ->get();
    $transactions = Transaction::orderBy('created_at', 'asc')->take(8)->get();
    $users = DB::table('users')->orderBy('name', 'asc')->take(8)->get();

    $data = (object)[
      'categories' => $categories,
      'products' => $products,
      'transactions' => $transactions,
      'users' => $users,
    ];
    return view('admin.dashboard', compact('data'));
  }
}
