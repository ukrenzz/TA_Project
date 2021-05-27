<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    function index()
    {
      $categories_data = Category::orderBy('name', 'asc')->get();

      $data = (object)[
        'categories_data' => $categories_data,
      ];

      return view('admin.categories.index', compact('data'));
    }

    public static function getCategories($id = null)
    {
      $data = null;

      if($id == null)
      {
        $data = Category::select('id', 'name', 'description')->orderBy('name', 'asc')->get();
      }
      else
      {
        $data = Category::select('id', 'name', 'description')->where('id', $id)->first();
      }
      return($data);
    }

    function create()
    {
      $mode = "create";

      return view('admin.categories.create', ['mode' => $mode]);
    }

    function edit($id)
    {
      $mode = "edit";
      $data = Category::where('id', $id)->first();

      return view('admin.categories.create', ['mode' => $mode, 'data' => $data]);
    }

    function store(Request $request)
    {
      // Form validation
      $validated = $request->validate([
        'name' => ['required', 'unique:categories', 'min:2', 'max:50'],
      ]);

      Category::create([
        'name' => strtolower($request['name']),
        'description' => $request['description'],
      ]);

      return redirect()->route('category.manage')->with('status', 'Data kategori berhasil ditambah!');
    }

    function update(Request $request)
    {
      $data = Category::where('id', $request['id'])->first();
      $lastData = Category::where('id', $request['id'])->first();

      // Form validation
      if(strtolower($request['name']) != strtolower($lastData->name)){
        $validated = $request->validate([
          'name' => ['required', 'unique:categories', 'min:2', 'max:50'],
        ]);
      } else {
        $validated = $request->validate([
          'name' => ['required', 'min:2', 'max:50'],
        ]);
      }

      // dd($validated);
      $data->name = $request['name'];
      $data->description = $request['description'];
      $data->save();

      return redirect()->route('category.manage')->with('status', 'Data '. $lastData->name . ' berhasil diubah!');
    }

    function destroy($id)
    {
      Category::find($id)->delete();
      return response()->json([
        'success' => 'Record deleted successfully!'
      ]);
      // $lastData = Category::where('id', $id)->first();
      // Category::find($id)->delete();
      // return redirect()->route('category.manage')
      //     ->with('status', 'Data '. $lastData->name .' berhasil dihapus!');
    }
}
