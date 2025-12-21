@props([
    'title' => null,
    'value' => null,
    'icon' => null,
    'color' => 'blue', // blue, green, yellow, red, purple
])

@php
    $colorClasses = [
        'blue' => 'bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400',
        'green' => 'bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400',
        'yellow' => 'bg-yellow-100 text-yellow-600 dark:bg-yellow-900/30 dark:text-yellow-400',
        'red' => 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400',
        'purple' => 'bg-purple-100 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400',
    ];
@endphp

<article class="flex items-center gap-4 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-6 transition-shadow duration-200 hover:shadow-md">
    @if($icon)
        <span class="rounded-full {{ $colorClasses[$color] }} p-3 flex-shrink-0">
            {{ $icon }}
        </span>
    @endif
    <div class="flex-1 min-w-0">
        @if($value)
            <p class="text-2xl font-semibold text-gray-900 dark:text-white truncate">{{ $value }}</p>
        @endif
        @if($title)
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $title }}</p>
        @endif
    </div>
    {{ $slot }}
</article>
