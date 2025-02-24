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
                    <th>Statu</th>
                    <th>Statu de paiment</th>
                    <th>Date de commande</th>
                    <th>Comments</th>
                    <th style="min-width: 110px">Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders ?? [] as $key=>$elem)
                    @php
                        $address = (object) $elem->shipping_address;
                        $product = $elem->orderDetails[0]->product;
                        //on_process|on_delivery|delivered|cancelled
                    @endphp
                    <tr data-id="{{ $elem->id }}">
                        <td>{{ $key+1 }}</td>
                        <td>PL-{{ $elem->id }}</td>
                        <td>
                            <div class="ml-1 address-items">
                                <span>{{ $address->name }} </span>
                                <span>Phone No: {{ $address->phone_no }} </span>
                                <span>Willaya: {{ $address->state }}</span>
                                <span>{{ $address->address }}</span>
                            </div>
                        </td>
                        <td>{{ $elem->total_amount }} DA</td>
                        <td>
                            @switch($elem->status)
                                @case('on_process')
                                @case('pending')
                                    <div class="badge badge-warning">{{ __($elem->status) }}</div>
                                    @break
                                @case('on_delivery')
                                    <div class="badge badge-info">{{ __($elem->status) }}</div>
                                    @break
                                @case('delivered')
                                    <div class="badge badge-success">{{ __($elem->status) }}</div>
                                    @break
                                @case('cancelled')
                                    <div class="badge badge-danger">{{ __($elem->status) }}</div>
                                    @break
                                @default
                                    
                            @endswitch
                            {{-- <div class="badge badge-warning">En attente</div> --}}
                        </td>
                        <td>
                            @if($elem->payment_status == 'unpaid')
                                <div class="badge badge-warning">Non payé</div>
                            @else
                                <div class="badge badge-success">Payé</div>
                            @endif
                        </td>
                        <td>
                            <span data-toggle="tooltip" data-original-title="{{ showDateTime($elem->date) }}">{{ showDateTime($elem->date) }}</span>
                        </td>
                        <td></td>
                        <td>
                            <a href="{{ route('food.order.details', $elem->id) }}" class="btn btn-outline-info btn-sm btn-circle" data-url="" data-toggle="tooltip" title="" data-original-title="Voir" aria-describedby="tooltip373621">
                                <i class="mdi mdi-eye"></i>
                            </a>
                            <div class="dropdown">
                              <button type="button" class="btn btn-light btn-option" data-toggle="dropdown" aria-expanded="false">
                                  <i class="mdi mdi-dots-vertical"></i>
                              </button>
                              <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href=""><i class="icon mdi mdi-pencil"></i> {{ __("Modifier") }}</a></li>
                                    <li><a class="dropdown-item delete-order" href="#"><i class="icon mdi mdi-delete"></i> {{ __("Supprimer") }}</a></li>
                              </ul>
                            </div>
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

    $('.delete-order').click(e=>{deleteOrder(e)});

    function deleteOrder(e){
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

                    let url = '{{ route("food.order.destroy") }}';
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