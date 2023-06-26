<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Medicine;
use App\Models\Invoice_detail;
use App\Models\Import;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($invoiceType = null)
    {
        if ($invoiceType) {
            $invoices = Invoice::where('invoice_type', $invoiceType)->get();
        } else {
            $invoices = Invoice::all();
        }

        return view('invoices.index')->with('invoices', $invoices);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $medicines = Medicine::all();
        return view('invoices.create')->with('medicines', $medicines);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        // Tính tổng giá trị các chi tiết hoá đơn
        $totalAmount = 0;
        $medicineIds = $request->input('medicine_id');
        $quantities = $request->input('quantity');
        $unitPrices = $request->input('unit_price');
        $invoiceType = $request->input('invoice_type'); // Thêm trường loại hoá đơn

        for ($i = 0; $i < count($medicineIds); $i++) {
            $medicine = Medicine::find($medicineIds[$i]);
            if ($invoiceType === 'Nhập') { // Loại hoá đơn nhập hàng
                $medicine->quantity += $quantities[$i];

            } elseif ($invoiceType === 'Xuất') { // Loại hoá đơn xuất hàng
                if ($medicine->quantity < $quantities[$i]) {
                    return redirect()->back()->with('error_message', 'Không đủ số lượng sản phẩm trong kho');
                }
                $medicine->quantity -= $quantities[$i];
            }

            $medicine->save();

            $totalAmount += $quantities[$i] * $unitPrices[$i];
        }

        $input['total_amount'] = $totalAmount;

        $invoice = Invoice::create($input);

        // Lưu thông tin chi tiết hoá đơn
        $invoiceDetails = [];
        for ($i = 0; $i < count($medicineIds); $i++) {
            $invoiceDetail = new Invoice_detail([
                'medicine_id' => $medicineIds[$i],
                'quantity' => $quantities[$i],
                'unit_price' => $unitPrices[$i],
            ]);

            $invoiceDetails[] = $invoiceDetail;
            if ($invoiceType === 'Nhập') {
                $import = new Import([
                    'medicine_id' => $medicineIds[$i],
                    'quantity' => $quantities[$i],
                    'total_amount' => $quantities[$i] * $unitPrices[$i],
                    'import_date' => $request->input('invoice_date'),
                ]);
                $import->medicine()->associate(Medicine::find($medicineIds[$i]));
                $import->save();

            }
        }

        $invoice->invoiceDetails()->saveMany($invoiceDetails);

        return redirect('invoice')->with('flash_message', 'Thêm hoá đơn thành công');
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $invoice = Invoice::with('invoiceDetails')->findOrFail($id);
            return view('invoices.show')->with('invoice', $invoice);
        } catch (\Exception $e) {
            return redirect('invoice')->with('error_message', 'Không tìm thấy hoá đơn');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     try {
    //         $invoice = Invoice::with('invoiceDetails')->findOrFail($id);
    //         $medicines = Medicine::all();
    //         return view('invoices.edit')->with('invoice', $invoice)->with('medicines', $medicines);
    //     } catch (\Exception $e) {
    //         return redirect('invoice')->with('error_message', 'Không tìm thấy hoá đơn');
    //     }
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoiceType = $invoice->invoice_type;

        // Cập nhật số lượng sản phẩm trong kho
        foreach ($invoice->invoiceDetails as $invoiceDetail) {
            $medicine = Medicine::find($invoiceDetail->medicine_id);
            if ($invoiceType == 'Nhập') {
                $medicine->quantity -= $invoiceDetail->quantity;
            } elseif ($invoiceType == 'Xuất') {
                $medicine->quantity += $invoiceDetail->quantity;
            }
            $medicine->save(); // Cập nhật thông tin số lượng vào kho
        }

        $invoice->delete();

        return redirect()->back()->with('flash_message', 'Xóa hoá đơn thành công');
    }

}