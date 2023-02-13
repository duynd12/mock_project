@extends('index')

@push('css')

@endpush

@section('content')
<div class="category-manager">
    <div class="category-manager-title">
        <h1>Quản lý Value Thuộc tính </h1>
        <button class="btn btn-outline-primary" style="float:right">
            <a href="{{route('attributeValue.create',$data['id'])}}">
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
                <td style="display:flex">
                    <button class="btn btn-primary" style="margin-right:10px;">
                        <a href="{{route('attributeValue.edit',$attrValue['id']) }}" style="color:white">
                            Edit
                        </a>
                    </button>
                    <form action="{{route('attributeValue.destroy',$attrValue['id']) }}" method="post" enctype="multipart/form-data">
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
    {{-- {{$data->links()}} --}}
</div>
@endsection


@push('js')

@endpush