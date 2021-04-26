<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
  function index()
  {
    return view('ecommerce.cart');
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
