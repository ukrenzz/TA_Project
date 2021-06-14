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



  function colorDescriptor($img)
  {
    // Color Descriptor
    // Imagick untuk dapat Mean dan STDV 
    $img = new Imagick('D:\New Neko Code\TA_Project\public\assets\image\Godfrey Gao.jpg');

    // Mean and Std method from Imagick
    $IR = $img->getImageChannelMean(1); // Red
    $IG = $img->getImageChannelMean(4); // Green
    $IB = $img->getImageChannelMean(2); // Blue 

    // Mean, perlu direturn untuk citra dari DB
    $mean_IR =  $IR["mean"];
    $mean_IG =  $IG["mean"];
    $mean_IB =  $IB["mean"];

    // LT dan HT untuk ketiga channel warna RGB
    $lt_IR =  $mean_IR - $IR["standardDeviation"];
    $ht_IR =  $mean_IR + $IR["standardDeviation"];

    $lt_IG =  $mean_IG - $IG["standardDeviation"];
    $ht_IG =  $mean_IG + $IG["standardDeviation"];

    $lt_IB =  $mean_IB - $IB["standardDeviation"];
    $ht_IB =  $mean_IB + $IB["standardDeviation"];

    $colorObj = new colorInfo();

    $colorObj->mean_IR = $mean_IR;
    $colorObj->mean_IG = $mean_IG;
    $colorObj->mean_IB = $mean_IB;

    $colorObj->lt_IR = $lt_IR;
    $colorObj->ht_IR = $ht_IR;
    $colorObj->lt_IG = $lt_IG;
    $colorObj->ht_IG = $ht_IG;
    $colorObj->lt_IB = $lt_IB;
    $colorObj->ht_IB = $ht_IB;
    dd($colorObj);


    // TODO : Mau buat jadi object, baru bisa di return  
    // return ($IR, $IG, $IB, $lt_IR, $ht_IR, $lt_IG, $ht_IG, $lt_IB, $ht_IB);

    // TODO : mau dicoba, bagaimana cara akses properti $colorObj.  
    return $colorObj;

    // Source : 
    // https://www.php.net/manual/en/imagick.getimagechannelmean.php
    // https://www.php.net/manual/en/imagick.constants.php#imagick.constants.channel
    // https://www.geeksforgeeks.org/php-imagick-getimagechannelmean-function/

  }
}
