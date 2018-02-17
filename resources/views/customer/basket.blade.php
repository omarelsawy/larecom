{{--@extends('layouts.app')
@section('title')
    basket
@endsection
@section('content')

    <div class="container">
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-3">
                   {{ $product->name }}
                </div>
            @endforeach
        </div>
        <div>
            <a href="/products/checkout" class="btn-info">Checkout</a>
        </div>
    </div>

@endsection--}}








@extends('layouts.app')
@section('title')
    basket
@endsection
@section('content')

    <div id="breadcrumb" class="clearfix">
        <div class="container">
            <div class="breadcrumb clearfix">
                <h2 class="bread-title">Shopping cart</h2>
                <ul class="ul-breadcrumb">
                    <li><a href="/" title="Home">Home</a></li>
                    <li><span>shopping cart</span></li>
                </ul>
            </div>
        </div>
    </div><!-- end breadcrumb -->

    <div id="columns" class="columns-container">
        <!-- container -->
        <div class="container">
            <div id="order-detail-content" class="table_block table-responsive">
                <table id="cart_summary" class="table table-bordered">
                    <thead>
                    <tr>
                        <th class="cart_delete last_item">&nbsp;</th>
                        <th class="cart_product first_item">Product</th>
                        <th class="cart_description item">Description</th>
                        <th class="cart_unit item text-right">Unit price</th>
                        <th class="cart_quantity item text-center">Qty</th>
                        <th class="cart_total item text-right">Total With Tax</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $total=0;
                    $price=0;
                    ?>
                    @foreach($products as $product)
                        <?php
                        $price = qty($product->product_id)*handle_checkout($product->tax_id , $product->price);
                        $total += $price;
                        ?>
                    <tr>
                        <td class="cart_delete text-center">
                            <a title="Remove this item" class="remove" href="/products/basket/delete/{{$product->product_id}}">
                                <i class="fa fa-times"></i>
                            </a>
                        </td>
                        <td class="cart_product">
                            <a href="/products/page-detail/{{ $product->product_id }}">
                                <img width="80" height="80" alt="" class="img-responsive" src="/img/product/{{ $product->image }}">
                            </a>
                        </td>
                        <td class="cart_description">
                            <a href="/products/page-detail/{{ $product->product_id }}">{{ $product->description }}</a>
                        </td>
                        <td class="cart_unit text-right">
                            <span class="amount">${{ $product->price }}</span>
                        </td>
                        <td class="cart_quantity text-center">
                            <div class="quantity">
                                <button type="button" class="minus qtyajaxminus" value="{{ $product->product_id }}">-</button>
                                <input type="text" class="input-text qty text qtyajaxres" title="Qty" value="{{ qty($product->product_id) }}">
                                <button type="button" class="plus qtyajaxplus" value="{{ $product->product_id }}">+</button>
                            </div>
                        </td>
                        <td class="cart_total text-right">
                            <span class="amount">${{ qty($product->product_id)*handle_checkout($product->tax_id , $product->price) }}</span>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td rowspan="3" colspan="3"></td>
                        <td colspan="2" class="text-right">Total products</td>
                        <td colspan="1" class="price text-right" id="total_product">${{ $total }}</td>
                    </tr>
                    </tfoot>
                </table>
            </div><!-- end order-detail-content -->
            <div class="cart_navigation">
                <a href="/products/checkout" class="button btn btn-primary standard-checkout pull-right" title="Proceed to checkout">
                    <span>Proceed to checkout</span>
                    <i class="fa fa-angle-right ml-xs"></i>
                </a>
            </div><!-- end cart_navigation -->
        </div> <!-- end container -->
    </div><!--end warp-->
@endsection



