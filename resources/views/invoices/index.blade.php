@extends('invoices.layout')
@section('content')
    <div class="container">
        <div class="row" style="margin:20px;">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Danh sách hoá đơn</h4>
                    </div>
                    <div class="card-body">
                        <a href="{{ url('/invoice/create') }}" class="btn btn-success btn-sm" title="Tạo mới hoá đơn">Tạo
                            mới</a>
                        <br />
                        <br />
                        <div class="table-responsive">
                            <form action="{{ url('/invoice') }}" method="GET" class="form-inline">
                                <div class="form-group mb-5">
                                    <label for="invoiceType">Loại hoá đơn:</label>
                                    <select name="invoiceType" class="form-control ml-2" onchange="this.form.submit()">
                                        <option value="">Tất cả</option>
                                        <option value="Nhập" {{ request()->invoiceType == 'Nhập' ? 'selected' : '' }}>Nhập
                                        </option>
                                        <option value="Xuất" {{ request()->invoiceType == 'Xuất' ? 'selected' : '' }}>Xuất
                                        </option>
                                    </select>
                                </div>
                            </form>
                            <table class="table" id="dttable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Ngày lập</th>
                                        <th>Tổng giá trị</th>
                                        <th>Loại hoá đơn</th>
                                        <th>Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoices as $item)
                                        @if (!request()->invoiceType || $item->invoice_type == request()->invoiceType)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->invoice_date }}</td>
                                                <td>{{ $item->total_amount }}</td>
                                                <td>{{ $item->invoice_type }}</td>

                                                <td>
                                                    <a href="{{ url('/invoice/' . $item->id) }}" title="Xem chi tiết"
                                                        class="btn btn-info btn-sm">Chi tiết</a>

                                                    <form method="POST" action="{{ url('/invoice' . '/' . $item->id) }}"
                                                        accept-charset="UTF-8" style="display:inline">
                                                        {{ method_field('DELETE') }}
                                                        {{ csrf_field() }}
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            title="Xoá hoá đơn"
                                                            onclick="return confirm('Xác nhận xoá?')">Xoá</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endif
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
