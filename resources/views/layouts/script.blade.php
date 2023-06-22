  <script type="text/javascript">
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
  </script>
  <!-- Bootstrap js-->
  <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
  <!-- feather icon js-->
  <script src="{{ asset('assets/js/icons/feather-icon/feather.min.js') }}"></script>
  <script src="{{ asset('assets/js/icons/feather-icon/feather-icon.js') }}"></script>
  <!-- scrollbar js-->
  <script src="{{ asset('assets/js/scrollbar/simplebar.js') }}"></script>
  <script src="{{ asset('assets/js/scrollbar/custom.js') }}"></script>
  <!-- Sidebar jquery-->
  <script src="{{ asset('assets/js/config.js') }}"></script>
  <script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>

  <script src="{{ asset('assets/js/sweetalert2@11.js') }}"></script>

  {{-- scripts includes --}}
  @yield('scripts')
  {{--end scripts includes --}}

   <!-- Template js-->
   <script src="{{ asset('assets/js/script.js') }}"></script>
   <script src="{{ asset('assets/js/theme-customizer/customizer.js') }}"></script>
   <!-- login js-->
