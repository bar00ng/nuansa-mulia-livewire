@props([
    'active' => false,
    'href' => '',
])

@php
    $classes = $active ?? false ? 'nav-link active' : 'nav-link';
@endphp


<a {{ $attributes->merge(['class' => $classes]) }} href={{ $href }} wire:navigate>
    {{ $slot }}
</a>
