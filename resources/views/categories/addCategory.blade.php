@extends('index')


@section('content')
<h1 class="title">Thêm Danh Mục</h1>
<form action="{{route('category.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="exampleInputEmail1">Title : </label>
        <input type="text" class="form-control" id="exampleInputEmail1" name="title" aria-describedby="emailHelp">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Trạng thái : </label>
        <select class="custom-select" name="status"> 
            @foreach(App\Constants\Category::ARRAY_STATUS as $data)
                <option value="{{$data}}" selected>{{$data}}</option>
            @endforeach  
        </select> 
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection