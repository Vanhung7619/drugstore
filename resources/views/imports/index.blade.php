@extends('layout')

@section('content')
    <div class="row" style="margin:20px;">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Lịch sử nhập hàng</h4>
                </div>
                <div class="card-body">
                    <br />
                    <div class="table-responsive">
                        <table class="table" id="jtable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ngày nhập</th>
                                    <th>Tổng giá trị</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $imports = \App\Models\Import::groupBy('import_date')
                                        ->select('import_date', DB::raw('SUM(total_amount) as total_amount'))
                                        ->get();
                                @endphp
                                @foreach ($imports as $index => $import)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ \Carbon\Carbon::parse($import->import_date)->format('d/m/Y') }}</td>
                                        <td>{{ $import->total_amount }}</td>
                                        <td>
                                            <a href="{{ route('imports.show', ['import_date' => $import->import_date]) }}"
                                                title="Xem chi tiết" class="btn btn-info btn-sm">Chi tiết</a>
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
