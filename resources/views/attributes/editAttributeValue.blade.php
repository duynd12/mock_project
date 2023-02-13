@extends('index')

@push('css')

@endpush

@section('content')
<h1>Sửa value thuộc tính</h1>
<form action="{{route('attributeValue.update',$data['id'])}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <div class="form-group">
        <label for="exampleInputEmail1">Tên Vaue thuộc tính : </label>
        <input type="text" class="form-control" id="exampleInputEmail1" value='{{$data['value_name']}}' name="value_name" aria-describedby="emailHelp">
        @error('value_name')
            <span style="color:red">{{$message}}</span>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection


@push('js')

@endpush