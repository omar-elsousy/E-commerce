<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ApiProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getAll()
    {
        $products=Product::all();
        if(!empty($products)){
            return response()->json([
            'status'=>'success',
            'data'=>ProductResource::collection($products),
        ],200);
        }else{
            return response()->json([
                'status'=>'success',
                'data'=>'there is no data'
            ],404);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate=Validator::make($request->all(),[
            'name'=>'required|string|max:200',
            'description'=>'required|string',
            'price'=>'required|numeric|min:0',
            'quantity'=>'required|integer',
            'image'=>'nullable|max:2048|mimes:png,jpg,jepg'
        ]);
        if($validate->fails()){
            return response()->json([
                'msg'=>$validate->errors()
            ]);
        }
        if($request->hasFile('image')){
            $image=Storage::putFile('products',$request->image);
        }
        Product::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'price'=>$request->price,
            'quantity'=>$request->quantity,
            'image'=>$image
        ]);
        return response()->json([
            'status'=>'success',
            'msg'=>'product created successfully'
        ],200);
    }


    public function update(Request $request,$id){
        $validate=Validator::make($request->all(),[
            'name'=>'required|string|max:200',
            'description'=>'required|string',
            'price'=>'required|numeric|min:0',
            'quantity'=>'required|integer',
            'image'=>'nullable|max:2048|mimes:png,jpg,jepg'
        ]);
        $product=Product::find($id);
        $image=$product->image;
        if($validate->fails()){
            return response()->json([
                'msg'=>$validate->errors()
            ]);
        }
        if($request->hasFile('image')){
            Storage::delete($image);
            $image=Storage::putFile('products',$request->image);
        }
        $product->update([
            'name'=>$request->name,
            'description'=>$request->description,
            'price'=>$request->price,
            'quantity'=>$request->quantity,
            'image'=>$image
        ]);
        return response()->json([
            'status'=>'success',
            'msg'=>'product updated successfully'
        ],200);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product=Product::find($id);
        if($product){
            return response()->json([
                'status'=>'success',
                'data'=>new ProductResource($product)
            ],200);
        }else{
            return response()->json([
                'status'=>'success',
                'data'=>'there is no data'
            ],404);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $product=Product::find($id);
        if($product->image){
            Storage::delete($product->image);
        }
        $product->delete();
        return response()->json([
            'msg'=>'product deleted successfully'
        ],200);
    }
}
