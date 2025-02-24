@extends('food.partials.main')
@section('title', 'dashboard')

@section('content')
<div class="content-wrapper dashboard">
    <div class="page-header">
      <h3 class="page-title">Dashboard</h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          {{-- <li class="breadcrumb-item"><a href="#">Forms</a></li> --}}
          <li class="breadcrumb-item active" aria-current="page"> {{ __("Accueil") }} </li>
        </ol>
      </nav>
    </div>
    <div class="row mb-3">
        <div class="col-lg-3 col-md-6 col-12 mb-2">
            <div class="card bg-info-light">
                <div class="card-body px-3 py-4">
                  <div class="d-flex justify-content-between align-items-start">
                    <div class="">
                      <p class="mb-0 color-card-head">Commandes</p>
                      <h2 class="">{{ $count_order }}</h2>
                    </div>
                    <i class="card-icon-indicator mdi mdi-trending-up bg-inverse-icon-info"></i>
                  </div>
                </div>
              </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12 mb-2">
          <div class="card bg-success-light">
              <div class="card-body px-3 py-4">
                <div class="d-flex justify-content-between align-items-start">
                  <div class="">
                    <p class="mb-0 color-card-head">Plates</p>
                    <h2 class="">{{ $count_product }}</h2>
                  </div>
                  <i class="card-icon-indicator mdi mdi-basket menu-icon bg-inverse-icon-info"></i>
                </div>
              </div>
            </div>
      </div>
        <div class="col-lg-3 col-md-6 col-12 mb-2">
            <div class="card bg-success-light">
                <div class="card-body px-3 py-4">
                  <div class="d-flex justify-content-between align-items-start">
                    <div class="">
                      <p class="mb-0 color-card-head">Ventes</p>
                      <h2 class="">{{ $count_delivred }}</h2>
                    </div>
                    <i class="card-icon-indicator mdi mdi-briefcase-outline bg-inverse-icon-info"></i>
                  </div>
                </div>
              </div>
        </div>
        
        <div class="col-lg-3 col-md-6 col-12 mb-2">
            <div class="card bg-warning-light">
                <div class="card-body px-3 py-4">
                  <div class="d-flex justify-content-between align-items-start">
                    <div class="">
                      <p class="mb-0 color-card-head">Commandes en cours d'exécution </p>
                      <h2 class=""> {{ $count_on_delivery }}</h2>
                    </div>
                    <i class="card-icon-indicator mdi mdi-autorenew bg-inverse-icon-info"></i>
                  </div>
                </div>
              </div>
        </div>
    </div>
</div>
@endsection
