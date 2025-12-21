@props([
    'responsive' => true,
])

<div @if($responsive) class="overflow-x-auto" @endif>
    <table {{ $attributes->merge(['class' => 'min-w-full divide-y divide-gray-200 dark:divide-gray-700']) }}>
        {{ $slot }}
    </table>
</div>
