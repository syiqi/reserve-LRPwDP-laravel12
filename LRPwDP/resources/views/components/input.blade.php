@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge([
        'class' => 'input-primary ' . ($disabled ? 'opacity-70 cursor-not-allowed' : '')
    ]) !!}>
