{{-- resources/views/profile/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[var(--text)] leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl w-full mx-auto sm:px-6 lg:px-8 space-y-6">  {{-- ← antes: max-w-7xl OK; lo importante es NO limitar a max-w-xl más abajo --}}
            <div class="p-6 sm:p-8 bg-[var(--card)] border border-[color:var(--border)] shadow sm:rounded-xl">
                <div class="w-full"> {{-- ← antes: max-w-xl (quitar esa restricción) --}}
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- los otros dos blocks iguales: quitar max-w-xl --}}
            <div class="p-6 sm:p-8 bg-[var(--card)] border border-[color:var(--border)] shadow sm:rounded-xl">
                <div class="w-full">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-6 sm:p-8 bg-[var(--card)] border border-[color:var(--border)] shadow sm:rounded-xl">
                <div class="w-full">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
