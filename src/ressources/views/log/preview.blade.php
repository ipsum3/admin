@extends('IpsumAdmin::layouts.app')
@section('title', 'Logs')

@section('content')

    <h1 class="main-title">Logs</h1>
    <div class="box">
        <div class="box-header">
            <h2 class="box-title">{{ $file_name }}</h2>
            <div class="btn-toolbar">
                <a class="btn btn-outline-danger" href="{{ route('admin.log.delete', encrypt($file_name)) }}" data-toggle="tooltip" title="Supprimer">
                    <i class="fas fa-trash-alt"></i>
                </a>
            </div>
        </div>
        <div class="box-body">
            <div id="accordion">
                @foreach($logs as $key => $log)
                <div class="card">
                    <div class="card-header" id="heading{{$key }}">
                        <h5 class="mb-0">
                            <button class="btn btn-link text-{{ $log['level_class'] }}" data-toggle="collapse" data-target="#collapse{{ $key }}" aria-expanded="false" aria-controls="collapse{{ $key }}">
                                <i class="fa fa-{{ $log['level_img'] }}"></i>
                                <span>[{{ $log['date'] }}]</span>
                                {{ Str::limit($log['text'], 150) }}
                            </button>
                        </h5>
                    </div>

                    <div id="collapse{{ $key }}" class="collapse" aria-labelledby="heading{{ $key }}" data-parent="#accordion">
                        <div class="card-body">
                            <p>{{$log['text']}}</p>
                            <pre>
                                {{ trim($log['stack']) }}
                             </pre>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection