<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>PolluxUI Admin</title>
  <!-- base:css -->
  <link rel="stylesheet" href="{{asset('template/template/vendors/typicons/typicons.css')}}">
  <link rel="stylesheet" href="{{asset('template/template/vendors/css/vendor.bundle.base.css')}}">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{asset('template/template/css/vertical-layout-light/style.css')}}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{asset('template/template/images/favicon.png')}}" />
</head>

<body>
  <div class="container-scroller"
    style="background-image: url({{ asset('asset/image/bg-login.jpg') }}); background-size: cover; background-repeat: no-repeat;">
    <div class="container-fluid full-page-wrapper d-flex align-items-center" style="min-height:100vh">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5 bg-light rounded border border-primary">
              <div class="d-flex">
                <div class="brand-logo bg-primary d-flex justify-content-center py-2 rounded-end pr-4 pl-2" style="border-radius: 0px 50px 50px 0px">
                  <img src="{{ asset('asset/image/logo.png') }}" alt="logo">
                </div>
              </div>
              <h4 class="">Hello! let's get started</h4>
              <h6 class="font-weight-light">Sign in to continue.</h6>
              <form class="pt-3" action="{{route('login.auth')}}" method="POST">
                @csrf
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg rounded border border-primary" id="exampleInputEmail1"
                    placeholder="Email" name="email" value="{{old('email')}}">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg rounded border border-primary" id="exampleInputPassword1"
                    name="password" placeholder="Password" value="{{old('password')}}">
                </div>
                <div class="mt-3">
                  <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn font-bold text-light"
                    type="submit"><b>SIGNIN</b></button>
                </div>
                {{-- <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input">
                      Keep me signed in
                    </label>
                  </div>
                  <a href="#" class="auth-link text-black">Forgot password?</a>
                </div> --}}
                {{-- <div class="mb-2">
                  <button type="button" class="btn btn-block btn-facebook auth-form-btn">
                    <i class="typcn typcn-social-facebook mr-2"></i>Connect using facebook
                  </button>
                </div>
                <div class="text-center mt-4 font-weight-light">
                  Don't have an account? <a href="register.html" class="text-primary">Create</a>
                </div> --}}
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- base:js -->
  <script src="{{asset('template/template/vendors/js/vendor.bundle.base.js')}}"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="{{asset('template/template/js/off-canvas.js')}}"></script>
  <script src="{{asset('template/template/js/hoverable-collapse.js')}}"></script>
  <script src="{{asset('template/template/js/template.js')}}"></script>
  <script src="{{asset('template/template/js/settings.js')}}"></script>
  <script src="{{asset('template/template/js/todolist.js')}}"></script>
  <!-- endinject -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
</body>

</html>