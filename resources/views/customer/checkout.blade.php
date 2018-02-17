@extends('layouts.app')
@section('title')
    checkout
@endsection
@section('content')
        <div id="breadcrumb" class="clearfix">
            <div class="container">
                <div class="breadcrumb clearfix">
                    <h2 class="bread-title">Checkout</h2>
                    <ul class="ul-breadcrumb">
                        <li><a href="/" title="Home">Home</a></li>
                        <li><span>Checkout</span></li>
                    </ul>
                </div>
            </div>
        </div><!-- end breadcrumb -->

        <div id="columns" class="columns-container">
            <!-- container -->
            <div class="container">
                <div class="page-checkout">
                    <div class="row">
                        <div class="checkoutleft col-lg-9 col-md-9 col-sm-9 col-xs-12">
                            <div class="panel-group" id="accordion">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                                Address
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne" class="accordion-body collapse in">
                                        <div class="panel-body">
                                            <form action="/products/order" id="formaddress" method="post" class="form-horizontal">
                                                {{ csrf_field() }}
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label>Country</label>
                                                        <select class="form-control">
                                                            <option value="">Select a country</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label>Address </label>
                                                        <input name="adress" type="text" value="" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <label>City </label>
                                                        <input type="text" value="" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <input type="submit" value="Save" class="btn btn-primary pull-right" data-loading-text="Loading...">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                                                Payment
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseThree" class="accordion-body collapse">
                                        <div class="panel-body">
                                            <table class="table table-bordered shop_tablecart">
                                                <thead>
                                                <tr>
                                                    <th class="product-thumbnail text-center">
                                                        Product
                                                    </th>
                                                    <th class="product-name">
                                                        Description
                                                    </th>
                                                    <th class="product-price text-right">
                                                        Price
                                                    </th>
                                                    <th class="product-quantity text-center">
                                                        Quantity
                                                    </th>
                                                    <th class="product-subtotal text-right">
                                                        Total Pay
                                                    </th>
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
                                                <tr class="cart_table_item">
                                                    <td class="product-thumbnail text-center">
                                                        <a href="/products/page-detail/{{ $product->product_id }}">
                                                            <img width="100" height="100" alt="" class="img-responsive" src="/img/product/{{ $product->image }}">
                                                        </a>
                                                    </td>
                                                    <td class="product-name">
                                                        <a href="/products/page-detail/{{ $product->product_id }}">{{ $product->description }}</a>
                                                    </td>
                                                    <td class="product-price text-right">
                                                        <span class="amount">${{ $product->price }}</span>
                                                    </td>
                                                    <td class="product-quantity text-center">
                                                        {{ qty($product->product_id) }}
                                                    </td>
                                                    <td class="product-subtotal text-right">
                                                        <span class="amount">${{ qty($product->product_id)*handle_checkout($product->tax_id , $product->price) }}</span>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                </tbody>
                                            </table>

                                            <hr class="tall">

                                            <h4 class="heading-primary">Cart Totals</h4>
                                            <table class="table cart-totals">
                                                <tbody>
                                                <tr class="shipping">
                                                    <th>
                                                        Shipping
                                                    </th>
                                                    <td>
                                                        Free Shipping<input type="hidden" value="free_shipping" class="shipping_method" name="shipping_method">
                                                    </td>
                                                </tr>
                                                <tr class="total">
                                                    <th>
                                                        <strong>Order Total</strong>
                                                    </th>
                                                    <td>
                                                        <strong><span class="amount">${{$total}}</span></strong>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <hr class="tall">

                                            <h4 class="heading-primary">Payment</h4>

                                            <form action="/" id="frmPayment" method="post">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <span class="remember-box checkbox">
                                                            <label>
                                                                <input type="checkbox">Pay by bank wire (order processing will be longer)
                                                            </label>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <span class="remember-box checkbox">
                                                            <label>
                                                                <input type="checkbox">Pay by check (order processing will be longer)
                                                            </label>
                                                        </span>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="actions-continue pull-right">
                                <input type="submit" value="I confirm my order" name="proceed" class="btn btn-primary">
                            </div>
                        </div>
                        <div class="checkoutright col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <h4 class="title_block">Cart Totals</h4>
                            <table class="table cart-totals">
                                <tbody>
                                <tr class="total">
                                    <th>
                                        <strong>Order Total</strong>
                                    </th>
                                    <td>
                                        <strong><span class="amount">${{ $total }}</span></strong>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <a class="pull-right" href="/products/listorders">list orders</a>
                        </div>
                    </div>
                </div>
            </div> <!-- end container -->
        </div><!--end warp-->

@endsection