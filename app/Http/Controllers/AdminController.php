<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
  function index()
  {
    $categories = Category::orderBy('name', 'asc')->take(8)->get();
    $transactions = Transaction::orderBy('created_at', 'asc')->take(8)->get();

    $customers = User::where('role', 1)->get();

    $profitsThisMonth = Transaction::join('transaction_details', 'transactions.id', 'transaction_details.transaction_id')
      ->select('product_id', 'transactions.status', 'price', 'updated_at')
      ->whereMonth('transactions.updated_at', date('m'))
      ->whereYear('transactions.updated_at', date('Y'))
      ->where('transactions.status', "sending")
      ->sum('price');

    $profitsLastMonth = Transaction::join('transaction_details', 'transactions.id', 'transaction_details.transaction_id')
      ->select('product_id', 'transactions.status', 'price', 'updated_at')
      ->whereMonth('transactions.updated_at', date('m', strtotime("-1 month")))
      ->whereYear('transactions.updated_at', date('Y', strtotime("-1 month")))
      ->where('transactions.status', "sending")
      ->sum('price');

    $orders = Transaction::join('transaction_details', 'transactions.id', 'transaction_details.transaction_id')
      ->select('product_id', 'transactions.status', 'quantity')
      ->where('transactions.status', "sending")
      ->sum('quantity');

    $growth = (($profitsThisMonth - $profitsLastMonth) / $profitsLastMonth) * 100;

    $data = (object)[
      'categories'    => $categories,
      'profits'       => $profitsThisMonth,
      'growth'        => $growth,
      'order'         => $orders,
      'transactions'  => $transactions,
      'customers'     => $customers,
    ];
    return view('admin.dashboard', compact('data'));
  }
}
