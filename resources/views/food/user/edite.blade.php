@extends('partials.main')

@section('title', 'modifier user')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
      <div class="">
        <h3 class="page-title">Utilisateurs</h3>
      </div>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          {{-- <li class="breadcrumb-item"><a href="">Dashboard</a></li> --}}
          <li class="breadcrumb-item active" aria-current="page"> utilisateurs </li>
        </ol>
      </nav>
    </div>

    <div class="btns mb-3">
        <a href="{{ route('users') }}" class="btn btn-primary"><i class="mdi mdi-arrow-left"></i> Retour</a>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Informations generales</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.update', $user->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Nom complet</label>
                                <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name') ?? $user->name }}">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Email</label>
                                <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') ?? $user->email }}">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Phone</label>
                                <input class="form-control @error('phone') is-invalid @enderror" type="text" name="phone" value="{{ old('phone') ?? $user->phone }}">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Statut</label>
                                <select class="form-control" name="status">
                                    <option value="1" @selected($user->status == 1) >{{ __("enable") }}</option>
                                    <option value="0" @selected($user->status == 0) >{{ __("disable") }}</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Role</label>
                                <select class="form-control" name="role">
                                    <option value=""></option>
                                    @foreach ($roles ?? [] as $role)
                                        <option value="{{ $role->name }}" @selected($user->hasRole($role->name))>{{ $role->name }}</option>
                                    @endforeach
                                    <option value="super_admin" @selected($user->user_type == 'super_admin')>{{ __("Super admin") }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="text-right">
                            <button class="btn btn-primary">Modifier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Modifier mot de passe</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.update.password', $user->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>mot de passe</label>
                                <input class="form-control @error('password') is-invalide @enderror" type="password" name="password">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Confirmer mot de passe</label>
                                <input class="form-control @error('password') is-invalide @enderror" type="password" name="password_confirmation">
                            </div>
                        </div>
                        <div class="text-right">
                            <button class="btn btn-primary">Modifier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
