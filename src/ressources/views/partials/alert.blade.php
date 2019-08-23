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