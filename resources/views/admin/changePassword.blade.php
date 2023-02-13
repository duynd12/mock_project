@extends('index')

@push('css')

@endpush

@section('content')
<h2 class="title">Đổi mật khẩu</h2>
<form action="{{route('admin.update')}}" method="post">
    @csrf
    @method('PATCH')
    <div class="form-group">
        <label for="exampleInputEmail1">Mật khẩu cũ:</label>
        <input type="password" class="form-control" id="exampleInputEmail1" name="oldPassword">
        @error('name')
        <span style="color:red">{{$message}}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Mật khẩu mới:</label>
        <input type="password" class="form-control" id="exampleInputEmail1" name="password">
        @error('name')
        <span style="color:red">{{$message}}</span>
        @enderror
    </div>
    <button type="submit" class="btn btn-outline-primary">Đổi mật khẩu</button>
</form>

@endsection


@push('js')

@endpush