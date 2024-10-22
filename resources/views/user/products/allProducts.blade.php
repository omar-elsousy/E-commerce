@section('title')
Home
@endsection

@section('body')

@foreach($products as $product)
<div class="col-md-3">
        <div class="product-item">
          <a href="{{url("showProduct/$product->id")}}"><img src="{{asset("storage/$product->image")}}" alt=""></a>
          <div class="down-content">
            <a href="#">
              <h4>{{$product->name}}</h4>
            </a>
            <h6>{{$product->price}} $</h6>
            <p>{{$product->description}}</p>
            <p>Quantity : {{$product->quantity}}</p>
            <ul class="stars">
              <li><i class="fa fa-star"></i></li>
              <li><i class="fa fa-star"></i></li>
              <li><i class="fa fa-star"></i></li>
              <li><i class="fa fa-star"></i></li>
              <li><i class="fa fa-star"></i></li>
            </ul>
            <span>Reviews (24)</span>
          </div>
          <form action="{{url("add_to_cart/$product->id")}}" method="post">
              @csrf
              <input type="number" name="qty" id="" placeholder="{{__('message.Enter quantity')}}">
              <button type="submit" class="btn btn-info mt-2">{{__('message.Add to cart')}}</button>
            </form>
        </div>
      </div>
      @endforeach

@endsection

@extends('user.layouts.main')