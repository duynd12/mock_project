@extends('index')

@section('content')
<h1 class="title">Thêm Sản Phẩm</h1>
<form action="{{url('createProduct')}}" method="post" accept="image/*" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="exampleInputEmail1">Tên Sản Phẩm : </label>
        <input type="text" class="form-control" id="exampleInputEmail1" name="name">
    </div>
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
        <!-- <input type="text" id="exampleInputEmail1" name="product_id" /> -->
        <label for="exampleInputEmail1">Ảnh Sản Phẩm : </label>
        <input type="file" id="exampleInputEmail1" name="images[]" multiple="true" />
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection