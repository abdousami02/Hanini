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
                    <th style="width: 120px">Image</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Prix</th>
                    <th>commande max</th>
                    <th>Plat du jour</th>
                    <th style="width: 110px">Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products ?? [] as $elem)
                    <tr data-id="{{ $elem->id }}">
                        <td>{{ $elem->id }}</td>
                        <th>
                            <img src="{{ getImage($elem->imageProduct()) }}" alt="" style="width: 120px;height:auto;">
                        </th>
                        <td>{{ $elem->name }}</td>
                        <td></td>
                        <td>{{ $elem->price }} DA</td>
                        <td>
                            @if($elem->per_day)
                            {{ $elem->per_day }} / jour
                            @else
                                Illimité
                            @endif
                        </td>
                        {{-- <td>
                            @if($elem->is_active)
                                <div class="badge badge-success">Active</div>
                            @else
                                <div class="badge badge-warning">Inactive</div>
                            @endif
                        </td> --}}
                        <td>
                            <label class="custom-switch">
                                {{-- <input type="checkbox" name="" value="food-product-status-change/{{$elem->id}}/status" class="product-status-change custom-switch-input"> --}}

                                <input type="checkbox" name="" @checked($elem->is_active == 1) value="food-product-status-change/{{$elem->id}}/ofday" class="product-set-day custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                            </label>
                        </td>
                        {{-- <td>
                            <span data-toggle="tooltip" data-original-title="23 November, 2024 06:56:57 PM">
                                23 Nov, 24
                            </span>
                        </td> --}}
                        <td>
                            <a href="{{ route('food.product.edit', $elem->id) }}" class="btn btn-outline-info btn-sm btn-circle" data-url="" data-toggle="tooltip" title="" data-original-title="Voir" aria-describedby="tooltip373621">
                                <i class="mdi mdi-pencil"></i>
                            </a>
                            <a href="#" class="btn btn-outline-danger btn-sm btn-circle delete-product" data-url="" data-toggle="tooltip" title="" data-original-title="Voir" aria-describedby="tooltip373621">
                                <i class="mdi mdi-delete"></i>
                            </a>

                            {{-- <div class="dropdown">
                              <button type="button" class="btn btn-light btn-option" data-toggle="dropdown" aria-expanded="false">
                                  <i class="mdi mdi-dots-vertical"></i>
                              </button>
                              <button type="button" class="btn btn-light btn-option" data-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </button>
                              <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href=""><i class="icon mdi mdi-pencil"></i> {{ __("Modifier") }}</a></li>
                                    <li><a class="dropdown-item delete-project" href="#"><i class="icon mdi mdi-delete"></i> {{ __("Supprimer") }}</a></li>
                                    <li><a class="dropdown-item archive-project" href="#"><i class="icon mdi mdi-archive"></i> {{ __("Archive") }}</a></li>
                              </ul>
                            </div> --}}
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        </div>
    </div>

</div>
@endsection

@push('script')
<script>

(function($){

    $('.delete-product').click(e=>{deleteProduct(e)});

    function deleteProduct(e){
        e.preventDefault();
        let element = $(e.target).parents('tr[data-id]');
        let id = element.data('id');
        Swal.fire({
            title: "Etes-vous sûr de supprimer ce produit?",
            // text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Oui, supprimer-le !",
            cancelButtonText: "Annuler",
            }).then((result) => {
                if (result.isConfirmed) {

                    let url = '{{ route("food.product.destroy") }}';
                    $.post(url,{id}).done(function(response){
                        if(response.success){
                            element.remove();
                            toastr.success(response.success)
                        }else{
                            toastr.error(response.error)
                        }

                    }).fail(function(resp){
                        toastr.error(resp.responseJSON.message);
                    })

                    // deleteAction(element, project_id);
                }
            });
    }

})(jQuery)
</script>
@endpush

