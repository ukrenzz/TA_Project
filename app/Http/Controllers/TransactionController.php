<?php

namespace App\Http\Controllers;
use App\Models\Category;
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
  function create()
  {
    return view('ecommerce.payment');
  }
  function store()
  {
    return view('ecommerce.cart');
  }
}
