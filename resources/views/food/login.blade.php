<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Hanini Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="{{ static_asset('css/toastr.min.css') }}">

    <!-- Layout styles -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="{{ static_asset('css/custome.css') }}">

    <!-- End layout styles -->
    <link rel="shortcut icon" href="/assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left p-5">
                <div class="brand-logo">
                  <img src="{{ static_asset('images/logo.png') }}">
                </div>
                <h4>Bonjour! Commençons</h4>
                {{-- <h6 class="font-weight-light">Sign in to continue.</h6> --}}
                <form class="pt-3" action="{{ route('food.login.check') }}" method="POST">
                    @csrf
                  <div class="form-group">
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control form-control-lg @error('email') is-invalid @enderror" id="exampleInputEmail1" placeholder="Email">
                    <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                  </div>
                  <div class="form-group">
                    <input type="password" name="password" class="form-control form-control-lg @error('email') is-invalid @enderror" id="exampleInputPassword1" placeholder="Password">
                  </div>
                  <div class="mt-3 d-grid gap-2">
                    <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SE CONNECTER</button>
                  </div>
                  <div class="my-2 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                      <label class="form-check-label text-muted">
                        <input type="checkbox" name="remember" value="1" @checked(old('remember') == 1) class="form-check-input"> Rester connecté </label>
                    </div>
                    <a href="#" class="auth-link text-black">Oublié le mot passe?</a>
                  </div>
                  {{-- <div class="mb-2 d-grid gap-2">
                    <button type="button" class="btn btn-block btn-facebook auth-form-btn">
                      <i class="mdi mdi-facebook me-2"></i>Connect using facebook </button>
                  </div>
                  <div class="text-center mt-4 font-weight-light"> Don't have an account? <a href="register.html" class="text-primary">Create</a>
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
    <!-- plugins:js -->
    <script src="/assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="/assets/js/misc.js"></script>

    <!-- endinject -->
    <script type="text/javascript" src="{{ static_asset('js/toastr.min.js') }}"></script>
    {{-- {!! Toastr::message() !!} --}}
  </body>
</html>

