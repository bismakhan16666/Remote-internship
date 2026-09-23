@if($message)
    <div class="alert-custom {{ $type }}">
        @if($type === 'success')
            <i class="fas fa-check-circle"></i>
        @elseif($type === 'error')
            <i class="fas fa-exclamation-circle"></i>
        @elseif($type === 'warning')
            <i class="fas fa-exclamation-triangle"></i>
        @else
            <i class="fas fa-info-circle"></i>
        @endif
        {{ $message }}
    </div>
@endif