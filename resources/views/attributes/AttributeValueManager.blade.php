@extends('index')

@push('css')

@endpush

@section('content')
<div class="category-manager">
    <div class="category-manager-title">
        <h1>Quản lý Value Thuộc tính </h1>
        <button class="btn btn-outline-primary" style="float:right">
            <a href="{{route('attributeValue.showformCreate',$data['id'])}}">
                Thêm Value thuộc tính 
            </a>
        </button>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Tên thuộc tính</th>
                <th scope="col">Tên value thuộc tính</th>
                <th scope="col">Action</th>

            </tr>
        </thead>
        <tbody>
            
            @foreach($data->attributeValues as $attrValue)
            <tr>
                <th scope="row">{{$attrValue['id']}}</th>
                <td>{{$data['name']}}</td>
                <td>{{$attrValue['value_name']}}</td>
                <td>
                    <button class="btn btn-primary">
                        <a href="{{route('attributeValue.edit',$attrValue['id']) }}" style="color:white">
                            Edit
                        </a>
                    </button>
                    <button class="btn btn-danger">
                        <a href="{{route('attributeValue.destroy',$attrValue['id']) }}" style="color:white">
                            Delete
                        </a>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{-- {{$data->links()}} --}}
</div>
@endsection


@push('js')

@endpush