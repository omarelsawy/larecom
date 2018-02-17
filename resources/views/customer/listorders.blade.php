@extends('layouts.app')

@section('title')
    list orders
    @endsection

@section('content')
    <table id="cart_summary" class="table table-bordered text-center">
        <thead>
        <tr>
            <th class="cart_product first_item text-center">Number</th>
            <th class="cart_total item text-right text-center">date</th>
            <th class="cart_total item text-right text-center">status</th>

        </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
        <tr>
            <td>
                <a href="/order-details/{{ $order->order_id }}">{{ $order->order_id }}</a>
            </td>
            <td>
                {{ Carbon\Carbon::parse($order->created_at)->format('d-m-Y')   }}
            </td>
            <td>
                {{ ord_st_by_ord_id($order->order_id) }}
            </td>
        </tr>
            @endforeach
        </tbody>
    </table>

@endsection