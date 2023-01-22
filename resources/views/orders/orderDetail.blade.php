@extends('index')

@section('content')
<div class="product-manager">
    <div class="product-manager-title">
        <h1>Quản lý chi tiết hóa đơn</h1>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">order_id</th>
                <th scope="col">product_id</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $order)
            <tr>
                <th scope="row">{{$order['id']}}</th>
                <td>{{$order['order_id']}}</td>
                <td>{{$order['product_id']}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection