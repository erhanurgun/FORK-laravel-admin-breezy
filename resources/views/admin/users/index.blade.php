<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="sm:py-6">
        <div class="max-w-full mx-auto sm:px-6 sm:space-y-6">
            <x-card.app>
                <div class="flex">
                    <x-card.title>
                        {{ __("All Users") }}
                    </x-card.title>
                    <div class="ml-auto">
                        <x-button.link-primary href="{{ route('admin.users.create')}}">
                            {{ __('Create') }}
                        </x-button.link-primary>
                    </div>
                </div>
                @if (request('search') || request('role') || request('verified_account'))
                <x-card.description>
                    {{ __('Filter for') }}
                    @if (request('search'))
                    <span class="font-semibold">{{ request('search') }}</span>
                    @endif
                    @if (request('role'))
                    {{ __('role') }} <span class="font-semibold">{{ request('role') }}</span>
                    @endif
                    @if (request('verified_account'))
                    {{ __('status') }} <span class="font-semibold">
                        @if (request('verified_account') == 'true')
                        {{ __('verified') }}
                        @else
                        {{ __('not verified') }}
                        @endif
                    </span>
                    @endif
                </x-card.description>
                @else
                <x-card.description>
                    {{ __('Manage all user, search by name or email.') }}
                </x-card.description>
                @endif
                @if ($errors->any())
                <div>
                    <ul class="mt-3 list-none text-sm text-red-600 dark:text-red-400">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="mt-6 w-full">
                    <form class="flex gap-2 flex-col lg:flex-row justify-between">
                        <x-text-input id="search" name="search" type="text" class="w-full lg:w-1/3"
                            placeholder="{{ __('Search here') }}" value="{{ request('search') }}" autofocus />
                        <div class="flex items-center gap-2 justify-between">
                            <div class="">
                                <x-select-input id="role" name="role" class="">
                                    <option value="">{{ __('Select Role') }}</option>
                                    <option value="admin" {{ request('role')=='admin' ? 'selected' : '' }}>
                                        {{ __('Admin') }}
                                    </option>
                                    <option value="user" {{ request('role')=='user' ? 'selected' : '' }}>
                                        {{ __('User') }}
                                    </option>
                                </x-select-input>
                                <x-select-input id="verified_account" name="verified_account" class="">
                                    <option value="">{{ __('Select Status') }}</option>
                                    <option value="true" {{ request('verified_account')=='true' ? 'selected' : '' }}>
                                        {{ __('Verified') }}
                                    </option>
                                    <option value="false" {{ request('verified_account')=='false' ? 'selected' : '' }}>
                                        {{ __('Not Verified') }}
                                    </option>
                                </x-select-input>
                            </div>
                            <div class="">
                                <x-button.secondary type="submit">
                                    {{ __('Apply') }}
                                </x-button.secondary>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="gap-5 mt-6 grid grid-cols-1 lg:grid-cols-2 2xl:grid-cols-3">
                    @forelse ($users as $user)
                    <x-subcard.app>
                        <x-subcard.title>
                            <div class="flex justify-between">
                                <div class="flex items-center">
                                    <a href="{{ route('admin.users.show', $user) }}"
                                        class="text-lg font-medium text-gray-900 dark:text-gray-100 hover:text-indigo-600 hover:dark:text-indigo-400">
                                        {{$user->name }}
                                    </a>
                                    @if ($user->is_verified)
                                    <p class="ml-1 flex items-center">
                                        <x-badge.verified-account />
                                    </p>
                                    @else
                                    <p class="ml-1 flex items-center">
                                        <x-badge.unverified-account />
                                    </p>
                                    @endif
                                </div>
                                <div class="ml-auto">
                                    @include('admin.users.partials.action')
                                </div>
                            </div>
                        </x-subcard.title>
                        <p class="mt-2 text-base text-gray-500 dark:text-gray-400 flex items-center">
                            {{ $user->email }}
                            @if ($user->email_verified_at)
                            <x-badge.verified-email />
                            @endif
                        </p>
                        <p class="mt-2 text-base text-gray-500 dark:text-gray-400 flex items-center">
                            @if ($user->is_admin)
                            <x-badge.admin />
                            @else
                            <x-badge.user />
                            @endif
                        </p>
                    </x-subcard.app>
                    @empty
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">
                            {{ __('Data Not Found') }}
                        </p>
                    </div>
                    @endforelse
                </div>
                {{-- Pagination --}}
                @if ($users->hasPages())
                <div class="mt-6">
                    {{-- The default pagination view is pagination.custom-tailwind blade component.
                    You can change the default pagination view using the AppServiceProvider
                    or by passing the pagination view as parameter to the links method. --}}
                    {{ $users->links() }}
                    {{-- {{ $users->links('vendor.pagination.tailwind') }} --}}
                    {{-- {{ $users->links('vendor.pagination.simple-tailwind') }} --}}
                    {{-- {{ $users->links('vendor.pagination.custom-tailwind') }} --}}
                </div>
                @endif
            </x-card.app>
        </div>
    </div>
</x-admin-layout>