@extends('index')

@section('content')
<div class="product-manager">
    <div class="product-manager-title">
        <h1>Quản lý sản phẩm</h1>
        <button class="btn btn-outline-primary">
            <a href="{{route('product.create')}}">
                Thêm sản phẩm
            </a>
        </button>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Tên sản phẩm</th>
                <th scope="col">Giá</th>
                <th scope="col">Giảm Giá</th>
                <th scope="col">Mô tả</th>
                <th scope="col">Số lượng còn</th>
                <th scope="col">Ảnh</th>
                <th scope="col">Hanlde</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $pro)
            <tr>
                <th scope="row">{{$pro['id']}}</th>
                <td>{{$pro['name']}}</td>
                <td>{{$pro['price']}}</td>
                <td>{{$pro['discount']}} %</td>
                <td>{{$pro['description']}}</td>
                <td>{{$pro['quantity']}}</td>
                <td>
                    @foreach($pro->images as $image)
                        <img src="{{asset('storage/uploads/'."$image->product_img")}}"
                                style="max-width: 50px; max-heigh: 50px">
                    @endforeach
                </td>
                <td>
                    <button class="btn btn-primary">
                        <a href="{{route('product.edit',$pro['id'])}}" style="color:white">
                            Edit
                        </a>
                    </button>
                    <button class="btn btn-danger">
                        <a href="{{route('product.destroy',$pro['id'])}}" style="color:white">
                            Delete
                        </a>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{$data->links()}}
</div>

@endsection