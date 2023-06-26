@extends('invoices.layout')

@section('content')
    <div class="container">
        <div class="card">
            @if (session('error_message'))
                <div class="alert alert-danger">
                    {{ session('error_message') }}
                </div>
            @endif
            <div class="card-header bg-primary">Tạo hoá đơn</div>
            <div class="card-body">
                <form action="{{ route('invoice.store') }}" method="post" id="create-invoice-form">
                    @csrf
                    <div class="form-group">
                        <label for="invoice_date">Ngày tạo hoá đơn</label><br>
                        <input type="date" name="invoice_date" id="invoice_date" class="form-control"
                            value="{{ date('Y-m-d') }}">

                    </div>

                    <div class="form-group">
                        <label for="invoice_type">Loại hoá đơn</label><br>
                        <select name="invoice_type" id="invoice_type" class="form-control">
                            <option value="Nhập">Nhập</option>
                            <option value="Xuất">Xuất</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="medicineName">Tên thuốc</label><br>
                        <div class="autocomplete">
                            <input type="text" id="medicineName" name="name" placeholder="Type medicine name..."
                                autocomplete="off" class="form-control">
                            <div id="medicineList"></div>
                        </div>
                    </div>
                    <div id="medicine_list"></div>
                    <input type="submit" value="Lưu" class="btn btn-primary" disabled>
                </form>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#medicineName').keyup(function() {
                var name = $(this).val();
                var _token = $('meta[name="csrf-token"]').attr('content');

                if (name.length > 0) {
                    $.ajax({
                        url: "{{ route('medicine.search') }}",
                        method: 'POST',
                        data: {
                            name: name,
                            _token: _token
                        },
                        success: function(response) {
                            var medicineList = '';

                            $.each(response, function(index, medicine) {
                                medicineList +=
                                    '<div class="medicine medicine-item" value="' +
                                    medicine.id + '">' + medicine.name + '</div>';
                            });

                            $('#medicineList').html(medicineList);
                        }
                    });
                } else {
                    $('#medicineList').empty();
                }
            });

            $(document).on('click', '.medicine', function() {
                var medicineName = $(this).text();
                $('#medicineName').val('');
                $('#medicineList').empty();
            });
            $(document).on('click', '.medicine-item', function() {
                var selectedMedicineId = $(this).attr(
                    'value'); // Lấy id của thuốc từ dữ liệu trả về (phụ thuộc vào cấu trúc dữ liệu của bạn)
                var selectedMedicineName = $(this).text();;
                var newMedicine =
                    '<div class="medicine row align-items-center">' +
                    '<div class="input-box col-4"><input type="hidden" name="medicine_id[]" value="' +
                    selectedMedicineId + '">' +
                    '<span>' + selectedMedicineName + '</span>' +
                    '</div>';
                newMedicine +=
                    '<div class="input-box col-4"><label for="">Giá tiền đơn vị</label><input type="text" class="form-control" name="unit_price[]" value="0"></div>'
                newMedicine += `<div class="form-group col-3">
                                <label for="quantity">Số lượng</label>
                                <input type="number" min="0" name="quantity[]" id="quantity_` + selectedMedicineId + `" class="form-control" value='0'></div>
                                <button id="cancel" class="btn btn-danger col-1" type="button">Huỷ</button>
                                </div>`;
                $('#medicine_list').append(newMedicine);

                // Xóa danh sách thuốc
                $('#medicine_results').empty();
            })
            $(document).on('click', '#cancel', function() {
                // Xoá thẻ cha của nút đó ra khỏi trang
                $(this).parent('.medicine').remove();
            });

            // Bắt sự kiện khi trường số lượng thay đổi
            $(document).on('change keyup', 'input[name="quantity[]"]', function() {
                var quantity = parseInt($(this).val()); // Lấy giá trị số lượng
                var saveButton = $('input[type="submit"]'); // Chọn nút "Lưu"

                if (quantity > 0) {
                    saveButton.prop('disabled', false); // Kích hoạt nút "Lưu"
                } else {
                    saveButton.prop('disabled', true); // Vô hiệu hóa nút "Lưu"
                }
            });
        });

        Chart.plugins.register({
            beforeInit: function(chart) {
                var moment = chart.tooltip._model._bodyFontFamily.options.moment;
                chart._model._date = moment;
                chart._model._adapter = new moment._adapter(chart._model._date);
            }
        });

        $(document).on('input', 'input[name="unit_price[]"]', function() {
    this.value = this.value.replace(/\D/g, '');
});
    </script>
@endsection
