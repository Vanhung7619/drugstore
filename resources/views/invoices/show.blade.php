@extends('invoices.layout')
@section('content')
    <div class="container">
        <div class="row" style="margin:20px;">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Chi tiết hoá đơn</h4>
                    </div>
                    <div class="card-body">
                        <div>
                            <strong>Ngày lập hoá đơn:</strong> {{ $invoice->invoice_date }}
                        </div>
                        <div>
                            <strong>Tổng giá trị:</strong> {{ $invoice->total_amount }}
                        </div>
                        <div>
                            <strong>Loại hoá đơn:</strong> {{ $invoice->invoice_type }}
                        </div>
                        <!-- Hiển thị thông tin chi tiết hoá đơn -->
                        <div>
                            <h5>Chi tiết hoá đơn:</h5>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Sản phẩm</th>
                                        <th>Số lượng</th>
                                        <th>Đơn giá</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoice->invoiceDetails as $detail)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $detail->medicine->name }}</td>
                                            <td>{{ $detail->quantity }}</td>
                                            <td>{{ $detail->unit_price }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Kết thúc hiển thị thông tin chi tiết hoá đơn -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
