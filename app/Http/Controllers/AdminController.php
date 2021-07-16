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
    $transactions = Transaction::orderBy('created_at', 'asc')->take(8)->get();
    $users = DB::table('users')->orderBy('name', 'asc')->take(8)->get();

    $data = (object)[
      'categories' => $categories,
      'transactions' => $transactions,
      'users' => $users,
    ];
    return view('admin.dashboard', compact('data'));
  }
}
