<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine; //add Medicine Model - Data is coming from the database via Model.

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $medicines = Medicine::all();
        return view('medicines.index')->with('medicines', $medicines);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('medicines.create');
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
        Medicine::create($input);
        return redirect('medicine')->with('flash_message', 'Thêm thuốc thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $medicine = Medicine::find($id);
        return view('medicines.show')->with('medicines', $medicine);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $medicine = Medicine::find($id);
        return view('medicines.edit')->with('medicines', $medicine);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $medicine = Medicine::find($id);
        $input = $request->all();
        $medicine->update($input);
        return redirect('medicine')->with('flash_message', 'Cập nhật thuốc thành công');
    }

    public function searchMedicine(Request $request)
    {
        $searchTerm = $request->input('name');
        $medicines = Medicine::where('name', 'LIKE', '%' . $searchTerm . '%')->get();

        return response()->json($medicines);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Medicine::destroy($id);
        return redirect('medicine')->with('flash_message', 'Xóa thuốc thành công');
    }
}