<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use Carbon\Carbon;

use Illuminate\Support\Collection;

class StatisticController extends Controller
{
    public function index()
    {
        // Lấy dữ liệu doanh thu trong 7 ngày
        $revenue7Days = Invoice::where('invoice_type', 'Xuất')
            ->whereDate('invoice_date', '>=', Carbon::now()->subDays(7))
            ->groupBy('invoice_date')
            ->selectRaw('DATE(invoice_date) as date, SUM(total_amount) as total_amount')
            ->orderBy('invoice_date')
            ->pluck('total_amount', 'date');

        // Chuyển đổi dữ liệu thành Collection để sử dụng các phương thức của Collection
        $revenue7Days = new Collection($revenue7Days);

        $revenue30Days = Invoice::where('invoice_type', 'Xuất')
            ->whereDate('invoice_date', '>=', Carbon::now()->subDays(30))
            ->groupBy('invoice_date')
            ->selectRaw('DATE(invoice_date) as date, SUM(total_amount) as total_amount')
            ->orderBy('invoice_date')
            ->pluck('total_amount', 'date');

        // Chuyển đổi dữ liệu thành Collection để sử dụng các phương thức của Collection
        $revenue7Days = new Collection($revenue7Days);

        $expense7Days = Invoice::where('invoice_type', 'Nhập')
            ->whereDate('invoice_date', '>=', Carbon::now()->subDays(7))
            ->groupBy('invoice_date')
            ->selectRaw('DATE(invoice_date) as date, SUM(total_amount) as total_amount')
            ->orderBy('invoice_date')
            ->pluck('total_amount', 'date');

        // Chuyển đổi dữ liệu thành Collection để sử dụng các phương thức của Collection

        $expense7Days = new Collection($expense7Days);

        $expense30Days = Invoice::where('invoice_type', 'Nhập')
            ->whereDate('invoice_date', '>=', Carbon::now()->subDays(30))
            ->groupBy('invoice_date')
            ->selectRaw('DATE(invoice_date) as date, SUM(total_amount) as total_amount')
            ->orderBy('invoice_date')
            ->pluck('total_amount', 'date');

        // Chuyển đổi dữ liệu thành Collection để sử dụng các phương thức của Collection
        $expense30Days = new Collection($expense30Days);

        $topProducts30Days = Invoice::where('invoice_type', 'Xuất')
            ->whereDate('invoice_date', '>=', Carbon::now()->subDays(30))
            ->join('invoice_detail', 'invoice.id', '=', 'invoice_detail.invoice_id')
            ->join('medicine', 'invoice_detail.medicine_id', '=', 'medicine.id')
            ->selectRaw('medicine.name, SUM(invoice_detail.quantity) as total_quantity')
            ->groupBy('medicine.name')
            ->orderByDesc('total_quantity')
            ->take(5)
            ->get();


        return view('main.statistic', compact('revenue7Days', 'revenue30Days', 'expense7Days', 'expense30Days', 'topProducts30Days'));
    }
}