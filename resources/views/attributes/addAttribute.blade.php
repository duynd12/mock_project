@extends('index')

@push('css')

@endpush

@section('content')
<div class="title" style="display:flex">
    <a href="{{route('attribute.index')}}">
        <i class="fa-solid fa-arrow-left"></i>
        Quay Lại
    </a>
    <h4 style="margin-left:10px;margin-top:-5px">Thêm thuộc tính</h4>
</div>
<form action="{{route('attribute.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="exampleInputEmail1">Tên thuộc tính : </label>
        <input type="text" class="form-control" id="exampleInputEmail1" name="name" aria-describedby="emailHelp">
        @error('name')
            <span style="color:red">{{$message}}</span>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection


@push('js')

@endpush