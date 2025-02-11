@extends('food.partials.main')
@section('title', 'Touts les commandes')

@section('content')
<div class="content-wrapper dashboard">
    <div class="page-header">
      <h3 class="page-title">Commandes</h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          {{-- <li class="breadcrumb-item"><a href="#">Forms</a></li> --}}
          <li class="breadcrumb-item active" aria-current="page"> {{ __("Orders") }} </li>
        </ol>
      </nav>
    </div>
    
</div>
@endsection