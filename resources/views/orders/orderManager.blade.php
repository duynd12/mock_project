@extends('index')
@section('content')
<div class="product-manager">
    <div class="product-manager-title">
        <h1>Quản lý hóa đơn</h1>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Id khách hàng</th>
                <th scope="col">Total Price</th>
                <th scope="col">Hanlde</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <th scope="row">{{$order['id']}}</th>
                <td>{{$order['user_id']}}</td>
                <td>{{$order['total_price']}}</td>
                <td>
                    <button class="btn btn-primary">
                        <a href="{{route('orderDetail',$order['id'])}}">
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