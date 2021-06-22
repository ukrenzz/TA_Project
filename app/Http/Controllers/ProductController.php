<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CategoryController;
use App\Models\Product;
use App\Models\Category;
use Storage;

// use CV\CascadeClassifier, CV\Face\FacemarkLBF;
// use function CV\{circle, imread, imwrite, cvtColor, equalizeHist};
// use CV\Scalar;
// use const CV\{COLOR_BGR2GRAY};

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

// $img = new Imagick('D:\New Neko Code\TA_Project\public\assets\image\Godfrey Gao.jpg');

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

  // Perlu install dulu Open CV PHP, lihat di slack untuk pesan lebih lanjut 

  function LPB()
  {
    // src : https://www.geeksforgeeks.org/create-local-binary-pattern-of-an-image-using-opencv-python/

    // https://github.com/php-opencv/php-opencv-examples/blob/master/detect_facemarks_by_lbf.php


    // $src = imread("images/faces.jpg");
    // $gray = cvtColor($src, COLOR_BGR2GRAY);
    // equalizeHist($gray, $gray);

    // // face by lbpcascade_frontalface
    // $faceClassifier = new CascadeClassifier();
    // $faceClassifier->load('models/lbpcascades/lbpcascade_frontalface.xml');
    // $faces = null;
    // $faceClassifier->detectMultiScale($gray, $faces);
    // //var_export($faces);

    // $facemark = FacemarkLBF::create();
    // $facemark->loadModel('models/opencv-facemark-lbf/lbfmodel.yaml');

    // $facemark->fit($src, $faces, $landmarks);
    // //var_export($landmarks);
    // if ($landmarks) {
    //   $scalar = new Scalar(0, 0, 255);
    //   foreach ($landmarks as $face) {
    //     foreach ($face as $k => $point) { //var_export($point);
    //       circle($src, $point, 2, $scalar, 2);
    //     }
    //   }
    // }


    // imwrite("results/_detect_facemarks_by_lbf.jpg", $src);
  }

  // input: r,g,b in range 0..255
  function RGBtoHSV($r, $g, $b)
  {
    $r = $r / 255.; // convert to range 0..1
    $g = $g / 255.;
    $b = $b / 255.;
    $cols = array("r" => $r, "g" => $g, "b" => $b);
    asort($cols, SORT_NUMERIC);
    $min = key(array_slice($cols, 1)); // "r", "g" or "b"
    $max = key(array_slice($cols, -1)); // "r", "g" or "b"

    // hue
    if ($cols[$min] == $cols[$max]) {
      $h = 0;
    } else {
      if ($max == "r") {
        $h = 60. * (0 + (($cols["g"] - $cols["b"]) / ($cols[$max] - $cols[$min])));
      } elseif ($max == "g") {
        $h = 60. * (2 + (($cols["b"] - $cols["r"]) / ($cols[$max] - $cols[$min])));
      } elseif ($max == "b") {
        $h = 60. * (4 + (($cols["r"] - $cols["g"]) / ($cols[$max] - $cols[$min])));
      }
      if ($h < 0) {
        $h += 360;
      }
    }

    // saturation
    if ($cols[$max] == 0) {
      $s = 0;
    } else {
      $s = (($cols[$max] - $cols[$min]) / $cols[$max]);
      $s = $s * 255;
    }

    // lightness
    $v = $cols[$max];
    $v = $v * 255;

    return (array($h, $s, $v));
  }

  // Input filename, cth : D:\New Neko Code\TA_Project\public\assets\image\Godfrey Gao.jpg
  // Hasil uji: udah bisa sampai HSV, namun, belum tau gimana pakai hasil akhirnya ... 
  function edgeDescriptor($filename) {
    $filename = "D:\New Neko Code\TA_Project\public\assets\image\Godfrey Gao.jpg";
    $dimensions = getimagesize($filename);
    $w = $dimensions[0]; // width
    $h = $dimensions[1]; // height

    $im = imagecreatefromjpeg($filename);

    for ($hi = 0; $hi < $h; $hi++) {
      for ($wi = 0; $wi < $w; $wi++) {
        $rgb = imagecolorat($im, $wi, $hi);
        
        
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;
        $hsv = $this->RGBtoHSV($r, $g, $b);
        
        if ($hi < $h - 1) {
          // compare pixel below with current pixel
          $brgb = imagecolorat($im, $wi, $hi + 1);
          $br = ($brgb >> 16) & 0xFF;
          $bg = ($brgb >> 8) & 0xFF;
          $bb = $brgb & 0xFF;
          $bhsv = $this->RGBtoHSV($br, $bg, $bb);
          
          // if difference in hue is bigger than 20, make this pixel white (edge), otherwise black
          if ($bhsv[2] - $hsv[2] > 20) {
            imagesetpixel($im, $wi, $hi, imagecolorallocate($im, 255, 255, 255));
          } else {
            imagesetpixel($im, $wi, $hi, imagecolorallocate($im, 0, 0, 0));
          }
        }
      }
    }
    
    header('Content-Type: image/jpeg');
    // TODO : Bagaimana cara memanfaatkan hasil ini ? 
    imagejpeg($im);
    imagedestroy($im);
  }
}
