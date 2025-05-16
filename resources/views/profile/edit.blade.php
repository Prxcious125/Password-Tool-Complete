@extends('layouts.app')

@section('title', 'Profile Settings')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- Just include the partials directly --}}
        @include('profile.partials.update-profile-information-form')

        @include('profile.partials.update-password-form')

        @include('profile.partials.delete-user-form')

    </div>
</div>

@if (session('status') === 'profile-updated')
    <div 
        x-data="{ show: true }" 
        x-show="show" 
        x-transition 
        x-init="setTimeout(() => show = false, 5000)" 
        class="fixed bottom-5 right-5 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg"
    >
        {{ __('Profile updated successfully!') }}
    </div>
@endif
@endsection
