@props([
    'type' => 'text',
    'label' => null,
    'name' => null,
    'id' => null,
    'error' => null,
    'required' => false,
    'placeholder' => '',
])

@php
    $inputId = $id ?? $name ?? uniqid('input-');
    $baseClasses = 'block w-full rounded-lg border transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-0 disabled:opacity-50 disabled:cursor-not-allowed';
    $normalClasses = 'border-gray-300 bg-white text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-400 dark:focus:ring-blue-400';
    $errorClasses = 'border-red-500 bg-red-50 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 dark:border-red-500 dark:bg-red-900/20 dark:text-red-200';
    $sizeClasses = 'px-3 py-2 text-sm';
    $classes = $baseClasses . ' ' . $sizeClasses . ' ' . ($error ? $errorClasses : $normalClasses);
@endphp

<div class="space-y-1">
    @if($label)
        <label 
            for="{{ $inputId }}" 
            class="block text-sm font-medium text-gray-700 dark:text-gray-300"
        >
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif
    
    <input
        type="{{ $type }}"
        id="{{ $inputId }}"
        name="{{ $name }}"
        {{ $attributes->merge(['class' => $classes]) }}
        placeholder="{{ $placeholder }}"
        @if($required) required @endif
    />
    
    @if($error)
        <p class="text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
    @endif
</div>
