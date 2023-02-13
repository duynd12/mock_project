@extends('index')

@push('css')

@endpush

@section('content')
<div class="title" style="display:flex">
    <a href="{{route('attribute.index')}}">
        <i class="fa-solid fa-arrow-left"></i>
        Quay Lại
    </a>
    <h4 style="margin-left:10px;margin-top:-5px">Sửa thuộc tính</h4>
</div>
{{-- <h1>Sửa thuộc tính</h1> --}}
<form action="{{route('attribute.update',$data['id'])}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <div class="form-group">
        <label for="exampleInputEmail1">Tên thuộc tính : </label>
        <input type="text" class="form-control" id="exampleInputEmail1" value='{{$data['name']}}' name="name" aria-describedby="emailHelp">
        @error('name')
            <span style="color:red">{{$message}}</span>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection


@push('js')

@endpush