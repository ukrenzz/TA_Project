<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CategoryController;
use App\Models\Product;
use App\Models\ProductImages;
use App\Models\Category;
use App\Models\Feedback;
use Storage;

class ProductController extends Controller
{
  // Admin
  function manage()
  {
    $products = Product::join('categories', 'products.category_id', '=', 'categories.id')
      ->select('products.name as product_name', 'categories.name as product_category', 'products.id as id', 'brand', 'unit', 'color', 'products.description as description', 'price', 'stock', 'discount', 'products.created_at', 'products.updated_at')
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
    $_color = json_decode(Storage::disk('local')->get('colors.json'), true);
    $product = Product::where('id', $id)->first();
    $data = (object)[
      'categories' => CategoryController::getCategories(),
      'colors'     => $_color,
      'product'   => $product,
    ];
    return view('admin.products.create', ['mode' => $mode, 'data' => $data]);
  }

  function store(Request $req)
  {
    $this->validation($req);
    // dd($req->hasfile('image_product'));
    try {
      // $productInput = Product::create([
      //   'name'        => $req->name,
      //   'brand'       => $req->brand,
      //   'stock'       => $req->stock,
      //   'price'       => $req->price,
      //   'category_id' => $req->category,
      //   'unit'        => $req->unit,
      //   'user_id'     => 1,
      //   // 'user_id'     => Auth::id(),
      //   'description' => $req->description,
      //   'color'       => $req->color,
      //   'status'      => $req->status,
      //   'discount'    => $req->discount
      // ]);

      // dd($req->image_product[0]->getClientOriginalExtension());
      $p_id = 114;
      $p_ca = "2021-06-08 21:48:06";
      $p_cad = date("Y-m-d_H-i-s", strtotime($p_ca));
      if ($req->hasfile('image_product')) {
        $numbering = 1;
        $dataImageProducts = [];
        foreach ($req->file('image_product') as $image) {
          $filesize = $image->getSize();
          $imageThumbnail = Image::make($image);
          // $named   = 'product_' . $productInput->id . '_' . $productInput->created_at . '.' . $image->getClientOriginalExtension();
          $named   = 'product_' . $p_id . '_' . $p_cad . '_' . $numbering++ . '.' . $image->getClientOriginalExtension();
          $image->move(public_path() . '/images/products', $named);
          $dataImage = [
            'url'  => $named,
            'width'     => $imageThumbnail->width(),
            'height'    => $imageThumbnail->height(),
            'size'  => $filesize
          ];
          array_push($dataImageProducts, $dataImage);
        }
        ProductImages::insert($dataImageProducts);
        // dd($dataImageProducts);
      }

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

    Product::find($id)->delete();
    return response()->json([
      'success' => 'Record deleted successfully!'
    ]);
  }


  private function validation(Request $req)
  {
    $req->validate([
      'name'          => ['required'],
      'brand'         => ['required', 'string'],
      'stock'         => ['required', 'integer'],
      'category'      => ['required', 'integer'],
      'unit'          => ['required', 'string'],
      'description'   => ['required', 'string'],
      'color'         => ['required', 'string'],
      'status'        => ['required', 'string'],
      'discount'      => ['nullable', 'integer', 'digits_between:0,100'],
      'image_product.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:15360'
    ]);
  }

  // E-commerce
  function index()
  {
    $products = Product::orderBy('created_at', 'asc')->take(10)->get();
    $categories = Category::orderBy('name', 'asc')->get();
    $data = (object)[
      'products' => $products,
      'categories' => $categories,
    ];
    return view('ecommerce.index', compact('data'));
  }

  function show($id)
  {
    $categories = Category::orderBy('name', 'asc')->get();

    $product = Product::join('categories', 'products.category_id', '=', 'categories.id')
      ->select('products.name as product_name', 'categories.name as product_category', 'products.id as id', 'brand', 'unit', 'color', 'products.description as description', 'price', 'stock', 'discount', 'products.created_at', 'products.updated_at')
      ->orderBy('product_name', 'asc')
      ->where('products.id', $id)
      ->get()->first();

    $feedbacks = Feedback::join('products', 'feedbacks.product_id', '=', 'products.id')
      ->select('feedbacks.id as id ', 'products.name as product_name', 'rate', 'comment', 'feedbacks.created_at as created_at', 'feedbacks.updated_at as updated_at')
      ->where('feedbacks.product_id', $id)
      ->orderBy('rate', 'desc')
      ->get();

    $data = (object)[
      'product' => $product,
      'categories' => $categories,
      'feedbacks' => $feedbacks,
    ];
    return view('ecommerce.detail', ['data' => $data]);
  }

  function categories($cat_id)
  {
    if ($cat_id) $products = Product::where('category_id', '=', $cat_id)->orderBy('created_at', 'asc')->take(10)->get();
    else  $products = Product::orderBy('created_at', 'asc')->take(10)->get();
    $categories = Category::orderBy('name', 'asc')->get();
    $data = (object)[
      'categories' => $categories,
      'products' => $products,
    ];
    return view('ecommerce.categories', compact('data'));
  }
}
