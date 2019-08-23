@extends('IpsumAdmin::layouts.app')
@section('title', 'Logs')

@section('content')

    <h1 class="main-title">Logs</h1>
    <div class="box">
        <div class="box-header">
            <h2 class="box-title">Liste ({{ count($files) }})</h2>
        </div>
        <div class="box-body">

            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Date</th>
                        <th>Modif.</th>
                        <th class="text-right">Poids</th>
                        <th width="320px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($files as $key => $file)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $file['file_name'] }}</td>
                        <td>{{ \Carbon\Carbon::createFromTimeStamp($file['last_modified'])->formatLocalized('%d %B %Y') }}</td>
                        <td>{{ \Carbon\Carbon::createFromTimeStamp($file['last_modified'])->formatLocalized('%H:%M') }}</td>
                        <td class="text-right">{{ round((int)$file['file_size']/1048576, 2).' MB' }}</td>
                        <td class="text-right">
                            <form action="{{ route('admin.log.delete', encrypt($file['file_name'])) }}" method="POST">
                                <a class="btn btn-primary" href="{{ route('admin.log.preview', encrypt($file['file_name'])) }}"><i class="fa fa-eye"></i> Preview</a>
                                <a class="btn btn-primary" href="{{ route('admin.log.download', encrypt($file['file_name'])) }}"><i class="fa fa-cloud-download-alt"></i> Download</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"><i class="fa fa-trash-alt"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>

@endsection