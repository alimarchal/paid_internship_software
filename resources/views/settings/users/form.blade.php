@php
    $editing = $user->exists;
    $currentRole = old('role', $user->roles->first()?->name ?? 'admin');
    $self = $editing && $user->id === auth()->id();
@endphp
<x-app-layout>
    <x-slot name="header">
        <x-page-header title="{{ $editing ? 'Edit User' : 'Add User' }}" backRoute="settings.users.index" :showRefresh="false"/>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <x-status-message/>
            <x-validation-errors/>

            <form method="POST" action="{{ $editing ? route('settings.users.update', $user) : route('settings.users.store') }}" class="bg-white shadow-xl sm:rounded-lg p-6 space-y-5">
                @csrf
                @if($editing) @method('PUT') @endif

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <x-label for="name" value="Name" :required="true"/>
                        <x-input id="name" name="name" type="text" class="block mt-1 w-full" required value="{{ old('name', $user->name) }}"/>
                    </div>
                    <div>
                        <x-label for="email" value="Email (login)" :required="true"/>
                        <x-input id="email" name="email" type="email" class="block mt-1 w-full" required value="{{ old('email', $user->email) }}"/>
                    </div>
                    <div>
                        <x-label for="role" value="Role" :required="true"/>
                        <select id="role" name="role" required class="border-gray-300 rounded-md shadow-sm block mt-1 w-full" onchange="toggleIntern()" @disabled($self)>
                            @foreach($roles as $r)
                                <option value="{{ $r }}" @selected($currentRole === $r)>{{ $r === 'Intern' ? 'Intern (candidate)' : $r }}</option>
                            @endforeach
                        </select>
                        @if($self)
                            <input type="hidden" name="role" value="{{ $currentRole }}">
                            <p class="text-xs text-gray-500 mt-1">You cannot change your own role.</p>
                        @endif
                    </div>
                    <div>
                        <x-label for="password" value="{{ $editing ? 'New password (leave blank to keep)' : 'Password (min 8)' }}" :required="! $editing"/>
                        <x-input id="password" name="password" type="text" autocomplete="off" class="block mt-1 w-full" :required="! $editing" value="{{ old('password') }}"/>
                    </div>
                    <div>
                        <x-label for="contact_number" value="Mobile"/>
                        <x-input id="contact_number" name="contact_number" type="text" class="block mt-1 w-full" value="{{ old('contact_number', $user->contact_number) }}"/>
                    </div>
                    <div>
                        <x-label for="cnic_number" value="CNIC"/>
                        <x-input id="cnic_number" name="cnic_number" type="text" class="block mt-1 w-full" value="{{ old('cnic_number', $user->cnic_number) }}"/>
                    </div>
                    <div id="batch-box">
                        <x-label for="batch_no" value="Batch (candidates only)"/>
                        <select id="batch_no" name="batch_no" class="border-gray-300 rounded-md shadow-sm block mt-1 w-full">
                            <option value="">Keep as it is</option>
                            @foreach($batches as $b)
                                <option value="{{ $b }}" @selected(old('batch_no', $editing ? $user->batch_no : '') === $b)>{{ $b }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <p class="text-xs text-gray-500">Accounts cannot be deleted from here. {{ $editing ? 'Created '.$user->created_at?->format('d-M-Y H:i').'.' : 'The email is marked verified so the user can sign in at once.' }}</p>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('settings.users.index') }}" class="px-4 py-2 text-gray-600 bg-white border rounded-md hover:bg-gray-100 text-sm">Back to list</a>
                    <x-button class="bg-blue-950 text-white hover:bg-green-800">Save</x-button>
                </div>
            </form>
        </div>
    </div>

    @push('modals')
        <script>
            function toggleIntern() {
                const r = document.getElementById('role');
                document.getElementById('batch-box').classList.toggle('hidden', r.value !== 'Intern');
            }
            toggleIntern();
        </script>
    @endpush
</x-app-layout>
