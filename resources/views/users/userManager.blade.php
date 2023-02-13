@extends('index')

@section('content')
<div class="user-manager">
    <div class="user-manager-title">
            <h3 style="margin-left:10px;margin-top:-6px;margin-bottom:10px">Quản lý người dùng</h3>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Họ và tên</th>
                <th scope="col">Email</th>
                <th scope="col">Số điện thoại</th>
                <th scope="col">Địa chỉ</th>
                <th scope="col">Giới tính</th>
                <th scope="col">Ngày Sinh</th>
                @if(Auth::user()->rule === __(\App\Constants\Admin::ROLE_GOVERNOR))
                    <th scope="col">Hanlde</th>
                @endif
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
                
                @if(Auth::user()->rule === __(\App\Constants\Admin::ROLE_GOVERNOR))

                @if($user['status'] == 'block')
                    <td>
                        <form action="{{route('user.unlock',$user->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-outline-primary">
                                    Mở Block
                            </button>
                        </form>
                    </td>
                @else
                    <td>
                         <form action="{{route('user.lock',$user->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-outline-danger">
                                    Block
                            </button>
                        </form>
                </td>
                @endif
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection