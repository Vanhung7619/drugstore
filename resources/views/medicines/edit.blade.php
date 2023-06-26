@extends('layout')
@section('content')

    <div class="card" style="margin:20px;">
        <div class="card-header">Cập nhật thông tin thuốc</div>
        <div class="card-body">

            <form action="{{ url('medicine/' . $medicines->id) }}" method="post">
                {!! csrf_field() !!}
                @method('PATCH')
                <input type="hidden" name="id" id="id" value="{{ $medicines->id }}" id="id" />
                <label>Tên thuốc</label></br>
                <input type="text" name="name" id="name" value="{{ $medicines->name }}"
                    class="form-control"></br>
                <label>Số lượng</label></br>
                <input type="text" name="quantity" id="quantity" value="{{ $medicines->quantity }}"
                    class="form-control"></br>
                <label>Nhà sản xuất</label></br>
                <input type="text" name="producer" id="producer" value="{{ $medicines->producer }}"
                    class="form-control"></br>
                <label>Ngày sản xuất</label></br>
                <input type="date" name="manufacture_date" id="manufacture_date"
                    value="{{ $medicines->manufacture_date }}" class="form-control"></br>
                <label>Hạn sử dụng</label></br>
                <input type="date" name="expiration_date" id="expiration_date" value="{{ $medicines->expiration_date }}"
                    class="form-control"></br>
                <input type="submit" value="Cập nhật" class="btn btn-success"></br>
            </form>

        </div>
    </div>

@stop
