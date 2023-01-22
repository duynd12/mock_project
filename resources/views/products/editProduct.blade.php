@extends('index')

@section('content')
<h1 class="title">Sửa Sản Phẩm</h1>
<form method="post" enctype="multipart/form-data" action="{{route('edit-product',$data['id'])}}">
    @csrf
    <div class="form-group">
        <label for="exampleInputEmail1">Tên Sản Phẩm : </label>
        <input type="text" class="form-control" id="exampleInputEmail1" name="name" value="{{$data['name']}}">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Giá : </label>
        <input type="text" class="form-control" id="exampleInputEmail1" name="price" value="{{$data['price']}}">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Mô tả : </label>
        <input type="text" class="form-control" id="exampleInputEmail1" name="description" value="{{$data['description']}}">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Số lượng còn : </label>
        <input type="text" class="form-control" id="exampleInputEmail1" name="quantity" value="{{$data['quantity']}}">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection