@extends('index')

@section('content')
<div class="title" style="display:flex">
    <a href="{{route('product.index')}}">
        <i class="fa-solid fa-arrow-left"></i>
        Quay Lại
    </a>
    <h4 style="margin-left:10px;margin-top:-5px">Thêm Sản Phẩm</h4>
</div>
<form action="{{route('prodcut.store')}}" method="post" accept="image/*" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="exampleInputEmail1">Tên Sản Phẩm : </label>
        <input type="text" class="form-control" id="exampleInputEmail1" name="name">
        @error('name')
        <span style="color:red">{{$message}}</span>
        @enderror
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
        @error('price')
        <span style="color:red">{{$message}}</span>
        @enderror
    </div>
    <label for="floatingTextarea2">Mô tả : </label>
   <div class="form-floating">
        <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px" name="description"></textarea>
        @error('description')
        <span style="color:red">{{$message}}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Số lượng còn : </label>
        <input type="text" class="form-control" id="exampleInputEmail1" name="quantity">
        @error('quantity')
        <span style="color:red">{{$message}}</span>
        @enderror
    </div>
     <div class="form-group">
        <label for="exampleInputEmail1">Giảm Giá : </label>
        <input type="number" class="form-control" id="exampleInputEmail1" name="discount">
        @error('discount')
        <span style="color:red">{{$message}}</span>
        @enderror
    </div>
    <div class="form-group">
        <!-- <input type="text" id="exampleInputEmail1" name="product_id" /> -->
        <label for="exampleInputEmail1">Ảnh Sản Phẩm : </label>
        <input type="file" id="exampleInputEmail1" name="images[]" multiple="true" />
    </div>
    @error('images.*')
    <span style="color:red">{{$message}}</span>
    @enderror
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