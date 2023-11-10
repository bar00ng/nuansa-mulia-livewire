@props([
    'active' => false,
    'href' => ''
    ])

@php
    $classes = $active ?? false ? 'sidebar-item active' : 'sidebar-item';
@endphp

<li {{ $attributes->merge(['class' => $classes]) }}>
    <a class="sidebar-link" href={{ $href }} wire:navigate>
        {{ $slot }}
    </a>
</li>
