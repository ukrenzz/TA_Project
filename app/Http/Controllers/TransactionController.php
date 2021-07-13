<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\User;
use App\Models\Cart;
use App\Models\Product;
use App\Models\CheckoutTemps;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
  function index()
  {
    $categories = Category::orderBy('name', 'asc')->get();
    $transactions = Transaction::orderBy('created_at', 'asc')->get();

    $data = (object)[
      'transactions' => $transactions,
      'categories' => $categories,
    ];

    return view('ecommerce.payment', compact('data'));
  }
  function storeCheckout(Request $req)
  {

    $status = "Success";
    $error = "";
    $text = "";

    $_productData = [];

    foreach ($req->data as $products) {
      $product = (object)$products;

      $_product = Product::find($product->product_id);

      // dd((int)$product->quantity, (int)$_product->stock, (int)$product->quantity > (int)$_product->stock);
      if($_product == null)
      {
        $status = "Failed";
        $error  = "Product Missing";
        $text   = "The product you purchased is not registered.";
        break;
      }
      else if((int)$product->quantity < 0)
      {
        $status = "Failed";
        $error  = "Quantity";
        $text   = "Quantity must be more than 1.";
        break;
      }
      else if((int)$product->quantity > (int)$_product->stock)
      {
        $status = "Failed";
        $error  = "Out of Stock";
        $text   = "Purchase over stock.";
        break;
      }
      else
      {
        $_data = [
          'product_id'  => (int)$product->product_id,
          'user_id'     => Auth::id(),
          'quantity'    => (int)$product->quantity
        ];

        array_push($_productData, $_data);
      }
    }

    if($status == "Success")
    {
      CheckoutTemps::where('user_id', Auth::id())->delete();
      $storeCheck = CheckoutTemps::insert($_productData);

      // dd($storeCheck);
      return response()->json([
        'status' => $status
      ]);
    }
    else
    {
      return response()->json([
        'status'  => $status,
        'error'   => $error,
        'text'    => $text
      ]);
    }


    // return Redirect::route('transaction.payment')->with( ['productData' => $req] );
  }
  function order()
  {
    $categories = Category::orderBy('name', 'asc')->get();
    $transactions = Transaction::join('users', 'users.id', '=', 'transactions.user_id')
      ->join('transaction_details', 'transaction_details.transaction_id', '=', 'transactions.id')
      ->join('products', 'products.id', '=', 'transaction_details.product_id')
      ->select('transactions.id', 'ref', 'users.name as username', 'products.name as product_name',  'products.id as product_id', 'ppn', 'transactions.status as status', 'transactions.discount', 'shipping_cost', 'payment_method', 'transaction_details.quantity as quantity', 'transaction_details.price as price', 'transactions.created_at', 'transactions.updated_at')
      ->where('user_id', '=', Auth::id())
      ->orderBy('updated_at', 'desc')
      ->get();
    $data = (object)[
      'transactions' => $transactions,
      'categories' => $categories,
    ];
    return view('ecommerce.order', compact('data'));
  }
  function create()
  {
    $categories = Category::orderBy('name', 'asc')->get();
    $_products = CheckoutTemps::join('products', 'checkout_temps.product_id', '=', 'products.id')
      ->select('products.id as product_id', 'products.name as product_name', 'quantity', 'discount', 'products.price as price', 'checkout_temps.created_at as created_at', 'checkout_temps.updated_at as updated_at')
      ->where('user_id', '=', Auth::id())
      ->orderBy('created_at', 'desc')->get();
    $user = User::where('id', '=', Auth::id())->first();

    $data = (object)[
      'products' => $_products,
      'categories' => $categories,
      'user' => $user,
    ];

    // dd($data);
    return view('ecommerce.payment', compact('data'));
  }
  function storePayment(Request $req)
  {
    $_products = CheckoutTemps::join('products', 'checkout_temps.product_id', '=', 'products.id')
      ->select('products.id as id', 'quantity', 'discount', 'stock', 'products.price as price')
      ->where('user_id', '=', Auth::id())->get();

    $_productData = [];
    $_idProductWillDeleted = [];

    $_shippingCost    = 30000;
    $_ppn             = 0.05;
    $_status          = "pending";
    $_paymentMethod   = $req->payment_method;
    $_shippingMethod  = $req->shipping_method;
    $_note            = $req->note;


    if($_products->isNotEmpty()){
      $createTransaction = Transaction::create([
        'note'            => $_note,
        'user_id'         => Auth::id(),
        'ppn'             => $_ppn,
        'status'          => $_status,
        'discount'        => 0,
        'shipping_cost'   => $_shippingCost,
        'shipping_method' => $_shippingMethod,
        'payment_method'  => $_paymentMethod
      ]);

      if($createTransaction){

        foreach ($_products as $product) {
          $_productTemp = [
            'transaction_id'  => $createTransaction->id,
            'product_id'      => $product->id,
            'quantity'        => $product->quantity,
            'discount'        => $product->discount,
            'price'           => $product->price
          ];

          array_push($_productData, $_productTemp);
          array_push($_idProductWillDeleted, $product->id);
        }

        $createTransactionDetail = TransactionDetail::insert($_productData);

        if($createTransactionDetail){

          // dd($_idProductWillDeleted);
          Cart::where('user_id', Auth::id())->whereIn('product_id', $_idProductWillDeleted)->delete();
          CheckoutTemps::where('user_id', Auth::id())->whereIn('product_id', $_idProductWillDeleted)->delete();
        }
      }
    }
  }
  function success()
  {
    $categories = Category::orderBy('name', 'asc')->get();
    $data = (object)[
      'categories' => $categories,
    ];
    return view('ecommerce.checkout-success', compact('data'));
  }
}
