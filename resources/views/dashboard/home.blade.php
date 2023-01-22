@extends('index')

@section('content')
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="stat-widget-five">
                    <div class="stat-icon dib flat-color-1">
                        <i class="pe-7s-cash"></i>
                    </div>
                    <div class="stat-content">
                        <div class="text-left dib">
                            <div class="stat-text"><span class="count">{{$total_price}}</span></div>
                            <div class="stat-heading">Total Price</div>
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
                    <div class="stat-icon dib flat-color-2">
                        <i class="pe-7s-cart"></i>
                    </div>
                    <div class="stat-content">
                        <div class="text-left dib">
                            <div class="stat-text"><span class="count">{{$user_count}}</span></div>
                            <div class="stat-heading">User</div>
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
</div>
@endsection