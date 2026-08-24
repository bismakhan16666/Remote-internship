<!-- resources/views/SubView/input.blade.php -->

<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    
    @if($type === 'textarea')
        <textarea 
            name="{{ $name }}" 
            id="{{ $name }}" 
            class="form-control" 
            placeholder="{{ $placeholder ?? '' }}"
            rows="{{ $rows ?? 5 }}"
            {{ $required ?? '' }}
        >{{ $value ?? '' }}</textarea>
    @else
        <input 
            type="{{ $type }}" 
            name="{{ $name }}" 
            id="{{ $name }}" 
            class="form-control" 
            placeholder="{{ $placeholder ?? '' }}"
            value="{{ $value ?? '' }}"
            {{ $required ?? '' }}
        >
    @endif
    
    @if(isset($help))
        <small class="text-muted">{{ $help }}</small>
    @endif
</div>