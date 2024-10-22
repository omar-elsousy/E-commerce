@section('title')
My cart
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

@if(session()->get('success'))
<div class="alert alert-success">{{session()->get('success')}}</div>
@endif

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>



<div class="container">
@if(session()->get('success'))
<div class="alert alert-success">{{session()->get('success')}}</div>
@endif
    <div class="row">
    @foreach($cart as $key=>$value)
<div class="col-md-3">
        <div class="product-item">
        <img src="{{ asset("storage/{$value['image']}") }}" alt="">
        <div class="down-content">
            <a href="#">
              <h4>{{$value['name']}}</h4>
            </a>
            <h6>{{$value['price']}} $</h6>
            <p>{{$value['desc']}}</p>
            <p>Quantity : {{$value['qty']}}</p>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    <form action="{{url('make_order')}}" method="post">
      @csrf
      <button type="submit" class="btn btn-info mt-2">{{__('message.Make order')}}</button>
    </form>
</div>


@include('user.layouts.footer')