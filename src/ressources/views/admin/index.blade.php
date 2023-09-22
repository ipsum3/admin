@extends('IpsumAdmin::layouts.app')
@section('title', 'Administrateurs')

@section('content')

    <h1 class="main-title">Administrateurs</h1>
    <div class="box">
        <div class="box-header">
            <h2 class="box-title">Liste ({{ $admins->total() }})</h2>
            <div class="btn-toolbar">
                <a class="btn btn-outline-secondary" href="{{ route('adminUser.create') }}">
                    <i class="fas fa-plus"></i>
                    Ajouter
                </a>
            </div>
        </div>
        <div class="box-body">

            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Accès</th>
                        <th>Authentification</th>
                        <th width="160px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($admins as $admin)
                    <tr>
                        <td>{{ $admin->id }}</td>
                        <td>{{ $admin->name }}</td>
                        <td>{{ $admin->email }}</td>
                        <td>{{ $admin->roleToString }}</td>
                        <td>{{ $admin->accesToString }}</td>
                        <td>@if($admin->secret_totp)
                                <span class="badge badge-success">Double authentification activé</span>
                            @else
                                <span class="badge badge-danger">Double authentification non activé</span>
                            @endif
                        </td>
                        <td class="text-right">
                            @can('update', $admin)
                            <form action="{{ route('adminUser.destroy',$admin->id) }}" method="POST">
                                <a class="btn btn-primary" href="{{ route('adminUser.edit',$admin->id) }}"><i class="fa fa-edit"></i> Modifier</a>
                                @can('delete', $admin)
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger"><i class="fa fa-trash-alt"></i></button>
                                @endcan
                            </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {!! $admins->links() !!}

        </div>
    </div>

@endsection