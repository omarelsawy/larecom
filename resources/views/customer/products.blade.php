{{--@extends('layouts.app')
@section('title')
    products
@endsection
@section('content')

    <div class="container">
        <div class="row">
            @foreach($allproducts as $product)
              <div class="col-md-3">
                   {{ $product->name }}
                   <p>{{ $product->description }}</p>
                       <button type="button" class="addtocart" value="{{ $product->product_id }}">add to cart</button>
              </div>
            @endforeach
        </div>
    </div>

@endsection--}}







@extends('layouts.app')
@section('title')
    products
@endsection
@section('content')

    <div id="columns" class="columns-container">
        <!-- container -->
        <div class="container">

            <!-- tabs-top -->
            <div class="tabs-top block">

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="new-arrivals">
                        <div class="block_content">
                            <div class="tabproduct-carousel owl-carousel">
                               @foreach($allproducts as $product)
                                <div class="item">
                                    <div class="product-container">
                                        <div class="left-block">
                                            <div class="product-image-container">
                                                @if(!empty($product->image))
                                                <a class="product_img_link" href="/products/page-detail/{{ $product->product_id }}" title="{{$product->name}}">
                                                    <img src="/img/product/{{ $product->image }}" alt="{{$product->name}}" class="img-responsive image-effect" width="414" height="498">
                                                </a>
                                                @else
                                                 <a class="product_img_link" href="/products/page-detail/{{ $product->product_id }}" title="{{$product->name}}">
                                                    <img src="/img/product/1.jpg" alt="{{$product->name}}" class="img-responsive image-effect" width="414" height="498">
                                                 </a>
                                                @endif

                                                {{--<span class="label-new label">New</span>
                                                <span class="label-sale label">Sale</span>
                                                <span class="label-reduction label">-5%</span>--}}
                                            </div>
                                            <div class="box-buttons">
                                                <div class="box-buttons-left">
                                                    <a class="button btn btn-default" href="/products/page-detail/{{ $product->product_id }}">Add to cart</a>
                                                </div>
                                                <div class="box-buttons-right">
                                                    <a class="button btn addToWishlist" href="#" title="Add to my wishlist">
                                                        <i class="pe-7s-like"></i>
                                                    </a>
                                                    <a class="button btn add_to_compare" href="#" title="Quick view">
                                                        <i class="pe-7s-search"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div><!--end left block -->
                                        <div class="right-block">
                                            <div class="product-box">
                                                <h5 class="name">
                                                    <a class="product-name" href="/products/page-detail/{{ $product->product_id }}">
                                                        {{ $product->name }}
                                                    </a>
                                                </h5>
                                                <div class="content_price">
                                                    <span class="price product-price">${{ handle_checkout($product->tax_id , $product->price) }}</span>
                                                    @if($product->tax_id != null)
                                                    (With Tax)
                                                    @endif
                                                </div>
                                            </div><!--end right block -->
                                        </div>
                                    </div><!-- end product-container-->
                                </div>
                               @endforeach

                            </div><!-- end tabproduct-carousel -->
                        </div><!-- end block_content -->
                    </div><!-- end tab #home -->

                </div>
            </div><!-- end tabs-top -->

        </div> <!-- end container -->
    </div><!--end warp-->
@endsection