@extends('food.partials.main')
@section('title', 'Touts les commandes')

@section('content')
<div class="content-wrapper dashboard">
    <div class="page-header">
        <div class="">
            <h3 class="page-title">Les Plates</h3>
            <a class="btn btn-primary mt-2" href="{{ route('food.product.add') }}"><i class="mdi mdi-plus"></i>{{ __("Ajouter Plate") }}</a>
        </div>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            {{-- <li class="breadcrumb-item"><a href="#">Forms</a></li> --}}
            <li class="breadcrumb-item active" aria-current="page"> {{ __("Plates") }} </li>
            </ol>
        </nav>
    </div>


    <div class="card">
        <div class="card-body">
            <div class="mb-3 row">
              <div class="col-md-4 col-12 mb-2">
                <div class="">
                    <h4 class="card-title">Tous les plates</h4>
                    {{-- <span class="text-muted">Afficher 5 de 20</span> --}}
                </div>
              </div>
              <div class="col-md-8 col-12">
                <form action="" class="search input-group ml-auto" style="max-width: 450px">
                    <input type="text" name="search" class="form-control" placeholder="Recherche..." value="{{ old('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-success" type="submit"><i class="feather mdi mdi-magnify"></i></button>
                    </div>
                </form>
              </div>
            </div>
          <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                    <th style="width: 50px">#</th>
                    <th>Nom</th>
                    <th>Prix</th>
                    <th>Informations</th>
                    <th>Statut</th>
                    <th>Comments</th>
                    <th style="width: 110px">Options</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Plate de Riz</td>
                        <td>6500 DA</td>
                        <td></td>
                        <td>
                            <div class="badge badge-success">Payé</div>
                        </td>
                        {{-- <td>
                            <span data-toggle="tooltip" data-original-title="23 November, 2024 06:56:57 PM">
                                23 Nov, 24
                            </span>
                        </td> --}}
                        <td></td>
                        <td>
                            <a href="#" class="btn btn-outline-info btn-sm btn-circle" data-url="" data-toggle="tooltip" title="" data-original-title="Voir" aria-describedby="tooltip373621">
                                <i class="mdi mdi-eye"></i>
                            </a>

                            <div class="dropdown">
                              <button type="button" class="btn btn-light btn-option" data-toggle="dropdown" aria-expanded="false">
                                  <i class="mdi mdi-dots-vertical"></i>
                              </button>
                              <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href=""><i class="icon mdi mdi-pencil"></i> {{ __("Modifier") }}</a></li>
                                    <li><a class="dropdown-item delete-project" href="#"><i class="icon mdi mdi-delete"></i> {{ __("Supprimer") }}</a></li>
                                    <li><a class="dropdown-item archive-project" href="#"><i class="icon mdi mdi-archive"></i> {{ __("Archive") }}</a></li>
                              </ul>
                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
        </div>
    </div>

</div>
@endsection

