<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="text-center sidebar-brand-wrapper d-flex align-items-center">
      <a class="sidebar-brand brand-logo" href="{{ url('/') }}"><img src="{{ static_asset('images/logo-h.png') }}" alt="logo" /></a>
      <a class="sidebar-brand brand-logo-mini pl-4 pt-3" href="{{ url('/') }}"><img src="{{ static_asset('images/logo.png') }}" alt="logo" /></a>
    </div>
    <ul class="nav mt-4">
      <li class="nav-item">
        <a class="nav-link" href="{{ route('food.dashboard')}}">
          <i class="mdi mdi-home menu-icon"></i>
          {{-- <img src="{{ static_asset("images/home2.png") }}" class="menu-image" alt=""> --}}
          <span class="menu-title">Accueil</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('food.orders')}}">
          <i class="mdi mdi-trending-up menu-icon"></i>
          {{-- <img src="{{ static_asset("images/home2.png") }}" class="menu-image" alt=""> --}}
          <span class="menu-title">Commandes</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('food.products')}}">
          <i class="mdi mdi-basket menu-icon"></i>
          {{-- <img src="{{ static_asset("images/home2.png") }}" class="menu-image" alt=""> --}}
          <span class="menu-title">Les Plates</span>
        </a>
      </li>

      {{-- <li class="nav-item">
        <a class="nav-link" href="{{ route('food.sellers')}}">
          <i class="mdi mdi-store menu-icon"></i>
          <span class="menu-title">Fourniseurs</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ route('food.users')}}">
          <i class="mdi mdi-account-multiple menu-icon"></i>
          <span class="menu-title">Utilisateurs</span>
        </a>
      </li> --}}

      {{-- @can('list concour')
      <li class="nav-item @yield('nav-projects')">
        <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
          <i class="mdi mdi-file-document menu-icon"></i>
          <img src="{{ static_asset("images/check.png") }}" class="menu-image" alt="">
          <span class="menu-title">Concours</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-basic">
          <ul class="nav flex-column sub-menu">
            @can('ajouter projet')
            <li class="nav-item">
              <a class="nav-link" href="{{ route('project.add', ['step' => 'condidat']) }}">Ajouter Concour</a>
            </li>
            @endcan
            <li class="nav-item">
              <a class="nav-link" href="{{ route('projects', ['step'=> 'condidat']) }}">Phase candidatue</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('projects', ['step'=> 'technique']) }}">Phase technique</a>
            </li>
          </ul>
        </div>
      </li>
      @endcan --}}
      
    </ul>
  </nav>