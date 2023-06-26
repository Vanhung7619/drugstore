@extends('layout')
@section('content')
    <div class="card" style="margin:20px;">
        <div class="card-header">Thông tin thuốc</div>
        <div class="card-body">
            <div class="card-body">
                <h5 class="card-title">Tên thuốc : {{ $medicines->name }}</h5>
                <p class="card-text">Số lượng : {{ $medicines->quantity }}</p>
                <p class="card-text">Nhà sản xuất : {{ $medicines->producer }}</p>
                <p class="card-text">Ngày sản xuất : {{ $medicines->manufacture_date }}</p>
                <p class="card-text">Hạn sử dụng : {{ $medicines->expiration_date }}</p>

            </div>
            </hr>
        </div>
    </div>
@endsection
