@props([
    'type' => 'button',
    'variant' => 'primary', // primary, secondary, success, danger
])

@php
    $baseClasses = 'px-3 py-2 leading-[1] text-sm font-medium text-center text-white rounded-md focus:ring-4 focus:outline-none hover:cursor-pointer';
    
    $variants = [
        'primary' => 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-800',
        'secondary' => 'bg-gray-600 hover:bg-gray-700 focus:ring-gray-800',
        'success' => 'bg-green-600 hover:bg-green-700 focus:ring-green-800',
        'danger' => 'bg-red-600 hover:bg-red-700 focus:ring-red-800'
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

<button 
    type="{{ $type }}"
    {{ $attributes->merge(['class' => $classes]) }}
>
    {{ $slot }}
</button> 