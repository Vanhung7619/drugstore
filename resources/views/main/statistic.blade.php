@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs" id="revenueTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="revenue7Days-tab" data-bs-toggle="tab" href="#revenue7Days"
                            role="tab" aria-controls="revenue7Days" aria-selected="true">Doanh thu - 7 ngày</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="revenue30Days-tab" data-bs-toggle="tab" href="#revenue30Days" role="tab"
                            aria-controls="revenue30Days" aria-selected="false">Doanh thu - 30 ngày</a>
                    </li>
                </ul>
                <div class="tab-content" id="revenueTabsContent">
                    <div class="tab-pane fade show active" id="revenue7Days" role="tabpanel"
                        aria-labelledby="revenue7Days-tab">
                        <canvas id="combinedChart7Days" style="max-height:300px"></canvas>
                        <p id="revenue7DaysTotal"></p>
                        <p id="expense7DaysTotal"></p>
                    </div>
                    <div class="tab-pane fade" id="revenue30Days" role="tabpanel" aria-labelledby="revenue30Days-tab">
                        <canvas id="combinedChart30Days" style="max-height:300px"></canvas>
                        <p id="revenue30DaysTotal"></p>
                        <p id="expense30DaysTotal"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h4>Top 5 sản phẩm bán chạy nhất trong 30 ngày</h4>
                <ul class="list-unstyled">
                    @foreach ($topProducts30Days as $product)
                        <li class="nav-item">{{ $product->name }} - Số lượng: {{ $product->total_quantity }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Dữ liệu doanh thu từ Controller
            const revenue7Days = @json($revenue7Days);
            const revenue30Days = @json($revenue30Days);

            // Dữ liệu khoản chi từ Controller
            const expense7Days = @json($expense7Days);
            const expense30Days = @json($expense30Days);

            // Gộp dữ liệu thu và chi vào một mảng duy nhất
            const combinedData7Days = {
                revenue: Object.values(revenue7Days),
                expense: Object.values(expense7Days),
            };

            const combinedData30Days = {
                revenue: Object.values(revenue30Days),
                expense: Object.values(expense30Days),
            };

            // Lấy mảng các ngày từ dữ liệu
            const dates7Days = Object.keys(revenue7Days);
            const dates30Days = Object.keys(revenue30Days);

            // Biểu đồ doanh thu và khoản chi - 7 ngày
            const combinedChart7DaysCtx = $('#combinedChart7Days');
            const combinedChart7Days = new Chart(combinedChart7DaysCtx, {
                type: 'line',
                data: {
                    labels: dates7Days,
                    datasets: [{
                        label: 'Doanh thu',
                        data: combinedData7Days.revenue,
                        borderColor: 'green',
                        backgroundColor: 'transparent',
                        tension: 0.4,
                    }, {
                        label: 'Khoản chi',
                        data: combinedData7Days.expense,
                        borderColor: 'red',
                        backgroundColor: 'transparent',
                        tension: 0.4,
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value, index, values) {
                                    return value.toLocaleString() + ' đ';
                                }
                            }
                        }
                    }
                }
            });

            // Biểu đồ doanh thu và khoản chi - 30 ngày
            const combinedChart30DaysCtx = $('#combinedChart30Days');
            const combinedChart30Days = new Chart(combinedChart30DaysCtx, {
                type: 'line',
                data: {
                    labels: dates30Days,
                    datasets: [{
                        label: 'Doanh thu',
                        data: combinedData30Days.revenue,
                        borderColor: 'green',
                        backgroundColor: 'transparent',
                        tension: 0.4,
                    }, {
                        label: 'Khoản chi',
                        data: combinedData30Days.expense,
                        borderColor: 'red',
                        backgroundColor: 'transparent',
                        tension: 0.4,
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value, index, values) {
                                    return value.toLocaleString() + ' đ';
                                }
                            }
                        }
                    }
                }
            });

            // Tính tổng thu và tổng chi của 7 ngày
            const totalRevenue7Days = combinedData7Days.revenue.map(Number).reduce((a, b) => a + b, 0);
            const totalExpense7Days = combinedData7Days.expense.map(Number).reduce((a, b) => a + b, 0);

            // Hiển thị tổng thu và tổng chi của 7 ngày
            $('#revenue7DaysTotal').text('Tổng thu: ' + totalRevenue7Days.toLocaleString() + ' đ');
            $('#expense7DaysTotal').text('Tổng chi: ' + totalExpense7Days.toLocaleString() + ' đ');

            // Tính tổng thu và tổng chi của 30 ngày
            const totalRevenue30Days = combinedData30Days.revenue.map(Number).reduce((a, b) => a + b, 0);

            const totalExpense30Days = combinedData30Days.expense.map(Number).reduce((a, b) => a + b, 0);

            // Hiển thị tổng thu và tổng chi của 30 ngày
            $('#revenue30DaysTotal').text('Tổng thu: ' + totalRevenue30Days.toLocaleString() + ' đ');
            $('#expense30DaysTotal').text('Tổng chi: ' + totalExpense30Days.toLocaleString() + ' đ');
        });
    </script>
@endsection
