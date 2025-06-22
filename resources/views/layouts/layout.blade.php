<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>@yield('title')</title>

  <!-- CSS Vendor & Plugin -->
  <link rel="stylesheet" href="{{asset('template/template/vendors/typicons/typicons.css')}}">
  <link rel="stylesheet" href="{{asset('template/template/vendors/css/vendor.bundle.base.css')}}">
  <link rel="stylesheet" href="{{asset('template/template/vendors/select2/select2.min.css')}}">
  <link rel="stylesheet"
    href="{{asset('template/template/vendors/select2-bootstrap-theme/select2-bootstrap.min.css')}}">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

  <!-- Main CSS -->
  <link rel="stylesheet" href="{{asset('template/template/css/vertical-layout-light/style.css')}}">
  <link rel="shortcut icon" href="{{asset('asset/image/logoP.png')}}" />
</head>

<body>
  <div class="container-scroller">
    @include('layouts.header')

    <div class="container-fluid page-body-wrapper">
      @include('layouts.option')
      @include('layouts.sidebar')

      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-xl-6 grid-margin stretch-card flex-column">
              <h5 class="text-titlecase mb-4">@yield('title')</h5>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              @yield('content')
            </div>
          </div>
        </div>
        @include('layouts.footer')
      </div>
    </div>
  </div>

  <!-- JS Vendor -->
  <script src="{{asset('template/template/vendors/js/vendor.bundle.base.js')}}"></script>

  <!-- JS Plugin -->
  <script src="{{asset('template/template/vendors/chart.js/Chart.min.js')}}"></script>
  <script src="{{asset('template/template/vendors/typeahead.js/typeahead.bundle.min.js')}}"></script>
  <script src="{{asset('template/template/vendors/select2/select2.min.js')}}"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- JS Template -->
  <script src="{{asset('template/template/js/off-canvas.js')}}"></script>
  <script src="{{asset('template/template/js/hoverable-collapse.js')}}"></script>
  <script src="{{asset('template/template/js/template.js')}}"></script>
  <script src="{{asset('template/template/js/settings.js')}}"></script>
  <script src="{{asset('template/template/js/todolist.js')}}"></script>

  <!-- JS Custom -->
  <script src="{{asset('template/template/js/dashboard.js')}}"></script>
  <script src="{{asset('template/template/js/file-upload.js')}}"></script>
  <script src="{{asset('template/template/js/typeahead.js')}}"></script>
  <script src="{{asset('template/template/js/select2.js')}}"></script>

  <!-- SweetAlert Session Flash -->
  @if(session('success'))
    <script>
    Swal.fire({
      icon: 'success',
      title: 'Success',
      text: '{{ session("success") }}',
      confirmButtonColor: '#3085d6'
    });
    </script>
  @endif

  @if(session('error'))
    <script>
    Swal.fire({
      icon: 'error',
      title: 'Failed',
      text: '{{ session("error") }}',
      confirmButtonColor: '#d33'
    });
    </script>
  @endif

  <!-- Delete Confirmation -->
  <script>
    function confirmDelete(id) {
      Swal.fire({
        title: 'Are you sure?',
        text: "This action cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById('delete-form-' + id).submit();
        }
      });
    }
  </script>

  <!-- DataTable Inisialisasi -->
  <script>
    $(document).ready(function () {
      $('#data-table').DataTable({
        pageLength: 10,
        lengthChange: true,
        ordering: true,
        language: {
          search: "Cari:",
          lengthMenu: "Tampilkan _MENU_ data",
          info: "Menampilkan _START_ sampai _END_ dari total _TOTAL_ data",
          paginate: {
            next: "Berikutnya",
            previous: "Sebelumnya"
          },
          zeroRecords: "Tidak ditemukan data yang sesuai"
        }
      });
    });
  </script>
</body>

</html>