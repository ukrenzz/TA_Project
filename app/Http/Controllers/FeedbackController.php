<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Category;


class FeedbackController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$feedbacks = Feedback::join('users', 'feedbacks.user_id', '=', 'users.id')
			->join('products', 'feedbacks.product_id', '=', 'products.id')
			->select('feedbacks.id as id ', 'users.name as user_name', 'products.name as product_name', 'rate', 'comment', 'feedbacks.created_at as created_at', 'feedbacks.updated_at as updated_at')
			->orderBy('rate', 'desc')->get();

		$data = (object)[
			'feedbacks' => $feedbacks,
		];
		return view('admin.feedbacks.index', compact('data'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$categories = Category::orderBy('name', 'asc')->get();
		$data = (object)[
			'categories' => $categories,
		];
		return view('ecommerce.feedback', compact('data'));
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
		//
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
	public function update(Request $request, $id)
	{
		//
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
