@section('title')
All products
@endsection

@extends('admin.layouts.main')

@section('body')

@if($errors->any())
@foreach($errors->all() as $error)
<div class="alert alert-danger">{{$error}}</div>
@endforeach
@endif

@if(session('success'))
<div class="alert alert-success">{{session('success')}}</div>
@endif

<table class="table">
<thead>
<tr>
<th scope="col">Id</th>
<th scope="col">Name</th>
<th scope="col">price</th>
<th scope="col">Quantity</th>
<th scope="col">description</th>
<th scope="col">image</th>
</tr>
</thead>
<tbody>
@foreach ($products as $product )
<tr>
<th scope="row">{{$loop->iteration}}</th>
<td>{{$product->name}}</td>
<td>{{$product->price}}</td>
<td>{{$product->quantity}}</td>
<td>{{$product->description}}</td>
<td><img src="{{asset("storage/$product->image")}}" width="100px"
alt="" srcset=""></td>
<td>
<form action="{{url("product/delete/$product->id")}}"
method="get">
@csrf
<!-- @method('DELETE') -->
<button type="submit" class="btn
btn-danger">delete</button>
</form>
<h1>
<a class="btn btn-success"
href="{{url("product/edit/$product->id")}}" >edit</a>
</h1>
</td>
</tr>
@endforeach
</tbody>
</table>

@endsection