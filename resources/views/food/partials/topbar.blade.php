<nav class="navbar col-lg-12 col-12 p-lg-0 fixed-top d-flex flex-row">
    <div class="navbar-menu-wrapper d-flex align-items-stretch justify-content-between">
      <a class="navbar-brand brand-logo-mini align-self-center d-lg-none" href="{{ url('/') }}"><img src="{{ static_asset('images/logo.png') }}" style="max-width: 45px" alt="logo" /></a>
      <button class="navbar-toggler navbar-toggler align-self-center mr-2" type="button" data-toggle="minimize">
        <i class="mdi mdi-menu"></i>
      </button>
      <ul class="navbar-nav">
      </ul>
      <ul class="navbar-nav navbar-nav-right ml-lg-auto">
        {{-- <li class="nav-item dropdown d-none d-xl-flex border-0">
          <a class="nav-link dropdown-toggle" id="languageDropdown" href="#" data-toggle="dropdown">
            <i class="mdi mdi-earth"></i> English </a>
          <div class="dropdown-menu navbar-dropdown" aria-labelledby="languageDropdown">
            <a class="dropdown-item" href="#"> French </a>
            <a class="dropdown-item" href="#"> Spain </a>
            <a class="dropdown-item" href="#"> Latin </a>
            <a class="dropdown-item" href="#"> Japanese </a>
          </div>
        </li> --}}
        <li class="nav-item dropdown">
          @include('components.notification')
        </li>
        <li class="nav-item nav-profile dropdown border-0">
          <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown">
            <img class="nav-profile-img mr-2" alt="" src="{{ static_asset('images/faces/default.png') }}" />
            <span class="profile-name">{{ auth()->user()->name }}</span>
          </a>
          <div class="dropdown-menu dropdown-right navbar-dropdown" aria-labelledby="profileDropdown">
            <a class="dropdown-item" href="#">
              <i class="mdi mdi-cached mr-2 text-success"></i> Activity Log </a>
            <a class="dropdown-item" href="{{ route('logout') }}">
              <i class="mdi mdi-logout mr-2 text-primary"></i> Signout </a>
          </div>
        </li>
      </ul>
      <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
        <span class="mdi mdi-menu"></span>
      </button>
    </div>
  </nav>
