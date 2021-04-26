<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
  function index()
  {
    return view('ecommerce.index');
  }

  function show()
  {
    return view('ecommerce.detail');
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
