<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('title', 'Dashboard')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Dashboard') }}
    </h2>
@endsection

@section('content')
    <!-- Main content with full-height background -->
    <div class="min-h-screen flex flex-col items-center justify-start bg-cover bg-center bg-no-repeat bg-fixed" style="background-image: url('{{ asset('images/background.jpeg') }}');">
        
        <!-- Welcome message card -->
        <div class="w-full max-w-7xl mx-auto mt-10 px-4 sm:px-6 lg:px-8">
            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm overflow-hidden shadow-sm sm:rounded-lg">
                {{-- <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div> --}}
            </div>
        </div>

        <!-- Centered buttons section -->
        <div class="flex-grow flex flex-col items-center justify-center w-full px-4 sm:px-0">
            <div class="text-center p-8 bg-black/50 dark:bg-gray-900/70 backdrop-blur rounded-xl max-w-md w-full">
                <h2 class="text-3xl font-bold text-white mb-6">Welcome to Your Dashboard</h2>
                
                <div class="space-y-4">
    <!-- Password Check (POST) -->
    <form method="GET" action="{{ route('password.checker') }}" class="w-full">
        @csrf
        <button type="submit" class="w-full px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg border border-white/30 transition duration-200 ease-in-out transform hover:scale-105 flex items-center justify-center">
             <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
      <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
    </svg>
            Check Password Strength
        </button>
    </form>

    <!-- Password Generator (GET) -->
    <form method="GET" action="{{ route('password.generator') }}" class="w-full">
    <button type="submit" class="w-full px-6 py-3  bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg border border-white/30 transition duration-200 ease-in-out transform hover:scale-105 flex items-center justify-center">
         <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
  <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
</svg>
        Generate a New Password
    </button>
</form>
</div>
                
                <p class="text-white/80 mt-6 text-sm">Choose an option to get started</p>
            </div>
        </div>
    </div>
@endsection