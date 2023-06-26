@extends('layout')
@section('content')

    <div class="card" style="margin:20px;">
        <div class="card-header">Thêm thuốc mới</div>
        <div class="card-body">
            <form action="{{ url('medicine') }}" method="post" id="medicine-form">
                {!! csrf_field() !!}
                <label>Tên thuốc</label><br>
                <input type="text" name="name" id="name" class="form-control" required><br>
                <label>Số lượng</label><br>
                <input type="text" name="quantity" id="quantity" class="form-control" required><br>
                <label>Nhà sản xuất</label><br>
                <input type="text" name="producer" id="producer" class="form-control" required><br>
                <label>Ngày sản xuất</label><br>
                <input type="date" name="manufacture_date" id="manufacture_date" class="form-control" required><br>
                <label>Hạn sử dụng</label><br>
                <input type="date" name="expiration_date" id="expiration_date" class="form-control" required><br>
                <input type="submit" value="Lưu" class="btn btn-success" id="save-button" disabled><br>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('medicine-form');
            var saveButton = document.getElementById('save-button');

            form.addEventListener('input', function() {
                var inputs = form.querySelectorAll('input[required]');
                var isValid = true;

                inputs.forEach(function(input) {
                    if (input.value === '') {
                        isValid = false;
                    }
                });

                saveButton.disabled = !isValid;
            });
        });
        
        $(document).on('input', 'input[name="quantity"]', function() {
    this.value = this.value.replace(/\D/g, '');
});

    </script>

@stop
