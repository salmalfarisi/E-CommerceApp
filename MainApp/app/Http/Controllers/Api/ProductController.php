<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Product as Product;
use Session;
use File;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::where('is_delete', false)->get();
		$array = [];
		foreach($data as $datas)
		{
			array_push($array, $datas);
		}
		
		return $this->sendResponse(true, $array, 'Index data');
    }
	
	public function indexbyuserid($id)
	{
		$data = Product::where('is_delete', false)->where('user_id', $id)->get();
		$array = [];
		foreach($data as $datas)
		{
			array_push($array, $datas);
		}
		
		return $this->sendResponse(true, $array, 'Index data');
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
		$validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'stock' => 'required|numeric',
            'price' => 'required|numeric',
            'image' => 'required|mimes:jpg,png,jpeg',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
		
		$data = new Product();
		$data->name = $request->name;
		$data->stock = $request->stock;
		$data->price = $request->price;
		$data->user_id = $request->user_id;
		
		$file = $request->file('image');
		$ext = $file->getClientOriginalExtension();
		$name = rand(100000,999999).".".$ext;
		$namafile = $name;
			
		$file->move(public_path('product'), $namafile);
			
		$data->image = $namafile;
		
		$data->save();
		
		return $this->sendResponse(true, [], 'Product successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Product::findOrFail($id);
		return $this->sendResponse(true, $data, 'Detail data');
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'stock' => 'required|numeric',
            'price' => 'required|numeric',
            'image' => 'mimes:jpg,png,jpeg',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
		
		$data = Product::find($id);
		$data->name = $request->name;
		$data->stock = $request->stock;
		$data->price = $request->price;
		$data->user_id = $request->user_id;
		
		if($request->hasFile('image'))
		{
			$file = $request->file('image');
			$ext = $file->getClientOriginalExtension();
			$name = rand(100000,999999).".".$ext;
			$namafile = $name;
			
			$file->move(public_path('product'), $namafile);
			
			$data->image = $namafile;
		}
		
		$data->save();
		
		return $this->sendResponse(true, [], 'Product successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Product::find($id);
		$data->is_delete = true;
		$data->save();
		
		return $this->sendResponse(true, [], 'Product successfully delete');
    }
}
