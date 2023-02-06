@extends('index')

@section('content')
<h1 class="title">Thêm Sản Phẩm</h1>
<form action="{{route('prodcut.store')}}" method="post" accept="image/*" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="exampleInputEmail1">Tên Sản Phẩm : </label>
        <input type="text" class="form-control" id="exampleInputEmail1" name="name">
    </div>
    <label for="cars" style="margin-bottom:10px;">Danh mục : </label>
    <select name="categories[]" id="cars" multiple multiselect-hide-x="true">
        @foreach($categories as $category)
        <option value="{{$category['id']}}">{{$category['title']}}</option>
        @endforeach
        @error('categories')
        <span style="color:red">{{$message}}</span>
        @enderror
    </select>

    <div class="form-group">
        <label for="exampleInputEmail1">Giá : </label>
        <input type="text" class="form-control" id="exampleInputEmail1" name="price">
    </div>
    <label for="floatingTextarea2">Mô tả : </label>
   <div class="form-floating">
        <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px" name="description"></textarea>
   </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Số lượng còn : </label>
        <input type="text" class="form-control" id="exampleInputEmail1" name="quantity">
    </div>
     <div class="form-group">
        <label for="exampleInputEmail1">Giảm Giá : </label>
        <input type="text" class="form-control" id="exampleInputEmail1" name="discount">
    </div>
    <div class="form-group">
        <!-- <input type="text" id="exampleInputEmail1" name="product_id" /> -->
        <label for="exampleInputEmail1">Ảnh Sản Phẩm : </label>
        <input type="file" id="exampleInputEmail1" name="images[]" multiple="true" />
    </div>
    <div class="form-group">
        <!-- <input type="text" id="exampleInputEmail1" name="product_id" /> -->
        <label for="exampleInputEmail1">Size : </label>
        <div class="checkbox">
            @foreach($sizes as $size)
                <input type="checkbox" value="{{ $size->id}}"name="sizes[]" multiple="true" />
            {{$size->value_name}}
            @endforeach
        </div>
    </div>
    <div class="form-group">
        <!-- <input type="text" id="exampleInputEmail1" name="product_id" /> -->
        <label for="exampleInputEmail1">Màu sắc : </label>
        <div class="checkbox">
            @foreach($colors as $color)
                <input type="checkbox" value="{{ $color->id}}"name="colors[]" multiple="true" />
            {{$color->value_name}}
            @endforeach
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection