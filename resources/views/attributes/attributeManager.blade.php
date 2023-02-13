@extends('index')


@section('content')
<div class="category-manager">
    <div class="category-manager-title">
        <h1>Quản lý  Thuộc tính </h1>
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
                
                <td style="display:flex"> 
                    <button class="btn btn-outline-primary">
                        <a href="{{route('attribute.show',$attr['id']) }}" >
                            Xem chi tiết
                        </a>
                    </button>
                     <button class="btn btn-outline-primary" style="margin-right:10px;margin-left:10px">        
                            <a href="{{route('attribute.edit',$attr['id']) }}">
                                Edit
                            </a>
                        </button>
                    <form action="{{route('attribute.destroy',$attr['id']) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger" type="submit">        
                            DELETE
                        </button>
                    </form>
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