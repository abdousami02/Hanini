@extends('food.partials.main')
@section('title', 'Touts les commandes')

@section('content')
@php
$address = (object) $order->shipping_address;
@endphp
<div class="content-wrapper dashboard">
    <div class="page-header">
      <h3 class="page-title">Commande Détail</h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('food.orders') }}">{{ __("Orders") }}</a></li>
          <li class="breadcrumb-item active" aria-current="page">Command Details</li>
        </ol>
      </nav>
    </div>

    <div class="card">
        <div class="card-body">
            <a href="{{ route('food.orders') }}" class="btn btn-primary"><i class="mdi mdi-arrow-left"></i> Retour</a>
          <div class="row justify-content-end">
            <div class="col-md-3 col-sm-6">
                {{-- <div class="form-group">
                </div> --}}
                
                <form action="{{ route('food.order.change.status') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $order->id }}">

                    <select name="payment_status" id="payment_status" class="form-control onChangeFormSubmit @error('payment_status') is-invalid @enderror">
                        <option value="unpaid" @selected($order->payment_status == 'unpaid')>{{ __('unpaid') }}</option>
                        <option value="paid" @selected($order->payment_status == 'paid')>{{ __('paid') }}</option>
                    </select>
                </form>
            </div>
            
            <div class="col-md-3 col-sm-6">

                <form action="{{ route('food.order.change.status') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $order->id }}">

                    <select name="status" id="status" class="form-control onChangeFormSubmit @error('status') is-invalid @enderror">
                        <option value="pending" @selected($order->status == 'pending')>{{ __('pending') }}</option>
                        <option value="on_process" @selected($order->status == 'on_process')>{{ __('on_process') }}</option>
                        <option value="on_delivery" @selected($order->status == 'on_delivery')>{{ __('on_delivery') }}</option>
                        <option value="delivered" @selected($order->status == 'delivered')>{{ __('delivered') }}</option>
                        <option value="cancelled" @selected($order->status == 'cancelled')>{{ __('cancelled') }}</option>
                    </select>
                </form>
            </div>
          </div>
          <hr class="m-4">
          <div class="rows pt-4">
            <div class="col-md-6 ">
                <h4>Command #PL-{{ $order->id }}</h4>
                <address class="mt-3">
                    <strong>Expédié à:</strong><br>
                    {{ $address->name }}<br>
                    {{ $address->phone_no }}<br>
                    {{ $address->address }}
                    <br>
                     {{ $address->state }} ,
                    Algeria
                </address>
            </div>
          </div>

          <div class="table-responsive mt-3">
            <table class="table">
                <thead class="thead-light">
                    <th style="width: 50px">#</th>
                    <th>Produit</th>
                    <th style="width: 25%">Prix Unitaire</th>
                    <th>Quantité</th>
                    <th>Sous Total</th>
                    <th style="min-width: 110px">Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderDetails ?? [] as $key=>$elem)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $elem->product->name }}</td>
                        <td>{{ $elem->price }} DA</td>
                        <td>{{ $elem->qte }}</td>
                        <td>{{ ($elem->qte * $elem->price) }} DA</td>
                        <td>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
          </div>

          <div class="row mt-4 justify-content-end">
            <div class="col-md-4 justify-content-end">
                <div class="d-flex justify-content-end">
                    <table class="table-borderless text-right">
                        <tbody>
                            <tr>
                                <td class="invoice-detail-name"> Sous Total:</td>
                                <td class="invoice-detail-value">{{ $order->sub_total }} DA</td>
                            </tr>
                            {{-- <tr>
                                <td class="invoice-detail-name">(-) Remise:</td>
                                <td class="invoice-detail-value">0.00 DA</td>
                            </tr> --}}
                            {{-- <tr>
                                <td class="invoice-detail-name">(-) Bon de Réduction:</td>
                                <td class="invoice-detail-value">DA 0.00 DA</td>
                            </tr> --}}
                            <tr>
                                <td class="invoice-detail-name">(+) Tax:</td>
                                <td class="invoice-detail-value">{{ $order->total_tax }} DA</td>
                            </tr>
                            <tr>
                                <td class="invoice-detail-name">(+) Frais de Livraison:</td>
                                <td class="invoice-detail-value">{{ $order->shipping_cost }} DA</td>
                            </tr>
                            <tr>
                                <td class="invoice-detail-name"></td>
                                <td>-------------</td>
                            </tr>
                            <tr>
                                <td class="invoice-detail-name"> Net à payer:</td>
                                <td class="invoice-detail-value">{{ $order->total_amount }} DA</td>
                            </tr>
    
                        </tbody>
                    </table>
                </div>
            </div>
          </div>

        </div>
    </div>
</div>
@endsection

@push('script')
<script>

(function($){

    $('.change-status').click(e=>{changeStatus(e, 'status')});
    $('.change-payment-status').click(e=>{changeStatus(e, 'payment_status')});


    function changeStatus(e){
        e.preventDefault();
        // let element = $(e.target).parents('tr[data-id]');
        let id = {{ $order->id }};
        let url = '{{ route("food.order.destroy") }}';

        var formData = {
            id: value[1],
            status,
            change_for: value[2],
        }

        $.post(url,formData).done(function(response){
            if(response.success){
                toastr.success(response.success)
            }else{
                toastr.error(response.error)
            }

        }).fail(function(resp){
            toastr.error(resp.responseJSON.message);
        })
    }

})(jQuery)
</script>
@endpush

