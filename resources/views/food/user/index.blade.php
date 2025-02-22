
@extends('partials.main')

@section('title', 'Utilisateurs')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
      <div class="">
        <h3 class="page-title">Utilisateurs</h3>
        <a href="#" class="btn btn-primary mt-2" data-toggle="modal" data-target="#addUserModel"><i class="mdi mdi-plus"></i> {{ __("add user") }}</a>
      </div>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          {{-- <li class="breadcrumb-item"><a href="">Dashboard</a></li> --}}
          <li class="breadcrumb-item active" aria-current="page"> utilisateurs </li>
        </ol>
      </nav>
    </div>

@if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
@endif

@include('components.map_users', ['fb_users' => $fb_users])

<div class="card">
    <div class="card-body">
        <div class="mb-3 row">
          <div class="col-md-4 col-12 mb-2">
            <div class="">
                <h4 class="card-title">Tous les Utilisateurs</h4>
                <span class="text-muted">Afficher 5 de 20</span>
            </div>
          </div>
          <div class="col-md-8 col-12">
            <form action="" class="search input-group ml-auto" style="max-width: 450px">
                <input type="text" name="search" class="form-control" placeholder="Recherche..." value="">
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
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Statut</th>
                    {{-- <th>Pièce jointe</th> --}}
                    <th style="width: 110px">Option</th>
                </tr>
            </thead>
            <tbody>
              {{-- @dd($roles) --}}
                @foreach($users ?? [] as $user)
                <tr data-id="{{ $user->id }}">
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if ($user->user_type == 'super_admin')
                            {{ __("Super admin") }}
                        @else
                            @if ($user->getRoleNames()->isNotEmpty())
                                {{ $user->getRoleNames()->first() }}
                            @endif
                        @endif
                    </td>
                    <td></td>
                    <td>
                        <a href="{{ route('user.edite',['id' => $user->id]) }}" class="btn btn-info btn-sm mr-2"><i class="mdi mdi-pencil"></i></a>
                        <a href="{{ route('user.destroy') }}" class="btn btn-danger btn-sm delete-elem"><i class="mdi mdi-delete"></i></a>
                    </td>
                </tr>
                @endforeach
            
          </tbody>
        </table>
      </div>
    </div>
  </div>


<!-- add admin Modal -->
<div class="modal fade" id="addUserModel" tabindex="-1" role="dialog" aria-labelledby="addAdminModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAdminModalLabel">{{ __("add user") }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('user.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Nom complet</label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" required value="{{ old('name') }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Email</label>
                            <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" required value="{{ old('email') }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>phone</label>
                            <input class="form-control @error('phone') is-invalid @enderror" type="text" name="phone" required value="{{ old('phone') }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>statut</label>
                            <select class="form-control @error('status') is-invalid @enderror" name="status">
                                <option value="1" @selected(old('status') === 1)>{{ __("enable") }}</option>
                                <option value="0" @selected(old('status') === 0)>{{ __("disable") }}</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Role</label>
                            <select class="form-control @error('role') is-invalid @enderror" name="role">
                                <option value=""></option>
                                @foreach ($roles ?? [] as $role)
                                    <option value="{{ $role->name }}" @selected(old('role') == $role->name)>{{ $role->name }}</option>
                                @endforeach
                                <option value="super_admin" @selected(old('role') == 'super_admin')>{{ __("Super admin") }}</option>
                            </select>
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-6 form-group">
                            <label>mot de passe</label>
                            <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Confirmer mot de passe</label>
                            <input class="form-control @error('password') is-invalid @enderror" type="password" name="password_confirmation" required>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

</div>
@endsection

@push('script')
@if($errors->any())
<script>
    $('#addUserModel').modal('show')
</script>
@endif
<script>
    (function($){
      $('.delete-elem').click(function(e){
        e.preventDefault();
        let element = $(e.target).parents('tr[data-id]');
        let user_id = element.data('id');
        Swal.fire({
                title: "Etes-vous sûr de supprimer ?",
                // text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Oui, supprime-le !",
                cancelButtonText: "Annuler",
                }).then((result) => {
                    if (result.isConfirmed) {
                        // removeFile(element, media_id)
                        let url = '{{ route("user.destroy") }}';
                        let data = {
                            user_id
                        };
                        $.post(url,data).done(function(response){
                            if(response.status == 'success'){
                                element.remove();
                                toastr.success(response.message)
                            }

                        }).fail(function(e){
                            toastr.error(e.responseJSON.message);
                        })
                    }
                });
      })
    })(jQuery)
</script>
@endpush
