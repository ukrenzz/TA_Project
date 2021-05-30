<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CategoryController;
use App\Models\Product;
use Storage;

class ProductController extends Controller
{
  function index()
  {
    return view('ecommerce.index');
  }

  function manage()
  {
    $data = (object)[
      'categories' => Product::all(),
    ];

    return view('admin.products.index', ['data' => $data]);
  }

  function show()
  {
    return view('ecommerce.detail');
  }

  function create()
  {
    $_color = json_decode(Storage::disk('local')->get('colors.json'), true);

    $mode = "create";
    $data = (object)[
      'categories' => CategoryController::getCategories(),
      'colors'     => $_color
    ];

    return view('admin.products.create', ['mode' => $mode, 'data' => $data]);
  }

  function edit()
  {
    return view('ecommerce.categories');
  }

  function store(Request $req)
  {
    $this->validation($req);
    // dd($req);
    try{
      Product::create([
        'name'        => $req->name,
        'brand'       => $req->brand,
        'stock'       => $req->stock,
        'price'       => $req->price,
        'category_id' => $req->category,
        'unit'        => $req->unit,
        'user_id'     => Auth::id(),
        'description' => $req->description,
        'color'       => $req->color,
        'status'      => $req->status,
        'discount'    => $req->discount
      ]);

      return response()->json(['success' => true]);
    }
    catch(Exception $ex) {
      return response()->json(['success' => false, 'msg' => $ex->getMessage()]);
    }
    // return view('ecommerce.categories');
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
      'discount'    => ['nullable', 'integer','digits_between:0,100'],
      // 'images.*' => 'mimes:jpg,png,jpeg,gif,svg'
    ]);
  }
}
