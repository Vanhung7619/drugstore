<!DOCTYPE html>
<html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/styledb.css') }}" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <!-- Liên kết CDN Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4"></script>

</head>

<body>
    <div class="container-fluid">
        <link rel="stylesheet" href="{{ url('css/styledb.css') }}">
        <!-- Dashboard -->
        <div class="d-flex flex-column flex-lg-row h-lg-full bg-surface-secondary">
            <!-- Vertical Navbar -->
            <nav class="navbar show navbar-vertical h-lg-screen navbar-expand-lg px-0 py-3 navbar-light bg-white border-bottom border-bottom-lg-0 border-end-lg"
                id="navbarVertical">
                <div class="container-fluid p-0">
                    <!-- Toggler -->
                    <button class="navbar-toggler ms-n2" type="button" data-bs-toggle="collapse"
                        data-bs-target="#sidebarCollapse" aria-controls="sidebarCollapse" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <!-- Brand -->
                    <a class="navbar-brand py-lg-2 mb-lg-5 px-lg-6 me-0 fw-bold fs-4 " style="color: green"
                        href="#">
                        <img src="{{ url('image/logo.png') }}" style="height: 5rem" alt="...">
                        TỪ TÂM</a>
                    <!-- User menu (mobile) -->
                    <div class="navbar-user d-lg-none">
                        <!-- Dropdown -->
                        <div class="dropdown">
                            <!-- Toggle -->
                            <a href="#" id="sidebarAvatar" role="button" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <div class="avatar-parent-child">
                                    <img alt="Image Placeholder"
                                        src="https://images.unsplash.com/photo-1548142813-c348350df52b?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=3&w=256&h=256&q=80"
                                        class="avatar avatar- rounded-circle">
                                    <span class="avatar-child avatar-badge bg-success"></span>
                                </div>
                            </a>
                            <!-- Menu -->
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="sidebarAvatar">
                                <a href="#" class="dropdown-item">Profile</a>
                                <a href="#" class="dropdown-item">Settings</a>
                                <a href="#" class="dropdown-item">Billing</a>
                                <hr class="dropdown-divider">
                                <form id="logout-form" method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="#" onclick="document.getElementById('logout-form').submit();"
                                        class="nav-link" style="text-decoration: none;">
                                        <i class="bi bi-box-arrow-left"></i> Logout
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Collapse -->
                    <div class="collapse navbar-collapse" id="sidebarCollapse">
                        <!-- Navigation -->
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/dashboard') }}">
                                    <i class="bi bi-house"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/medicine') }}">
                                    <i class="bi bi-capsule-pill" width="35" height="35"></i> Quản lý sản phẩm
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/invoice') }}">
                                    <i class="bi bi-receipt-cutoff" width="35" height="35"></i> Quản lý hoá đơn
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/import') }}">
                                    <i class="bi bi-clock-history" width="35" height="35"></i> Lịch sử nhập hàng
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/statistic') }}">
                                    <i class="bi bi-graph-up-arrow" width="35" height="35"></i> Thống kê doanh
                                    thu
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="bi bi-people"></i> Users
                                </a>
                            </li>
                        </ul>
                        <!-- Divider -->
                        <hr class="navbar-divider my-5 opacity-20">
                        <!-- Navigation -->

                        <!-- Push content down -->
                        <div class="mt-auto"></div>
                        <!-- User (md) -->
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="bi bi-person-square"></i> Account
                                </a>
                            </li>
                            <form id="logout-form" method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="#" onclick="document.getElementById('logout-form').submit();"
                                    class="nav-link" style="text-decoration: none;">
                                    <i class="bi bi-box-arrow-left"></i> Logout
                                </a>
                            </form>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Main content -->
            <div class="h-screen flex-grow-1 overflow-y-lg-auto">
                <!-- Header -->
                <header class="bg-surface-primary border-bottom pt-6">
                    <div class="container-fluid">
                        <div class="mb-npx">
                            <div class="row justify-content-center">
                                <div class="col-sm-6 col-12 mb-4 mb-sm-0 text-center">
                                    <!-- Title -->
                                    <h2 class="h2 mb-0 ls-tight fw-bold" style="color: green">THUỐC TỪ TÂM NGƯỜI DƯỢC
                                        SĨ
                                    </h2>
                                </div>
                                <!-- Actions -->

                            </div>
                            <!-- Nav -->
                            <ul class="nav nav-tabs mt-4 overflow-x border-0">
                                <li class="nav-item ">
                                    <a href="#" class="nav-link active"></a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link font-regular"></a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link font-regular"></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </header>
                <!-- Main -->
                <main class="py-6 pt-0 bg-surface-secondary">
                    <div class="container-fluid p-0">
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>

    </div>
</body>

<script>
    $(document).ready(function(){
        $('#dttable').DataTable({
        "language": {
            "lengthMenu": "Hiển thị _MENU_ mục",
            "info": "Hiển thị _START_ đến _END_ của _TOTAL_ mục",
            "infoEmpty": "Hiển thị 0 đến 0 của 0 mục",
            "emptyTable": "Không có dữ liệu",
            "infoFiltered": "(đã lọc từ _MAX_ tổng số mục)",
            "search": "Tìm kiếm:",
            "zeroRecords": "Không tìm thấy dữ liệu phù hợp",
            "paginate": {
                "first": "Đầu",
                "last": "Cuối",
                "next": "Tiếp",
                "previous": "Trước"
            }
        }
    });
    })

</script>

</html>
