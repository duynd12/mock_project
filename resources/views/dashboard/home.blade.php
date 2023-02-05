@extends('index')

@section('content')
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="card" style="background:#00c292">
            <div class="card-body">
                <div class="stat-widget-five">
                    <div class="stat-icon dib flat-color-1">
                        <i class="pe-7s-cash"></i>
                    </div>
                    <div class="stat-content">
                        <div class="text-left dib">
                            <i class="icon fade-5 icon-lg pe-7s-cart"></i>
                            <div class="stat-text"><span class="count">{{$total_price}} </span></div>
                            <div class="stat-heading" style="color:white">Total Price</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card" style="background:#03a9f3">
            <div class="card-body">
                <div class="stat-widget-five">
                    <div class="stat-icon dib flat-color-2">
                        <i class="pe-7s-cart"></i>
                    </div>
                    <div class="stat-content">
                        <div class="text-left dib">
                            <div class="stat-text"><span class="count">{{$user_count}}</span></div>
                            <div class="stat-heading" style="color:white">User</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="stat-widget-five">
                    <div class="stat-icon dib flat-color-1">
                        <i class="pe-7s-cash"></i>
                    </div>
                    <div class="stat-content">
                        <div class="text-left dib">
                            <div class="stat-text"><span class="count">{{$product_count}}</span></div>
                            <div class="stat-heading">Tổng sản phẩm</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="title">
            <h3 class="title-name">Các đơn hàng trong ngày</h3>
            <div class="search">
                <form action="{{route('home.index')}}" method="get" style="display:flex">
                    <div class="search-input" style="display: flex;">
                        <div class="form-group">
                            <input type="date" class="form-control input-sm" name="start_date" aria-describedby="emailHelp" >
                        </div>
                        <div class="form-group" style="margin-left:20px">
                            <input type="date" class="form-control" name="end_date" aria-describedby="emailHelp" >
                        </div>
                    </div>
                    <button type="submit" class="btn btn-outline-primary" style="margin-left:20px;height:38px">
                        Search
                    </button>
                </form>
            </div>  
        </div>
        @if(count($orders) == 0)
            <h3 class="text-center">Chưa có đơn hàng nào trong ngày</h3>
        @else
            <div class="content">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Id khách hàng</th>
                            <th scope="col">Total Price</th>
                            <th scope="col">Ngày Đặt Hàng</th>
                            <th scope="col">Trạng Thái</th>
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
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endIf
    </div>
</div>
@endsection