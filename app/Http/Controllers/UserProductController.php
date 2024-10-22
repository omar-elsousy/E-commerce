<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Order_detail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Builder\Function_;
use PhpParser\Node\Expr\FuncCall;

class UserProductController extends Controller
{
    public function getAll()
    {
        $products=Product::all();
        return view('user.products.allProducts',compact('products'));
    }
    public function show($id){
        $product=Product::findOrFail($id);
        return view('user.products.show',compact('product'));
    }
    public function search(Request $request){
        $key=$request->key;
        $products=Product::where('name','like',"%$key%")->get();
        return view('user.products.allProducts',compact('products'));
    }
    public function add_to_cart(Request $request , $id){
        $product=Product::findOrFail($id);
        $cart=session()->get('cart');
        $qty=$request->qty;
        if(!$cart){
            //first time
            $cart=[
                $id=>[
                    'name'=>$product->name,
                    'desc'=>$product->description,
                    'price'=>$product->price,
                    'image'=>$product->image,
                    'qty'=>$qty
                ]
                ];
                session()->put('cart',$cart);
                return redirect()->back();
        }else{
            // not the first time but the same product (same product)
            if(isset($cart[$id])){
                $cart[$id]['qty']+=$qty;
                session()->put('cart',$cart);
                return redirect()->back();
            }
            // not the first time and another product (another id)
            $cart[$id]=[
                'name'=>$product->name,
                'desc'=>$product->description,
                'price'=>$product->price,
                'image'=>$product->image,
                'qty'=>$qty
            ];
            session()->put('cart',$cart);
            return redirect()->back();
        }
    }
    public function my_cart(){
        $cart=session()->get('cart');
        return view('user.products.my_cart',compact('cart'));
    }
    public function make_order(Request $request){
        $user=Auth::user();
        if(session()->get('cart')){
            $cart=session()->get('cart');
        }
        $order=Order::create([
            'user_id'=>$user->id
        ]);
        foreach($cart as $id=>$product){
            Order_detail::create([
                'order_id'=>$order->id,
                'product_id'=>$id,
                'quantity'=>$product['qty'],
                'price'=>$product['price']
            ]);
        }
        session()->flash('success','your order sent successfully');
        return redirect()->back();
    }
}
