<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-semibold tracking-tight text-[#0f172a]">Profile</h1>
    </x-slot>

    <div class="px-4 sm:px-6 lg:px-8 pb-8">
        <div class="max-w-2xl space-y-5">
            <div class="bg-white border border-[#e2e8f0] rounded-xl shadow-sm p-6">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="bg-white border border-[#e2e8f0] rounded-xl shadow-sm p-6">
                @include('profile.partials.update-password-form')
            </div>

            <div class="bg-white border border-[#e2e8f0] rounded-xl shadow-sm p-6">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
