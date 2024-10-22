@section('title')
Show product {{$product->id}}
@endsection

@include('user.layouts.head')

   <!-- ***** Preloader Start ***** -->
   <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>  
    <!-- ***** Preloader End ***** -->

@include('user.layouts.header')    

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

<div class="container">
    <div class="row">
        <div class="product d-flex">
            <img src="{{asset("storage/$product->image")}}" class="w-50 mx-4 my-4" alt="">
            <div class="details">
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
                <h1>{{$product->name}}</h1>
                <h7>{{$product->description}}</h7>
                <p>Price : {{$product->price}} $</p>
                <p>Quantity : {{$product->quantity}}</p>
            </div>
        </div>
    </div>
</div>

@include('user.layouts.footer')