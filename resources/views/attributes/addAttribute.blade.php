@extends('index')

@push('css')

@endpush

@section('content')
<h1>Thêm thuộc tính</h1>
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