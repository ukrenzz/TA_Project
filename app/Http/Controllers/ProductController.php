<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CategoryController;
use App\Models\Product;
use App\Models\Category;
use Storage;

class ProductController extends Controller
{
  // Admin 
  function manage()
  {
    $products = Product::join('categories', 'products.category_id', '=', 'categories.id')
      ->select('products.name as product_name', 'categories.name as category', 'products.id as id', 'brand', 'unit', 'color', 'products.description as description', 'products.created_at')
      ->orderBy('product_name', 'asc')
      ->get();
    $data = (object)[
      'products' => $products,
    ];
    return view('admin.products.index', compact('data'));
  }



  public static function getProducts($id = null)
  {
    $data = null;
    if ($id == null) {
      $data = Product::select('id', 'name', 'brand', 'category_id', 'unit', 'color', 'description')->orderBy('name', 'asc')->get();
    } else {
      $data = Product::select('id', 'name', 'brand', 'category_id', 'unit', 'color', 'description')->where('id', $id)->first();
    }
    return ($data);
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

  function edit($id)
  {
    $mode = "edit";
    $data = Product::where('id', $id)->first();
    return view('admin.products.create', ['mode' => $mode, 'data' => $data]);
  }

  function store(Request $req)
  {
    $this->validation($req);
    // dd($req);
    try {
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
    } catch (Exception $ex) {
      return response()->json(['success' => false, 'msg' => $ex->getMessage()]);
    }
    // return view('ecommerce.categories');
  }

  function update()
  {
    return view('ecommerce.categories');
  }

  function destroy($id)
  {
    // TODO: Belum berhasil 
    Product::find($id)->delete();
    return response()->json([
      'success' => 'Record deleted successfully!'
    ]);
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
      'discount'    => ['nullable', 'integer', 'digits_between:0,100'],
      // 'images.*' => 'mimes:jpg,png,jpeg,gif,svg'
    ]);
  }

  // E-commerce 
  function index()
  {
    $products = Product::orderBy('name', 'asc')->get();
    $categories = Category::orderBy('name', 'asc')->get();
    $data = (object)[
      'products' => $products,
      'categories' => $categories,
    ];
    return view('ecommerce.index', compact('data'));
  }

  function show()
  {
    // Perlu ganti jadi parameter 
    $id = 1;
    $data = Product::where('id', $id)->first();
    return view('ecommerce.detail', ['data' => $data]);
  }

  function categories()
  {
    $categories = Category::orderBy('name', 'asc')->get();
    $data = (object)[
      'categories' => $categories,
    ];
    return view('ecommerce.categories', compact('data'));
  }
}
