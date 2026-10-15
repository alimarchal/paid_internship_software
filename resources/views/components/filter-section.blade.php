@props([
    'action' => '#',
    'open' => false,
    'maxWidth' => 'max-w-7xl',
])

<div class="{{ $maxWidth }} mx-auto sm:px-6 lg:px-8 mt-4">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" id="filters" style="{{ $open ? '' : 'display: none' }}">
        <div class="p-6">
            <form method="GET" action="{{ $action }}">
                {{ $slot }}

                <div class="mt-4 flex space-x-3">
                    <x-button class="bg-blue-950 text-white hover:bg-green-800">Apply Filters</x-button>
                    <a href="{{ $action }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50">Reset</a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('modals')
    <script>
        (function () {
            const box = document.getElementById('filters');
            const btn = document.getElementById('toggle');
            if (!box || !btn) return;
            btn.addEventListener('click', function () {
                box.style.display = box.style.display === 'none' ? 'block' : 'none';
            });
        })();
    </script>
@endpush
