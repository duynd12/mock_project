@extends('index')

@push('css')

@endpush

@section('content')
<div style="width:75%;margin-bottom:30px">
    {!! $chartjs->render() !!}
</div>
<div class="container">
  <div class="row">
    <div class="col col-sm">
        <h4 class="title">Khách hàng mua nhiều tiền nhất</h4>
      <div class="info" style="
                width: 400px;
                background: #87e8de;
                padding: 20px;
                border: 2px solid #fff;
                border-radius: 10px;
                box-shadow: 0px 5px 10px 0px rgba(0, 0, 0, 0.5)">
            <h3 class="info_name">Họ tên : {{$customer_buy_info->name}}</h3>
            <div style="display:grid"> 
                <span class="info_totalprice">
                    Tổng tiền đã mua : {{$customer_buy->total_spending}} VND
                </span>
                <span>Số điện thoại : {{$customer_buy_info->numberPhone!=null ? $customer_buy_info->numberPhone : ' chưa có'}}</span>
            </div>
      </div>
    </div>
  </div>
</div>
<div class="container" style="margin-top:20px">
  <div class="row">
      <h4 class="title">Sản phẩm bán nhiều nhất</h4>
      @foreach($data as $product)
      <div class="col col-sm">
            <div class="info" style="
                width: 400px;
                background: #d3adf7;
                padding: 20px;
                border: 2px solid #fff;
                box-shadow: 0px 5px 10px 0px rgba(0, 0, 0, 0.5);
                border-radius: 10px;
                margin-bottom:60px;">
                    <h3 class="info_name">Tên sản phẩm : {{ $product->name}}</h3>
                    <div style="display:grid"> 
                        <span class="info_quantity">
                            Số lượng đá bán : {{$product->total_quantity}} cái
                        </span>
                    </div>
            </div>
        </div>
        @endforeach
   
  </div>
</div>


@endsection


@push('js')

@endpush