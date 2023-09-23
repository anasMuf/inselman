<!-- base:js -->
{{-- <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script> --}}
<!-- endinject -->
<!-- Plugin js for this page-->
{{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}
<!-- End plugin js for this page-->
<!-- inject:js -->
{{-- <script src="{{ asset('js/off-canvas.js') }}"></script> --}}
{{-- <script src="{{ asset('js/hoverable-collapse.js') }}"></script> --}}
{{-- <script src="{{ asset('js/template.js') }}"></script> --}}
{{-- <script src="{{ asset('js/todolist.js') }}"></script> --}}
<!-- endinject -->
<!-- plugin js for this page -->
{{-- <script src="{{ asset('vendors/select2/select2.min.js') }}"></script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
<!-- End plugin js for this page -->
<!-- Custom js for this page-->
{{-- <script src="{{ asset('js/dashboard.js') }}"></script> --}}
<!-- End custom js for this page-->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<!-- SweetAlert2 -->
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
