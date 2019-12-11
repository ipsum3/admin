@foreach (Alert::getMessages() as $type => $messages)
    @foreach ($messages as $message)
        <div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
            <div class="alert-icon">
                <i class="fas
                @switch($type)
                    @case('primary')
                    @case('secondary')
                    @case('warning')
                    @case('dark')
                        fa-exclamation-triangle
                        @break
                    @case('success')
                        fa-check-circle
                        @break
                    @case('danger')
                        fa-minus-circle
                        @break
                    @default
                        fa-info-circle
                @endswitch
                "></i>
            </div>
            <div class="alert-text">
                {{ $message }}
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endforeach
@endforeach

@if ($errors->any())
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <div class="alert-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="alert-text">
            {{ $errors->count() > 1 ? __("Il y a :count erreurs sur ce formulaire que vous devez corriger", ['count' => $errors->count()]) : __("Il y a une erreur sur ce formulaire que vous devez corriger") }}.
            {{--<ul class="li">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>--}}
        </div>
    </div>
@endif