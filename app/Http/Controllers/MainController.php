<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Medicine;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function dashboard()
    {
        // Lấy danh sách các sản phẩm sắp hết hạn sử dụng
        $expiringMedicines = Medicine::whereRaw('DATEDIFF(expiration_date, CURDATE()) < 30')->get();

        // Lấy danh sách các hoá đơn trong ngày
        $invoices = Invoice::whereDate('invoice_date', now()->toDateString())->get();

        // Lấy dữ liệu cho biểu đồ tổng thu nhập từ hoá đơn xuất trong 7 ngày
        $startDate = Carbon::today()->subDays(6); // Lấy ngày bắt đầu 7 ngày trước
        $endDate = Carbon::today(); // Lấy ngày hiện tại

        $revenueData = Invoice::select(
            DB::raw('DATE(invoice_date) as date'),
            DB::raw('SUM(total_amount) as total')
        )
            ->where('invoice_type', 'Xuất')
            ->whereBetween('invoice_date', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total')
            ->toArray();

        $revenueLabels = [];
        foreach ($revenueData as $index => $value) {
            $revenueLabels[] = Carbon::parse($startDate)->addDays($index)->format('d/m/Y');
        }

        return view('main.dashboard', compact('expiringMedicines', 'invoices', 'revenueData', 'revenueLabels'));
    }
}