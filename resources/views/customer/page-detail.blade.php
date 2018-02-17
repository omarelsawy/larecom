@extends('layouts.app')
@section('title')
    page-detail
    @endsection

@section('content')

    <div id="breadcrumb" class="clearfix">
        <div class="container">
            <div class="breadcrumb clearfix">
                <h2 class="bread-title">Products Detail</h2>
                <ul class="ul-breadcrumb">
                    <li><a href="/" title="Home">Home</a></li>
                    <li><a href="page-category-left.html" title="Fashion">Fashion</a></li>
                    <li><span>{{ $product->name }}</span></li>
                </ul>
            </div>
        </div>
    </div><!-- end breadcrumb -->

    <div id="columns" class="columns-container">
        <!-- container -->
        <div class="container">
            <div class="row">
                <div class="pb-left-column col-xs-12 col-sm-12 col-md-5">
                    <div id="image-block" class="clearfix">
                        <div id="view_full_size">
                            <img src="/img/product/{{$product->image}}" class="img-responsive" width="470" height="564">
                        </div>
                    </div><!-- end #image-block -->

                </div><!-- end pb-left-column -->
                <div class="pb-center-column col-xs-12 col-sm-12 col-md-7">
                    <div class="pb-centercolumn">
                        <h1>{{ $product->name }}</h1>
                         Supplier:{{suppliername($product->supplier_id)}}
                        <div class="price clearfix">
                            <p class="our_price_display">
                                ${{ handle_checkout($product->tax_id , $product->price) }}
                            </p>
                            @if($product->tax_id != null)
                                    (With Tax)
                            @endif
                        </div><!-- end price -->
                        <div id="short_description_block">
                            <p>{{ $product->description }}</p>
                        </div><!-- end short_description_block -->
                        <div class="box-info-product clearfix">
                            <div id="quantity_wanted_p">
                                <label>Quantity</label>
                                <div class="group-quantity">
                                    {{$product->quantity}}
                                </div>
                            </div>
                        </div><!-- end box-info-product -->
                        <div class="box-cart-bottom clearfix">
                            {{--<button type="button" class="exclusive btn btn-primary addtocart" value="{{ $product->product_id }}">Add to cart</button>--}}
                            <form action="/addtocart" method="post">
                                {{csrf_field()}}
                                <input type="hidden" name="id" value="{{ $product->product_id }}">
                            <button type="submit" class="exclusive btn btn-primary addtocart">Add to cart</button>
                            </form>
                        </div><!-- end box-cart-bottom -->

                    </div><!-- end pb-centercolumn -->
                </div><!-- end pb-center-column -->
            </div><!-- end row -->
        </div> <!-- end container -->
    </div><!--end warp-->

    @endsection