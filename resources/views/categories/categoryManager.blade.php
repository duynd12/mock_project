@extends('index')

@section('content')
<div class="category-manager">
    <div class="category-manager-title" style="display:flex;justify-content:space-between">
        <h1>Quản lý danh mục</h1>
        <button class="btn btn-outline-primary">
            <a href="{{route('category.create')}}">
                Thêm danh mục
            </a>
        </button>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">title</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $cate)
            <tr>
                <th scope="row">{{$cate['id']}}</th>
                <td>{{$cate['title']}}</td>
                <td>{{$cate['status']}}</td>
                <td>
                    <button class="btn btn-primary">
                        <a href="{{route('category.edit',$cate['id']) }}" style="color:white">
                            Edit
                        </a>
                    </button>
                    <button class="btn btn-danger">
                        <a href="{{route('category.destroy',$cate['id']) }}" style="color:white">
                            Delete
                        </a>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{$data->links()}}
</div>
@endsection