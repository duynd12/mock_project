@extends('index')

@push('css')

@endpush

@section('content')
<h1>Sửa value thuộc tính</h1>
<form action="{{route('attributeValue.update',$id)}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="exampleInputEmail1">Tên Vaue thuộc tính : </label>
        <input type="text" class="form-control" id="exampleInputEmail1" value='{{$data['value_name']}}' name="value_name" aria-describedby="emailHelp">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection


@push('js')

@endpush