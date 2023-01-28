@extends('index')

@section('content')
<h1 class="title">Sửa Danh Mục</h1>
<form action="{{route('category.update',$data['id'])}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="exampleInputEmail1">Tên Danh Mục : </label>
        <input type="text" class="form-control" id="exampleInputEmail1" value="{{$data['title']}}" name="title">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">ParentId : </label>
        <input type="text" class="form-control" id="exampleInputEmail1" value="{{$data['parentId']}}" name="parentId">
    </div>
    <label for="cars" style="margin-bottom:10px;">Sản phẩm : </label>
    <select name="products[]" id="cars" multiple multiselect-hide-x="true">
        @foreach($data['product_name'] as $product)
            <option selected value="{{$product->id}}">{{$product->name}}</option>
        @endforeach
        @error('categories')
        <span style="color:red">{{$message}}</span>
        @enderror
    </select>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection