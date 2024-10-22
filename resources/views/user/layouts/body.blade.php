<div class="latest-products">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="h">
        <form action="{{url('search')}}" method="get">
          @csrf
          <input type="text" name="key" class="form-control" value="{{old('key')}}" placeholder="{{__('message.Search products')}}">
          <button type="submit" class="btn btn-info mt-2">{{__('message.Search')}}</button>
        </form>
        </div>
        <br>
        <div class="section-heading">
          <h2>{{__('message.Latest products')}}</h2>
          <a href="allProducts">{{__('message.View All Products')}} <i class="fa fa-angle-right"></i></a>
        </div>
      </div>
      @yield('body')
    </div>
  </div>
</div>