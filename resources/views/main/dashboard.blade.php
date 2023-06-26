@extends('layout')

@section('content')
    <div class="container p-5">
        <div class="row">
            <div class="col-md-12">
                <h3>Sản phẩm sắp hết hạn sử dụng</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng còn lại</th>
                            <th>Nhà sản xuất</th>
                            <th>Hạn sử dụng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dữ liệu sản phẩm sắp hết hạn sử dụng -->
                        @foreach ($expiringMedicines as $medicine)
                            <tr>
                                <td>{{ $medicine->name }}</td>
                                <td>{{ $medicine->quantity }}</td>
                                <td>{{ $medicine->producer }}</td>
                                <td>{{ \Carbon\Carbon::parse($medicine->expiration_date)->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <h3>Hoá đơn trong ngày</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Số hoá đơn</th>
                            <th>Ngày lập hoá đơn</th>
                            <th>Tổng tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dữ liệu hoá đơn -->
                        @foreach ($invoices as $invoice)
                            @if ($invoice->invoice_type === 'Xuất')
                                <!-- Kiểm tra nếu là hoá đơn xuất -->
                                <tr>
                                    <td>{{ $invoice->id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}</td>
                                    <td>{{ $invoice->total_amount }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>

                <h3>THỐNG KÊ DOANH THU TRONG 7 NGÀY</h3>
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Code JavaScript để vẽ biểu đồ
        // Vẽ biểu đồ thống kê doanh thu theo ngày, tuần, tháng, năm
        var revenueChart = new Chart(document.getElementById('revenueChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode($revenueLabels) !!},
                datasets: [{
                    label: 'Doanh thu (đồng)',
                    data: {!! json_encode($revenueData) !!},
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                    tension: 0.4
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    },
                }
            }
        });
    </script>
@endsection
