@extends('index')

@section('content')
<div class="product-manager">
    <div class="product-manager-title">
        <h3>Chi tiết đơn hàng</h3>
    </div>
    <hr>
    <div class="container">
        <div class="info">
            <h5 class="title-name">
                Tên người nhận : Nguyen Van A</h5>
            <h5 class="info-address">
               Địa chỉ nhận: {{$info_user->shipping_address}}</h5>
            </h5>
            <h5 class="info-email">Email : a123@gmail.com</h5>
            <span class="info-shipping_tracking">Trạng thái : Da Hoan Thanh</span>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Đơn hàng chi tiết số</th>
                <th scope="col">Mã số sản phẩm</th>
                <th scope="col">Tên sản phẩm</th>
                <th scope="col">Giá</th>
                <th scope="col">Số Lượng</th>
                <th scope="col">Kích Thước</th>
                <th scope="col">Màu Sắc</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $order)
            <tr>
                <th scope="row">{{$order->id}}</th>
                <td>{{$order->product_id}}</td>
                <td>{{$order->name}}</td>
                <td>{{$order->price}}</td>
                <td>{{$order->quantity}}</td>
                <td>{{$order->size}}</td>
                <td>{{$order->color}}</td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection