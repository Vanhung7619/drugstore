@extends('layout')

@section('content')
    <div class="container">
        <div class="row" style="margin:20px;">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Chi tiết hoá đơn nhập hàng - Ngày: {{ \Carbon\Carbon::parse($importDate)->format('d/m/Y') }}
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tên thuốc</th>
                                        <th>Số lượng</th>
                                        <th>Tổng giá trị</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($imports as $index => $import)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $import->medicine->name }}</td>
                                            <td>{{ $import->quantity }}</td>
                                            <td>{{ $import->total_amount }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
