@php
    $icon = fn ($path) => '<svg class="w-[18px] h-[18px] text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="'.$path.'"/></svg>';
@endphp
<x-app-layout>
    <x-slot name="header">
        <x-page-header title="Settings" :showRefresh="false" backRoute="dashboard"/>
    </x-slot>

    <div class="py-6 bg-[#F2F1F5] min-h-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-status-message class="mb-4"/>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div>
                    <p class="px-4 mb-1 text-[11px] font-semibold uppercase tracking-widest text-gray-500">Question Bank</p>
                    <div class="bg-white rounded-2xl overflow-hidden shadow-lg">
                        <x-settings-row href="{{ route('settings.categories.index') }}" label="Categories" description="Organise questions into categories" :count="$categories" icon-bg="bg-indigo-500">
                            <x-slot name="icon">{!! $icon('M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z') !!}</x-slot>
                        </x-settings-row>
                        <div class="ml-[58px] h-px bg-gray-100"></div>
                        <x-settings-row href="{{ route('settings.questions.index') }}" label="Questions & Answers" description="{{ $answers }} answers. Add, view and edit together" :count="$questions" icon-bg="bg-blue-500">
                            <x-slot name="icon">{!! $icon('M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z') !!}</x-slot>
                        </x-settings-row>
                    </div>
                </div>

                <div>
                    <p class="px-4 mb-1 text-[11px] font-semibold uppercase tracking-widest text-gray-500">Exam</p>
                    <div class="bg-white rounded-2xl overflow-hidden shadow-lg">
                        <x-settings-row href="{{ route('settings.batch-exam.index') }}" label="Batch Exam Setup" description="Start test, password, timings and paper for many candidates" :count="$candidates" icon-bg="bg-green-600">
                            <x-slot name="icon">{!! $icon('M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342') !!}</x-slot>
                        </x-settings-row>
                    </div>
                </div>

                <div>
                    <p class="px-4 mb-1 text-[11px] font-semibold uppercase tracking-widest text-gray-500">Registration</p>
                    <div class="bg-white rounded-2xl overflow-hidden shadow-lg">
                        <x-settings-row href="{{ route('settings.batches.index') }}" label="Batches & Registration" description="Add a batch, registration batch and last date" :count="\App\Models\Batch::count()" icon-bg="bg-orange-500">
                            <x-slot name="icon">{!! $icon('M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z') !!}</x-slot>
                        </x-settings-row>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
