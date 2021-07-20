<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImages;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function querySearch(Request $request)
	{
		$categories = Category::orderBy('name', 'asc')->get();
		$term = trim($request['term']);
		$products = Product::where('name', 'LIKE', '%' . $term . '%')
			->orderBy('name', 'asc')
			->paginate(20);
		$products->load('product_images');
		$data = (object)[
			'products' => $products,
			'categories' => $categories,
			'term' => $term,
		];
		return view('ecommerce.text-search', compact('data'));
	}



	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function visualSearchIndex()
	{
		$products = Product::orderBy('name', 'asc')->paginate(20);
		$categories = Category::orderBy('name', 'asc')->get();
		$data = (object)[
			'products' => $products,
			'categories' => $categories,
		];
		return view('ecommerce.visual-search', compact('data'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function visualSearchProcess($filename)
	{
		// dd('"'. public_path() . '/images/search/' . $filename . '"');
		$threshold = shell_exec('python scripts/generate_ht_lt.py "'. public_path() . '/images/search/' . $filename . '"');
		$threshold = json_decode($threshold);
		$dbImages = ProductImages::where('color_feat_r', '>=', $threshold->ltR)
															->where('color_feat_r', '<=', $threshold->htR)
															->where('color_feat_g', '>=', $threshold->ltG)
															->where('color_feat_g', '<=', $threshold->htG)
															->where('color_feat_b', '>=', $threshold->ltB)
															->where('color_feat_b', '<=', $threshold->htB)
															->get();
		if($dbImages != null){
			$lbpQ = shell_exec('python scripts/generate_lbp.py "' . public_path() . '/images/search/' . $filename . '"');
			// dd(json_encode($lbpQ));
			foreach($dbImages as $dbImage) {
				$dbImage->shape_feature = shell_exec('python scripts/sm_lbp.py "' . json_encode($lbpQ) . '" "'. $dbImage->shape_feature . '"');
				dd($dbImage->shape_feature);
			}			
		}
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
	public function visualSearchRes()
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
