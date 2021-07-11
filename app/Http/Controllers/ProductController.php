<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CategoryController;
use App\Models\Product;
use App\Models\ProductImages;
use App\Models\Category;
use App\Models\Wishlist;
use App\Models\Cart;
use App\Models\Feedback;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Image;

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
    // dd(explode(";",$data->product->color));
    return view('admin.products.create', ['mode' => $mode, 'data' => $data]);
  }

  function store(Request $req)
  {
    $this->validation($req);
    // dd($req->hasfile('image_product'));
    try {
      $productInput = Product::create([
        'name'              => $req->name,
        'brand'           => $req->brand,
        'stock'           => $req->stock,
        'price'           => $req->price,
        'category_id'     => $req->category,
        'unit'            => $req->unit,
        'add_by_user_id'  => Auth::id(),
        'description'     => $req->description,
        'color'           => $req->color,
        'status'          => $req->status,
        'discount'        => $req->discount
      ]);

      // dd($req->image_product[0]->getClientOriginalExtension());
      $image_product_id = $productInput->id;
      $image_product_date = date("Y-m-d_H-i-s", strtotime($productInput->created_at));

      if ($req->hasfile('image_product')) {
        $numbering = 1;
        $dataImageProducts = [];
        foreach ($req->file('image_product') as $image) {
          $filesize = $image->getSize();
          $imageThumbnail = Image::make($image);
          $named   = 'product_' . $image_product_id . '_' . $image_product_date . '_' . $numbering++ . '.' . $image->getClientOriginalExtension();
          $image->move(public_path() . '/images/products', $named);
          $dataImage = [
            'product_id'  => $image_product_id,
            'url'         => $named,
            'width'       => $imageThumbnail->width(),
            'height'      => $imageThumbnail->height(),
            'size'        => $filesize
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

  function update(Request $req)
  {
    $this->validation($req);
    // dd($req->hasfile('image_product'));
    try {
      // dd($req->id_product);
      $productInput = Product::find($req->id_product);
      $productInput->update([
        'name'              => $req->name,
        'brand'           => $req->brand,
        'stock'           => $req->stock,
        'price'           => $req->price,
        'category_id'     => $req->category,
        'unit'            => $req->unit,
        'description'     => $req->description,
        'color'           => $req->color,
        'status'          => $req->status,
        'discount'        => $req->discount
      ]);

      // dd($req->image_product[0]->getClientOriginalExtension());
      $image_product_id = $productInput->id;
      $image_product_date = date("Y-m-d_H-i-s", strtotime($productInput->created_at));

      if ($req->hasfile('image_product')) {
        $numbering = 1;
        $dataImageProducts = [];
        foreach ($req->file('image_product') as $image) {
          $filesize = $image->getSize();
          $imageThumbnail = Image::make($image);
          $named   = 'product_' . $image_product_id . '_' . $image_product_date . '_' . $numbering++ . '.' . $image->getClientOriginalExtension();
          $image->move(public_path() . '/images/products', $named);
          $dataImage = [
            'product_id'  => $image_product_id,
            'url'         => $named,
            'width'       => $imageThumbnail->width(),
            'height'      => $imageThumbnail->height(),
            'size'        => $filesize
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
  }

  function destroy($id)
  {
    // Remove image from public path
    $images = ProductImages::where('product_id', $id)->get();
    $_imageDeletedCheck = 0;
    if(count($images) > 0){
      foreach ($images as $image) {
        if(File::exists(public_path('images/products/'. $image->url))){
          $del = File::delete(public_path('images/products/'. $image->url));
        }
      }
      ProductImages::where('product_id', $id)->delete();
    }



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
      'image_product.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:15360'
    ]);
  }

  // E-commerce
  function index()
  {
    $products = Product::orderBy('created_at', 'asc')->paginate(20);
    $products->load('product_images');
    $categories = Category::orderBy('name', 'asc')->get();
    $data = (object)[
      'products' => $products,
      'categories' => $categories,
    ];
    // dd($products);
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

    $ratings = Feedback::join('products', 'feedbacks.product_id', '=', 'products.id')
      ->select('rate')
      ->where('feedbacks.product_id', $id)
      ->sum('rate');

    $wishlists = Wishlist::where([['user_id', '=', Auth::id()], ['product_id', '=', $id]])
      ->orderBy('wishlists.created_at', 'desc')->get();

    $cart = Cart::where([['user_id', '=', Auth::id()], ['product_id', '=', $id]])
      ->orderBy('carts.created_at', 'desc')->get();



    $isWishlist = false;
    $isCart = false;
    if ($wishlists->isNotEmpty()) $isWishlist = true;
    if ($cart->isNotEmpty()) $isCart = true;

    $data = (object)[
      'product'     => $product,
      'categories'  => $categories,
      'feedbacks'   => $feedbacks,
      'rating'      => $ratings, 
      'isWishlist'  => $isWishlist,
      'isCart'      => $isCart,
    ];
    return view('ecommerce.detail', ['data' => $data]);
  }

  function categories($cat_id)
  {
    if ($cat_id) $products = Product::where('category_id', '=', $cat_id)->orderBy('created_at', 'asc')->take(20)->get();
    else  $products = Product::orderBy('created_at', 'asc')->take(20)->get();
    $categories = Category::orderBy('name', 'asc')->get();
    $data = (object)[
      'categories' => $categories,
      'products' => $products,
    ];
    return view('ecommerce.categories', compact('data'));
  }
}
