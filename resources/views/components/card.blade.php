@props([
    'title' => null,
    'subtitle' => null,
])

<div {{ $attributes->merge(['class' => 'bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6']) }}>
    @if($title || $subtitle)
        <div class="mb-6">
            @if($title)
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $title }}</h2>
            @endif
            @if($subtitle)
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $subtitle }}</p>
            @endif
        </div>
    @endif
    
    {{ $slot }}
</div>
