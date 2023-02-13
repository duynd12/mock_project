@extends('index')

@section('content')
<div class="product-manager">
    <div class="product-manager-title">
        <h1>Quản lý sản phẩm</h1>
        @if(Auth::user()->rule !== __(\App\Constants\Admin::ROLE_VIEW))

        <button class="btn btn-outline-primary">
            <a href="{{route('product.create')}}">
                Thêm sản phẩm
            </a>
        </button>
        @endif
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
                @if(Auth::user()->rule === __(\App\Constants\Admin::ROLE_GOVERNOR))
                <th scope="col">Hanlde</th>
                @endif
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
                @if(Auth::user()->rule === __(\App\Constants\Admin::ROLE_GOVERNOR))
                <td style="display:flex">
                    <button class="btn btn-primary" style="margin-right:10px">
                        <a href="{{route('product.edit',$pro['id'])}}" style="color:white">
                            Edit
                        </a>
                    </button>
                    <form action="{{route('product.destroy',$pro['id'])}}" method="post" enctype="multipart/form">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger">
                                Delete
                        </button>
                    </form>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    {{$data->links()}}
</div>

@endsection