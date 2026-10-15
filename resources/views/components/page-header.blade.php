@props([
    'title' => 'Page Title',
    'createRoute' => null,
    'createLabel' => 'Add New',
    'showSearch' => false,
    'showRefresh' => true,
    'backRoute' => 'dashboard',
])

@php
    $btn = 'inline-flex items-center px-4 py-2 bg-blue-950 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-800 focus:bg-green-800 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150';
@endphp

<div class="flex justify-between items-center">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight inline-block">{{ $title }}</h2>

    <div class="flex justify-center items-center space-x-2">
        {{ $slot }}

        @if($createRoute)
            <a href="{{ $createRoute }}" class="{{ $btn }}">
                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span class="hidden md:inline-block ml-1">{{ $createLabel }}</span>
            </a>
        @endif

        @if($showSearch)
            <button id="toggle" type="button" title="Filters" class="{{ $btn }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75"/></svg>
                <span class="hidden md:inline-block ml-1">Filters</span>
            </button>
        @endif

        @if($showRefresh)
            <a href="javascript:window.location.reload();" title="Refresh" class="{{ $btn }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>
            </a>
        @endif

        <a href="{{ str_starts_with($backRoute, 'http') || str_starts_with($backRoute, '/') ? $backRoute : route($backRoute) }}" title="Back" class="{{ $btn }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3"/></svg>
        </a>
    </div>
</div>
