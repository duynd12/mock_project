@extends('index')


@section('content')
<div class="category-manager">
    <div class="category-manager-title">
        <h1>Quản lý  Thuộc tính </h1>
        <form action="{{route('attribute.index')}}" method="get">
            <input type="text" name="search">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
        <div class="button" style="float: right;">
            <button class="btn btn-outline-primary">
                <a href="{{route('attribute.create')}}">
                    Thêm  thuộc tính 
                </a>
            </button>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Tên thuộc tính</th>
                <th scope="col">Action</th>

            </tr>
        </thead>
        <tbody>
            @foreach($data as $attr)
            <tr>
                <th scope="row">{{$attr['id']}}</th>
                <td>{{$attr['name']}}</td>
                
                <td>
                    <button class="btn btn-outline-primary">
                        <a href="{{route('attribute.show',$attr['id']) }}" >
                            Xem chi tiết
                        </a>
                    </button>
                    <button class="btn btn-primary">
                        <a href="{{route('attribute.edit',$attr['id']) }}" style="color:white">
                            Edit
                        </a>
                    </button>
                    <button class="btn btn-danger">
                        <a href="{{route('attribute.destroy',$attr['id']) }}" style="color:white">
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


@push('js')

@endpush