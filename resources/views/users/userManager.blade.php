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
                <th scope="col">Số điện thoại</th>
                <th scope="col">Địa chỉ</th>
                <th scope="col">Giới tính</th>
                <th scope="col">Ngày Sinh</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <th scope="row">{{$user['id']}}</th>
                <td>{{$user['name']}}</td>
                <td>{{$user['email']}}</td>
                <td>{{$user->profiles['numberPhone']!==null ? $user->profiles['numberPhone']  : 'null'}}</td>
                <td>{{$user->profiles['address']!=null ?$user->profiles['address'] : 'null'}}</td>
                <td>{{$user->profiles['gender']!=null ?$user->profiles['gender'] : 'null'}}</td>
                <td>{{$user->profiles['dob']!=null ?$user->profiles['dob'] : 'null'}}</td>
                {{-- <td>{{$user->profiles['dob']}}</td> --}}
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection