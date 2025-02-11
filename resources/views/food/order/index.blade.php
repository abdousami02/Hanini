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

    <div class="card">
        <div class="card-body">
            <div class="mb-3 row">
              <div class="col-md-4 col-12 mb-2">
                <div class="">
                    <h4 class="card-title">Tous les commandes</h4>
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
                    <th>Order Code</th>
                    <th style="width: 25%">Client</th>
                    <th>Prix total</th>
                    <th>Statu de livraison</th>
                    <th>Statu de paiment</th>
                    <th>Date de commande</th>
                    <th>Comments</th>
                    <th style="min-width: 110px">Options</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>PL-45679</td>
                        <td>
                            <div class="ml-1">
                                abdou <br>
                                <span style="white-space: nowrap">Phone No: 0588441177 </span><br>
                                <span style="white-space: nowrap"> Willaya: Chlef - الشلف</span><br>
                            </div>
                        </td>
                        <td>6500 DA</td>
                        <td>
                            <div class="badge badge-warning">En attente</div>
                        </td>
                        <td>
                            <div class="badge badge-success">Payé</div>
                        </td>
                        <td>
                            <span data-toggle="tooltip" data-original-title="23 November, 2024 06:56:57 PM">
                                23 Nov, 24
                            </span>
                        </td>
                        <td></td>
                        <td>
                            <a href="#" class="btn btn-outline-info btn-sm btn-circle" data-url="" data-toggle="tooltip" title="" data-original-title="Voir" aria-describedby="tooltip373621">
                                <i class="mdi mdi-eye"></i>
                            </a>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
        </div>
    </div>
</div>
@endsection