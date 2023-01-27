@extends('index')


@section('content')
<div class="category-manager">
    <div class="category-manager-title">
        <h1>Quản lý Thuộc tính </h1>
        {{-- <form action="{{route('category.index')}}" method="get">
            <input type="text" name="search">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
        <button class="btn btn-primary">
            <a href="{{route('category.create')}}" style="color:white">
                Thêm thuộc tính 
            </a>
        </button> --}}
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Tên thuộc tính</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $cate)
            <tr>
                <th scope="row">{{$cate['id']}}</th>
                <td>{{$cate['name']}}</td>
                
                {{-- <td>
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
                </td> --}}
            </tr>
            @endforeach
        </tbody>
    </table>
    {{$data->links()}}
</div>
@endsection


@push('js')

@endpush