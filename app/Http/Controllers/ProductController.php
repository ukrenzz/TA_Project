<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CategoryController;
use App\Models\Product;
use Storage;

class colorInfo
{
  public $mean_IR;
  public $mean_IG;
  public $mean_IB;

  public $lt_IR;
  public $ht_IR;
  public $lt_IG;
  public $ht_IG;
  public $lt_IB;
  public $ht_IB;
}

$img = new Imagick('D:\New Neko Code\TA_Project\public\assets\image\Godfrey Gao.jpg');

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
      'discount'    => ['nullable', 'integer', 'digits_between:0,100'],
      // 'images.*' => 'mimes:jpg,png,jpeg,gif,svg'
    ]);
  }

  // -------------------------
  // CTEBIR Algo 

  // Parameter input dalam bentuk URL (Ambil dari DB)
  // contoh : 'D:\New Neko Code\TA_Project\public\assets\image\contohgambar.jpg'
  function db_colorDescriptor($db_img)
  {
    // Color Descriptor
    // Imagick untuk dapat Mean dan STDV 
    $img = new Imagick($db_img);

    // Mean and Std method from Imagick
    $IR = $db_img->getImageChannelMean(1); // Red
    $IG = $db_img->getImageChannelMean(4); // Green
    $IB = $db_img->getImageChannelMean(2); // Blue 

    // Mean, perlu direturn untuk citra dari DB
    $mean_IR =  $IR["mean"];
    $mean_IG =  $IG["mean"];
    $mean_IB =  $IB["mean"];

    $colorObj = new colorInfo();

    $colorObj->mean_IR = $mean_IR;
    $colorObj->mean_IG = $mean_IG;
    $colorObj->mean_IB = $mean_IB;


    // cara akses properti : $colorObj->mean_IR, dll 
    return $colorObj;

    // Source : 
    // https://www.php.net/manual/en/imagick.getimagechannelmean.php
    // https://www.php.net/manual/en/imagick.constants.php#imagick.constants.channel
    // https://www.geeksforgeeks.org/php-imagick-getimagechannelmean-function/

  }

  // Parameter input dalam bentuk URL (Ambil dari DB)
  // contoh : 'D:\New Neko Code\TA_Project\public\assets\image\contohgambar.jpg'
  function query_colorDescriptor($query_img)
  {
    // Color Descriptor
    // Imagick untuk dapat Mean dan STDV 
    $query_img = new Imagick($query_img);

    // Mean and Std method from Imagick
    $IR = $query_img->getImageChannelMean(1); // Red
    $IG = $query_img->getImageChannelMean(4); // Green
    $IB = $query_img->getImageChannelMean(2); // Blue 

    // LT dan HT untuk ketiga channel warna RGB
    $lt_IR =  $IR["mean"] - $IR["standardDeviation"];
    $ht_IR =  $IR["mean"] + $IR["standardDeviation"];

    $lt_IG =  $IG["mean"] - $IG["standardDeviation"];
    $ht_IG =  $IG["mean"] + $IG["standardDeviation"];

    $lt_IB =  $IB["mean"] - $IB["standardDeviation"];
    $ht_IB =  $IB["mean"] + $IB["standardDeviation"];

    $colorObj = new colorInfo();

    $colorObj->lt_IR = $lt_IR;
    $colorObj->ht_IR = $ht_IR;
    $colorObj->lt_IG = $lt_IG;
    $colorObj->ht_IG = $ht_IG;
    $colorObj->lt_IB = $lt_IB;
    $colorObj->ht_IB = $ht_IB;

    // cara akses properti : $colorObj->mean_IR, dll 
    return $colorObj;
  }

  function makeSubset()
  {
    // subset untuk menampung gambar yang berada di dalam range RGB query_img
    $subset = [];
    // Image Example 
    global $img;
    $query_img =  $img;

    // Ambil nilai mean IChannel (color_feature) dari tiap produk dari DB 
    // @foreach($productImage as) 
    $mean_IR = '//IR dari DB';
    $mean_IB = '//IB dari DB';
    $mean_IG = '//IG dari DB';

    if (
      ($mean_IR  < $this->query_colorDescriptor($query_img)->ht_IR && $mean_IR  > $this->query_colorDescriptor($query_img)->lt_IR) &&
      ($mean_IG  < $this->query_colorDescriptor($query_img)->ht_IG && $mean_IG  > $this->query_colorDescriptor($query_img)->lt_IG) &&
      ($mean_IB  < $this->query_colorDescriptor($query_img)->ht_IB && $mean_IB  > $this->query_colorDescriptor($query_img)->lt_IB)
    ) {
      // masukkan ke Array Subset 
      // $subset[] = $db_image;
    }

    // @endforeach
  }
}
