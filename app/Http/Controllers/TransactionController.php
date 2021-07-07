<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\User;
use App\Models\Cart;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
  function index()
  {
    $categories = Category::orderBy('name', 'asc')->get();
    $transactions = Transaction::orderBy('created_at', 'asc')->get();

    $data = (object)[
      'transactions' => $transactions,
      'categories' => $categories,
    ];

    return view('ecommerce.payment', compact('data'));
  }
  function order()
  {
    $categories = Category::orderBy('name', 'asc')->get();
    $transactions = Transaction::join('users', 'users.id', '=', 'transactions.user_id')
      ->join('transaction_details', 'transaction_details.transaction_id', '=', 'transactions.id')
      ->join('products', 'products.id', '=', 'transaction_details.product_id')
      ->select('transactions.id', 'ref', 'users.name as username', 'products.name as product_name',  'products.id as product_id', 'ppn', 'transactions.status as status', 'transactions.discount', 'shipping_cost', 'payment_method', 'transaction_details.quantity as quantity', 'transaction_details.price as price', 'transactions.created_at', 'transactions.updated_at')
      ->where('user_id', '=', Auth::id())
      ->orderBy('updated_at', 'desc')
      ->get();
    $data = (object)[
      'transactions' => $transactions,
      'categories' => $categories,
    ];
    return view('ecommerce.order', compact('data'));
  }
  function create()
  {
    $categories = Category::orderBy('name', 'asc')->get();
    $carts = Cart::join('products', 'carts.product_id', '=', 'products.id')
      ->select('products.id as product_id', 'products.name as product_name', 'quantity', 'products.price as price', 'carts.created_at as created_at', 'carts.updated_at as updated_at')
      ->where('user_id', '=', Auth::id())
      ->orderBy('created_at', 'desc')->get();
    $user = User::where('id', '=', Auth::id())->get()->first();
    $data = (object)[
      'carts' => $carts,
      'categories' => $categories,
      'user' => $user,
    ];
    // dd($data);
    return view('ecommerce.payment', compact('data'));
  }
  function store()
  {
    return view('ecommerce.cart');
  }
  function success()
  {
    $categories = Category::orderBy('name', 'asc')->get();
    $data = (object)[
      'categories' => $categories,
    ];
    return view('ecommerce.checkout-success', compact('data'));
  }
}
