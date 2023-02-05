@extends('index')

@push('css')

@endpush

@section('content')
{{-- <form action="{{route('statistic.index')}}" method="get" style="display:flex">
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
</form> --}}

<div style="width:75%;margin-bottom:30px">
    {!! $chartjs->render() !!}
</div>
<div class="container">
  <div class="row">
    <div class="col col-sm">
        <h4 class="title">Khách hàng mua nhiều tiền nhất</h4>
      <div class="info" style="
                width: 300px;
                background: #87e8de;
                padding: 20px;
                border: 2px solid #fff;
                border-radius: 10px;
                box-shadow: 0px 5px 10px 0px rgba(0, 0, 0, 0.5)
      ">
            <h3 class="info_name">Nguyen Van A</h3>
            <div style="display:grid"> 
                <span class="info_totalprice">
                    Tổng tiền đã mua : 90000
                </span>
                <span>Số điện thoại : 0912390123</span>
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