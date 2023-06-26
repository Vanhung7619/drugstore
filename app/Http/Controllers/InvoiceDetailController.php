<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InvoiceDetail;
use App\Models\Medicine;

class InvoiceDetailController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $invoiceDetail = InvoiceDetail::create($input);

        // Cập nhật số lượng sản phẩm trong kho
        $medicine = Medicine::find($invoiceDetail->medicine_id);
        $medicine->quantity -= $invoiceDetail->quantity;
        $medicine->save();

        return redirect()->back()->with('flash_message', 'Thêm chi tiết hoá đơn thành công');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     $invoiceDetail = InvoiceDetail::findOrFail($id);
    //     $input = $request->all();

    //     // Cập nhật số lượng sản phẩm trong kho
    //     $medicine = Medicine::find($invoiceDetail->medicine_id);
    //     $medicine->quantity += $invoiceDetail->quantity; // Tăng lại số lượng sản phẩm trước khi cập nhật
    //     $medicine->quantity -= $input['quantity']; // Giảm số lượng sản phẩm theo yêu cầu cập nhật
    //     $medicine->save();

    //     $invoiceDetail->update($input);

    //     return redirect()->back()->with('flash_message', 'Cập nhật chi tiết hoá đơn thành công');
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     // $invoice = Invoice::findOrFail($id);
    //     // $invoiceType = $invoice->invoice_type;

    //     // // Cập nhật số lượng sản phẩm trong kho
    //     // foreach ($invoice->invoiceDetails as $invoiceDetail) {
    //     //     $medicine = Medicine::find($invoiceDetail->medicine_id);
    //     //     if ($invoiceType == 'Nhập') {
    //     //         $medicine->quantity -= $invoiceDetail->quantity;
    //     //     } elseif ($invoiceType === 'Xuất') {
    //     //         $medicine->quantity += $invoiceDetail->quantity;
    //     //     }
    //     //     $medicine->update(['quantity' => $medicine->quantity]); // Cập nhật thông tin số lượng vào kho
    //     // }

    //     // $invoice->delete();

    //     // return redirect()->back()->with('flash_message', 'Xóa hoá đơn thành công');
    // }

}