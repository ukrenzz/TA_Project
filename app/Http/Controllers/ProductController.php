<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\CategoryController;
use App\Models\Product;

class ProductController extends Controller
{
  function index()
  {
    return view('ecommerce.index');
  }

  function manage()
  {
    return view('admin.products.index');
  }

  function show()
  {
    return view('ecommerce.detail');
  }

  function create()
  {
    $mode = "create";
    $data = (object)['categories' => CategoryController::getCategories()];

    return view('admin.products.create', ['mode' => $mode, 'data' => $data]);
  }

  function edit()
  {
    return view('ecommerce.categories');
  }

  function store(Request $req)
  {
    $this->validation($req);
    dd($req);
    try{
      Product::create([
        'name'        => $req->name,
        'brand'       => $req->brand,
        'stock'       => $req->stock,
        'price'       => $req->price,
        'category_id' => $req->category,
        'unit'        => $req->unit,
        'user_id'     => Auth::id(),
        // 'description' => $req->description,
        'color'       => $req->color,
        'status'      => $req->status,
        'discount'    => $req->discount
      ]);
    }
    catch(Exception $ex) {
      return 'error';
    }
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

  private function validation(Request $req)
  {
    $req->validate([
      'name'        => ['required'],
      'brand'       => ['required', 'string'],
      'stock'       => ['required', 'integer'],
      'category'    => ['required', 'integer'],
      'unit'        => ['required', 'string'],
      'description' => ['required', 'string'],
      'color'       => ['required', 'string'],
      'status'      => ['required', 'string'],
      'discount'    => ['integer','digits_between:0,100'],
      // 'images.*' => 'mimes:jpg,png,jpeg,gif,svg'
    ]);
  }
}
