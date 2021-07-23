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
		header("Cross-Origin-Embedder-Policy: require-corp");
		header("Cross-Origin-Opener-Policy: same-origin");
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
	public function visualSearchProcess(Request $req)
	{
		$categories = Category::orderBy('name', 'asc')->get();
		$filename = $req->filename;
		$category = $req->category;

		$_imagePath = '"' . public_path('/images/search/' . $category . '/' . $filename) . '"';
		// $_imagePath = '"' . public_path('/images/search/' . $filename) . '"';
		$_parameter = $_imagePath . " " . strToLower($category);

		// dd($_parameter);

		$_searchData = shell_exec('python scripts/sm.py ' . $_parameter);
		$_searchData = json_decode($_searchData, true);

		$searchData = [];
		$data = [];

		// 181, 177, 179
		dd($_searchData);
		if($_searchData != null){
			foreach($_searchData as $dataProduct => $key){
				array_push($searchData, $dataProduct);
			}
			$ids_ordered = implode(',', $searchData);
			// dd($searchData);
			
			$products = Product::whereIn('id', $searchData)->orderByRaw("FIELD(id, $ids_ordered)")->paginate(16);
			
			$data = (object)[
				'products' => $products,
				'categories' => $categories,
			];

		}
		else {
			$data = (object)[
				'products' => null,
				'categories' => $categories,
			];
		}
		return view('ecommerce/visual-search-result', ['data' => $data]);
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
		$products = Product::orderBy('name', 'asc')->paginate(20);
		$categories = Category::orderBy('name', 'asc')->get();
		$data = (object)[
			'products' => $products,
			'categories' => $categories,
		];

		return view('ecommerce/visual-search-result', ['data' => $data]);
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
