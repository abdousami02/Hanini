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
        <div class="col-lg-3 col-6 mb-2">
            <div class="card bg-info-light">
                <div class="card-body px-3 py-4">
                  <div class="d-flex justify-content-between align-items-start">
                    <div class="">
                      <p class="mb-0 color-card-head">Commandes</p>
                      <h2 class="">0</h2>
                    </div>
                    <i class="card-icon-indicator mdi mdi-briefcase-outline bg-inverse-icon-info"></i>
                  </div>
                </div>
              </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="card bg-info-light">
                <div class="card-body px-3 py-4">
                  <div class="d-flex justify-content-between align-items-start">
                    <div class="">
                      <p class="mb-0 color-card-head">Ventes</p>
                      <h2 class="">0</h2>
                    </div>
                    <i class="card-icon-indicator mdi mdi-pin bg-inverse-icon-info"></i>
                  </div>
                </div>
              </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="card bg-success-light">
                <div class="card-body px-3 py-4">
                  <div class="d-flex justify-content-between align-items-start">
                    <div class="">
                      <p class="mb-0 color-card-head">Pièce jointe</p>
                      <h2 class="">0</h2>
                    </div>
                    <i class="card-icon-indicator mdi mdi-file-multiple bg-inverse-icon-info"></i>
                  </div>
                </div>
              </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="card bg-warning-light">
                <div class="card-body px-3 py-4">
                  <div class="d-flex justify-content-between align-items-start">
                    <div class="">
                      <p class="mb-0 color-card-head">Utilisateurs actifs</p>
                      <h2 class=""> 4</h2>
                    </div>
                    <i class="card-icon-indicator mdi mdi-account bg-inverse-icon-info"></i>
                  </div>
                </div>
              </div>
        </div>
    </div>
</div>
@endsection
