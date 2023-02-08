@extends('index')

@section('content')
<div class="product-manager">
    <div class="product-manager-title">
        <h3>Chi tiết đơn hàng</h3>
    </div>
    <hr>
    <div class="container" style="margin-bottom:20px">
        <div class="info" style="padding-top:10px">
            <h5 class="title-name" style="margin-bottom:10px">
                Tên người nhận : {{$info_user->receiver}}</h5>
            <h5 class="info-address" style="margin-bottom:10px">
               Địa chỉ nhận: {{$info_user->shipping_address}}</h5>
            </h5>
            <h5 class="info-email" style="margin-bottom:8px">Email : {{$info_user->delivery_email}}</h5>
            <span class="info-shipping_tracking" style="margin-bottom:8px">Trạng thái : {{$info_user->shipping_tracking}}</span>
            <h6 class="info-total_price">Tổng tiền : {{$data[0]->total_price}} VND</h6>
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
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection