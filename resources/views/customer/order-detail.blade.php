@extends('layouts.app')

@section('title')
    order detail
@endsection

@section('content')

    <table id="cart_summary" class="table table-bordered text-center">
        <thead>
        <tr>
            <th class="cart_product first_item text-center">Number</th>
            <th class="cart_total item text-right text-center">name</th>
            <th class="cart_total item text-right text-center">qty</th>
            <th class="cart_total item text-right text-center">price</th>
            <th class="cart_total item text-right text-center">supplier</th>
            <th class="cart_total item text-right text-center">Adress</th>
            <th class="cart_total item text-right text-center">date</th>
            <th class="cart_total item text-right text-center">status</th>

        </tr>
        </thead>
        <tbody>
        @foreach($orderdetails as $orderdetail)
            <tr>
                <td>
                    {{ $orderdetail->order_id }}
                </td>
                <td>
                    {{ $orderdetail->name }}
                </td>
                <td>
                    {{ $orderdetail->quantity }}
                </td>
                <td>
                    {{ $orderdetail->price }}
                </td>
                <td>
                    {{ suppliername($orderdetail->supplier_id) }}
                </td>
                <td>
                    {{ $orderdetail->adress }}
                </td>
                <td>
                    {{ Carbon\Carbon::parse($orderdetail->created_at)->format('d-m-Y')   }}
                </td>
                <td>
                    {{ ord_st_by_ord_id($orderdetail->order_id) }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection