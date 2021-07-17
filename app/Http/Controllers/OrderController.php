<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\ProductImages;

class OrderController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */


	private function _calcTotal($products)
	{
	 	$_result 				= [];
		$_tempQuantity	= 0;
		$_tempTotal			= 0;

		foreach ($products as $product) {
			$_subTotal = ((int)$product->price * (int)$product->quantity);

			if((int)$product->discount != 0 || (int)$product->discount != null || $product->discount != ""){
				$_subTotal *= ((int)$product->discount / 100);
			}

			$_tempTotal += $_subTotal;

			$_tempQuantity += (int)$product->quantity;
		}

		return ((object)['quantity' => $_tempQuantity, 'total' => $_tempTotal]);
	}

	public function index()
	{
		$orderData = [];
		// $_subQuery = TransactionDetail::select('quantity')
		$_orders = Transaction::join('users', 'users.id', '=', 'transactions.user_id')
			->select(
				'transactions.id as id',
				'note',
				'users.name as username',
				'ppn',
				'status',
				'discount',
				'shipping_cost',
				'payment_method',
				'transactions.created_at',
				'transactions.updated_at')
			->orderBy('updated_at', 'asc')
			->get()
			->load('transaction_details');
			// ->get();

			// dd($orders);

		foreach ($_orders as $order) {
			$_transactions  = TransactionDetail::where('transaction_id', $order->id)->get();
			$transaction		= $this->_calcTotal($_transactions);
			// dd($_transactions);
			$_orderData 		= (object)[
				'id'							=> $order->id,
				'note'						=> $order->note,
				'username'				=> $order->username,
				'quantity'				=> $transaction->quantity,
				'total'						=> $transaction->total,
				'status'					=> $order->status,
				'payment_method'	=> $order->payment_method,
				'created_at'			=> $order->created_at
			];

			array_push($orderData, $_orderData);
		}
		// dd($orderData);
		$data = (object)[
			'orders' => $orderData,
		];
		return view('admin.orders.index', compact('data'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$_transaction = Transaction::find($id);
		$transaction = [];
		if($_transaction != null)
		{
			$transaction = Transaction::join('users', 'users.id', '=', 'transactions.user_id')
				->select(
					'transactions.id as id',
					'note',
					'users.name as username',
					'ppn',
					'status',
					'discount',
					'shipping_cost',
					'shipping_method',
					'payment_method',
					'transactions.created_at as created_at',
					'transactions.updated_at as updated_at')
				->where('transactions.id', $id)
				->first();

			$_products = TransactionDetail::join('products', 'products.id', '=', 'transaction_details.product_id')
			->join('categories', 'categories.id', '=', 'products.category_id')
			->select(
				'transaction_details.product_id as id',
				'quantity',
				'transaction_details.discount as discount',
				'transaction_details.price as price',
				'products.brand as brand',
				'products.name as name',
				'categories.name as category',
				'products.unit as unit',
				)
			->where('transaction_details.transaction_id', $id)
			->get();

			$productsData = [];

			foreach ($_products as $_product) {
				$_tempImages = ProductImages::where('product_id', $_product->id)->select('url')->get();

				$_tempProduct = (object)[
					'product_id' => $_product->id,
					'name' => $_product->name,
					'brand' => $_product->brand,
					'price' => $_product->price,
					'category' => $_product->category,
					'unit' => $_product->unit,
					'quantity' => $_product->quantity,
					'images' => $_tempImages,
				];

				array_push($productsData, $_tempProduct);
			}
				// dd($productsData);
		}
		$data = (object)[
			'transaction' => $transaction,
			'products' => $productsData,
		];
		return view('admin.orders.detail', compact('data'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request)
	{
		$statusLevel 						= ["pending", "confirmed", "rejected", "sending"];
		$tempStatus 						= (Transaction::select('status')->find($request['id']))->status;
		$tempStatusLevel 				= array_search($tempStatus, $statusLevel);
		$tempStatusLevelRequest = array_search($request->status, $statusLevel);

		$actionStatus 	= "";
		$changedStatus 	= "";
		$actionText			= "";

		// dd($tempStatusLevel, $tempStatusLevelRequest);

		if($tempStatusLevel < $tempStatusLevelRequest)
		{

			$updateStatus = Transaction::where('id', $request['id'])
			->update(['status' => $request['status']]);

			if($updateStatus)
			{
				$actionStatus = "success";
				$changedStatus = $request->status;
				$actionText			= "Transaction with ID $request->id status has been change to $request->status!";
			}
			else
			{
				$actionStatus = "failed";
				$changedStatus = $tempStatus;
				$actionText			= "Transaction with ID $request->id status not changed. Status is still $tempStatus!";
			}

		}
		else
		{
			$actionStatus = "failed";
			$changedStatus = $tempStatus;
			$actionText			= ucfirst($tempStatus) . " transaction can't " . $request->status . ". Status is still $tempStatus!";
		}


		return response()->json([
			'status'  => $actionStatus,
			'text'	=> $actionText,
			'result'	=> (object)[
				'id'			=> $request['id'],
				'status'	=> $changedStatus
			]
		]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}
}
