@extends('index')

@section('content')
<h1 class="title">Sửa Sản Phẩm</h1>
<form method="post" enctype="multipart/form-data" action="{{route('product.update',$data['id'])}}">
    @csrf
    <div class="form-group">
        <label for="exampleInputEmail1">Tên Sản Phẩm : </label>
        <input type="text" class="form-control" id="exampleInputEmail1" name="name" value="{{$data['name']}}">
                @error('name')
        <span style="color:red">{{$message}}</span>
        @enderror
    </div>
    <label for="cars" style="margin-bottom:10px;">Danh mục : </label>
   <select name="categories[]" id="cars" multiple multiselect-hide-x="true">
        @foreach($categories as $category)
            <option {{$data->categories->contains('id',$category->id) ? "selected":""}} value="{{$category->id}}">{{$category->title}}</option>
        @endforeach
        @error('categories')
        <span style="color:red">{{$message}}</span>
        @enderror
    </select>
    <div class="form-group">
        <!-- <input type="text" id="exampleInputEmail1" name="product_id" /> -->
        <label for="exampleInputEmail1">Màu sắc : </label>
        <div class="checkbox">
            @foreach($colors as $color)
                <input type="checkbox" {{$data['colors']->contains('id',$color->id) ? "checked":""}} value="{{ $color->id}}"name="colors[]" multiple="true" />
            {{$color->value_name}}
            @endforeach
        </div>
    </div>
    <div class="form-group">
        <!-- <input type="text" id="exampleInputEmail1" name="product_id" /> -->
        <label for="exampleInputEmail1">Size : </label>
        <div class="checkbox">
            @foreach($sizes as $size)
                <input type="checkbox" {{$data['sizes']->contains('id',$size->id) ? "checked":""}} value="{{ $size->id}}"name="sizes[]" multiple="true" />
            {{$size->value_name}}
            @endforeach
        </div>
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Giá : </label>
        <input type="text" class="form-control" id="exampleInputEmail1" name="price" value="{{$data['price']}}">
    @error('price')
        <span style="color:red">{{$message}}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Mô tả : </label>
    <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px" name="description" >{{$data['description']}}</textarea>

        {{-- <input type="text" class="form-control" id="exampleInputEmail1" name="description" value="{{$data['description']}}"> --}}
    @error('description')
        <span style="color:red">{{$message}}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Số lượng còn : </label>
        <input type="text" class="form-control" id="exampleInputEmail1" name="quantity" value="{{$data['quantity']}}">
    @error('quantity')
        <span style="color:red">{{$message}}</span>
        @enderror
    </div>
   
    

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection