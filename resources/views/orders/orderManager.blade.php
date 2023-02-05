@extends('index')
@section('content')
<div class="product-manager">
    <div class="product-manager-title">
        <h1>Quản lý đơn hàng</h1>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Id khách hàng</th>
                <th scope="col">Total Price</th>
                <th scope="col">Ngày Đặt Hàng</th>
                <th scope="col">Trạng Thái</th>
                <th scope="col">Hanlde</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <th scope="row">{{$order['id']}}</th>
                <td>{{$order['user_id']}}</td>
                <td>{{$order['total_price']}}</td>
                <td>{{$order['order_date']}}</td>
                <td>{{$order['status']}}</td>

                <td>
                    <button class="btn btn-primary">
                        <a href="{{route('order.show',$order['id'])}}" style="color:white">
                            Xem chi tiết
                        </a>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection