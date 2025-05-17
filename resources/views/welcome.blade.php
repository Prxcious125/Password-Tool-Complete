<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
         @vite(['resources/css/app.css']) <!-- Load Tailwind -->
        <!-- Styles -->
    </head>
    <body class="antialiased">
    <div class="relative sm:flex sm:justify-center sm:items-center h-16 bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        @if (Route::has('login'))
            <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                @auth
                    <a href="{{ route('dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                    @endif
                @endauth
            </div>
        @endif

  </div>      

    <!-- Background Image Section -->
    <div class="flex-grow flex flex-col items-center justify-center w-full min-h-screen px-9 sm:px-0" style="background-image: url('{{ asset('images/a-dashboard-interface-for-a-secure.jpeg') }}');">
            <div class="text-center p-8 bg-black/50 dark:bg-gray-900/70 backdrop-blur rounded-xl max-w-md w-full">
                <h2 class="text-3xl font-bold text-white mb-6">Welcome to Your Dashboard</h2>
                
                <div class="space-y-4">
    <!-- Password Check (POST) -->
    <form method="POST" action="{{ route('password.check') }}" class="w-full">
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
        
</body>
</html>
