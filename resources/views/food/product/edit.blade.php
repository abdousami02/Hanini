@extends('food.partials.main')
@section('title', 'Touts les commandes')

@section('content')
<div class="content-wrapper dashboard">
    <div class="page-header">
      <h3 class="page-title">Modifier un Plate</h3>

      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('food.products') }}">{{ __("Plates") }}</a></li>
          <li class="breadcrumb-item active" aria-current="page"> {{ __("Ajouter plate") }} </li>
        </ol>
      </nav>
    </div>

    <div class="card">
        <div class="card-body">
            @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

            <form action="{{ route('food.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        @if(auth()->user()->user_type != 'seller')
                        <div class="form-group">
                            <label for="">Fourniseur</label>
                            <select name="seller_id" id="project-step" class="form-control @error('seller_id') is-invalid @enderror">
                                <option value="1">Amin food</option>
                                @foreach($sellers ?? [] as $elem)
                                    <option value="{{ $elem->id }}" @selected($elem->id == $product->seller_id)>{{  $elem->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        <input type="number" id="project-id" name="project_id" value="{{ old('project_id') ?? 0 }}" style="display: none;">
                        <div class="form-group">
                            <label for="name">Nom</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') ?? $product->name }}">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="riche-text">{{ old('description') ?? base64_decode($product->description) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Prix</label>
                            <div class="input-group mb-3">
                                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') ?? $product->price }}">
                                <div class="input-group-append">
                                  <span class="input-group-text">DA</span>
                                </div>
                              </div>
                        </div>
                        <div class="form-group">
                            <label>Maximum de commandes par jour</label>
                            <div class="input-group mb-3">
                                <input type="number" name="per_day" class="form-control @error('per_day') is-invalid @enderror" value="{{ old('per_day') ?? $product->per_day }}">
                                <div class="input-group-append">
                                  <span class="input-group-text">/ jour</span>
                                </div>
                              </div>
                        </div>
                        {{-- <div class="for-group">
                            <label for="set_active" class="form-check-label">Mettre ce plat du jour</label>
                            <input type="checkbox" name="is_active" class="orm-check-input" id="set_active" @checked($product->is_active == 1) value="1">
                        </div> --}}
                        {{-- <div class="form-group">
                            <label for=""></label>
                        </div> --}}

                        {{-- <div class="form-group">
                            <label for="">Address dépôt du dossier candidature</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="mdi mdi-map-marker-radius"></i></span>
                                </div>
                                <input type="text" name="address_subm" class="form-control @error('address_subm') is-invalid @enderror" value="{{ old('address_subm') }}">
                              </div>
                        </div> --}}

                    </div>
                    <div class="col-md-6">
                        {{-- Image --}}
                        <div class="mb-3">
                            <div class="image-prev" style="max-width:320px"><img src="{{ getImage($product->imageProduct()) }}" class="w-100"></div>
                            <label class="input-meida-upload upload-named">{{ __("uploade image") }}
                                <i class="mdi mdi-cloud-upload icon"></i>
                                <input type="file" name="image" class="form-control d-none" accept="image/*">
                            </label>
                            <div class="name-file"></div>
                        </div>
                    </div>
                </div>
                <div class="btns d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary mx-2">Modifier</button>
                    <a href="{{ route('food.products') }}" class="btn btn-danger">Annuler</a>
                </div>
            </form>


        </div>
    </div>
</div>

@endsection

@push('script')
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
<script>
      CKEDITOR.replace('riche-text', {
      filebrowserUploadUrl: "{{ route('editor.upload') }}",
      // filebrowserUploadMethod: 'form',
      filebrowserUploadMethod: 'xhr',             
      fileTools_requestHeaders: {
           'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-Token': "{{ csrf_token() }}"
     }
  });

</script>
@endpush
