@extends('index')

@section('content')
<div class="user-manager">
    <div class="user-manager-title">
        <h1>Quản lý người dùng</h1>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">UserName</th>
                <th scope="col">Email</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $user)
            <tr>
                <th scope="row">{{$user['id']}}</th>
                <td>{{$user['username']}}</td>
                <td>{{$user['email']}}</td>
                <td>
                    <button class="btn btn-danger">
                        <a href="{{route('delete-user',$user['id'])}}">
                            Block
                        </a>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection