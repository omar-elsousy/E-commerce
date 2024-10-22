<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getAll()
    {
        $products=Product::all();
        return view('admin.products.allProducts',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data=$request->validate([
            'name'=>'required|string|max:200',
            'description'=>'required|string',
            'price'=>'required|numeric|min:0',
            'quantity'=>'required|integer',
            'image'=>'nullable|max:2048|mimes:png,jpg,jepg'
        ]);
            
        if($request->hasFile('image')){
            $data['image']=Storage::putFile('products',$request->image);
        }
        Product::create($data);
        session()->flash('success','product created successfully');
        return redirect('products');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product=Product::findOrFail($id);
        return view('admin.products.edit',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data=$request->validate([
            'name'=>'required|string|max:200',
            'description'=>'required|string',
            'price'=>'required|numeric|min:0',
            'quantity'=>'required|integer',
            'image'=>'nullable|max:2048|mimes:png,jpg,jepg'
        ]);
        $product=Product::findOrFail($id);
        if($request->hasFile('image')){
            Storage::delete($product->id);
            $data['image']=Storage::putFile('products',$request->image);
        }
        $product->update($data);
        session()->flash('success','product updated successfully');
        return redirect('products');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $product=Product::findOrFail($id);
        if($product->image){
            Storage::delete($product->image);
        }
        $product->delete();
        session()->flash('success','product deleted successfully');
        return redirect('products');
    }
}
