@extends('index')

@section('content')
<h1 class="title">Sửa Danh Mục</h1>
<form action="{{route('edit-category',$data['id'])}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="exampleInputEmail1">Tên Sản Phẩm : </label>
        <input type="text" class="form-control" id="exampleInputEmail1" value="{{$data['title']}}" name="title">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Mô tả : </label>
        <input type="text" class="form-control" id="exampleInputEmail1" value="{{$data['description']}}" name="description">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">ParentId : </label>
        <input type="text" class="form-control" id="exampleInputEmail1" value="{{$data['parentId']}}" name="parentId">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection