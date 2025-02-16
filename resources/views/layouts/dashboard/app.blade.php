<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ $title }} - Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Fonts and Icons -->
    <link href="{{ url('https://fonts.googleapis.com/icon?family=Material+Icons') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0') }}">

    <link rel="stylesheet" href="{{ asset('dashboard-assets/extensions/quill/quill.snow.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard-assets/extensions/quill/quill.bubble.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard-assets/extensions/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard-assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard-assets/compiled/css/table-datatable-jquery.css') }}">

    <link rel="stylesheet" href="{{ asset('dashboard-assets/compiled/css/ui-widgets-chatbox.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard-assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard-assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard-assets/compiled/css/iconly.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard-assets/extensions/choices.js/public/assets/styles/choices.css') }}">
    <script src="{{ url('https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js') }}"></script>

    <link href="{{ url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css') }}" rel="stylesheet">
</head>

<body>
    <script src="{{ asset('dashboard-assets/static/js/initTheme.js') }}"></script>

    <div id="app">
        <!-- Sidebar -->
        <div id="sidebar">
            <div class="sidebar-wrapper shadow active">
                @include('layouts.dashboard.sidebar-header')
                @include('layouts.dashboard.sidebar-menu')
            </div>
        </div>

        <!-- Main Content -->
        <div id="main" class="layout-navbar navbar-fixed">
            @include('layouts.dashboard.header')

            <div id="main-content">
                <div class="page-heading">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @yield('container')
                </div>
            </div>
            
            @include('layouts.dashboard.footer')
        </div>
    </div>

    <script src="{{ asset('dashboard-assets/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('dashboard-assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('dashboard-assets/compiled/js/app.js') }}"></script>
    
    <script src="{{ asset('dashboard-assets/extensions/quill/quill.min.js') }}"></script>
    <script src="{{ asset('dashboard-assets/static/js/pages/quill.js') }}"></script>        
    <script src="{{ asset('dashboard-assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('dashboard-assets/static/js/pages/sweetalert2.js') }}"></script>
    <script src="{{ asset('dashboard-assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('dashboard-assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dashboard-assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('dashboard-assets/static/js/pages/datatables.js') }}"></script>
    <script src="{{ asset('dashboard-assets/extensions/choices.js/public/assets/scripts/choices.js') }}"></script>
    <script src="{{ asset('dashboard-assets/static/js/pages/form-element-select.js') }}"></script>

    <!-- Update Year -->
    <script>
        const d = new Date();
        const year = d.getFullYear();
        document.querySelectorAll(".yearNow").forEach(element => element.innerHTML = year);
    </script>
    <script>
        function alertDialog(inputName, label) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan!',
                text: `${label} wajib diisi`,
                confirmButtonText: 'Tutup',
            });
        }

        function deleteDialog(url) {
            Swal.fire({
                icon: 'warning',
                title: 'Konfirmasi?',
                text: `Apakah Anda yakin ingin menghapus ini?`,
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.value !== undefined && result.value) {
                window.location.href = url;
                }
            })
        }
    </script>
</body>
</html>
