<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="ndinecom">

    <title>BiLTA - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('/admin/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <script src="https://cdn.tiny.cloud/1/4ww9r42nlj1c7v4thz8rac8pon6d97hsv52wulvvyhu6unye/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>


    @stack('custom-styles')
    @livewireStyles

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('layouts.admin.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('layouts.admin.nav')
                <!-- End of Topbar -->



                <!-- Begin Page Content -->
                <div class="container-fluid">


                    @if (isset($slot))
                        {{ $slot }}
                    @else
                        @yield('content')
                    @endif

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            @include('layouts.admin.footer')
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>



    {{-- <livewire:scripts/> --}}
    @livewireScripts


    @stack('custom-scripts')


    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('admin/js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('admin/vendor/chart.js/Chart.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize TinyMCE when the page is loaded
            tinymce.init({
                selector: '.tinymce-editor', // Apply TinyMCE to elements with this class
                plugins: 'advlist autolink lists link image charmap print preview anchor help',
                toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image | help',
                menubar: false,
                branding: false
            });
    
            // Re-initialize TinyMCE when the modal is shown
            $('#createModal').on('shown.bs.modal', function () {
                tinymce.get('faqFormControlInput3').init();
            });
    
            // Re-initialize TinyMCE when the modal is hidden
            $('#createModal').on('hidden.bs.modal', function () {
                tinymce.remove('textarea');
            });
        });
    </script>

   


</body>

</html>
