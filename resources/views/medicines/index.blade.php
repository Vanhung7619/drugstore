@extends('layout')
@section('content')
    <div class="row" style="margin:20px;">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ url('/medicine/create') }}" class="btn btn-success btn-sm" title="THÊM MỚI THUỐC">
                        THÊM MỚI
                    </a>
                    <br />
                    <br />
                    <div class="table-responsive">
                        <table class="table" id="dttable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Nhà sản xuất</th>
                                    <th>Ngày sản xuất</th>
                                    <th>Hạn sử dụng</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($medicines as $item)
                                    @php
                                        $expirationDate = \Carbon\Carbon::parse($item->expiration_date);
                                        $daysUntilExpiration = $expirationDate->diffInDays(\Carbon\Carbon::now());
                                    @endphp
                                    <tr class="{{ $daysUntilExpiration < 30 ? 'text-danger' : '' }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->producer }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->manufacture_date)->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->expiration_date)->format('d/m/Y') }}</td>

                                        <td>
                                            <a href="{{ url('/medicine/' . $item->id) }}" title="View medicine"><button
                                                    class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i>
                                                    Chi tiết</button></a>
                                            <a href="{{ url('/medicine/' . $item->id . '/edit') }}"
                                                title="Edit medicine"><button class="btn btn-primary btn-sm"><i
                                                        class="fa fa-pencil-square-o" aria-hidden="true"></i> cập
                                                    nhật</button></a>

                                            <form method="POST" action="{{ url('/medicine' . '/' . $item->id) }}"
                                                accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete medicine"
                                                    onclick="return confirm('Xác nhận xoá?')"><i class="fa fa-trash-o"
                                                        aria-hidden="true"></i> Xoá</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
