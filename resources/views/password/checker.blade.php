@extends('layouts.app')

@section('content')

<div class="flex flex-col items-center justify-center px-4 sm:px-0 space-y-4 mt-10 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/a-dashboard-interface-for-a-secure.jpeg') }}');">

<div class="max-w-md mx-auto p-6 mt-10 bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Password Security Checker</h1>
    
    <form method="POST" action="{{ route('password.check') }}" class="mb-">
        @csrf
        <div class="mb-4">
            <label for="password" class="block text-gray-700 mb-2">Enter Password:</label>
            <input type="password" name="password" id="password" 
                   value="{{ session('password') }}"
                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                   required autocomplete="off">
        </div>
        <button type="submit" 
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition duration-200">
            Check Security
        </button>
    </form>

    @if(session('time_to_crack'))
    <div class="bg-gray-50 p-4 rounded-lg">
        <div class="space-y-4">
            <div class="p-3 bg-blue-50 rounded-lg">
                <h3 class="font-semibold text-blue-800 mb-1">Estimated Time to Crack</h3>
                <p class="text-2xl font-bold @if(session('time_to_crack') === 'Instant') text-red-600 @else text-green-600 @endif">
                    {{ session('time_to_crack') }}
                </p>
                <p class="text-xs text-gray-500 mt-1">Based on a brute-force attack with modern hardware</p>
            </div>

            <div class="grid grid-cols-3 gap-2 text-center">
                <div class="p-2 bg-gray-100 rounded">
                    <p class="text-xs text-gray-500">Length</p>
                    <p class="font-semibold">{{ session('length') }} chars</p>
                </div>
                <div class="p-2 bg-gray-100 rounded">
                    <p class="text-xs text-gray-500">Complexity</p>
                    <p class="font-semibold">{{ session('complexity') }}</p>
                </div>
                <div class="p-2 bg-gray-100 rounded">
                    <p class="text-xs text-gray-500">Entropy</p>
                    <p class="font-semibold">{{ session('entropy') }} bits</p>
                </div>
            </div>

            @if(session('feedback'))
            <div class="mt-2">
                <h3 class="font-semibold text-gray-800 mb-2">Security Recommendations:</h3>
                <ul class="space-y-2">
                    @foreach(session('feedback') as $tip)
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-yellow-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span class="text-sm">{{ $tip }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>
<div class=" bg-gray-100 py-12 px-4">
    <div class="max-w-3xl mx-auto bg-white shadow-xl rounded-lg p-8 text-gray-800 space-y-6">
        <h2 class="text-2xl font-bold text-center text-blue-600">Password Strength & Cybersecurity Awareness</h2>

        <p class="text-lg leading-relaxed">
            Every day, over <span class="font-semibold text-red-600">30 million passwords</span> are stolen or leaked through various cyberattacks. Weak or reused passwords are among the leading causes of these breaches.
        </p>

        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
            <h3 class="font-semibold text-blue-700 mb-2">Why Password Strength Matters</h3>
            <ul class="list-disc pl-6 space-y-1 text-sm text-gray-700">
                <li>Strong passwords help protect your identity and personal data.</li>
                <li>Cybercriminals use automated tools to guess weak passwords in seconds.</li>
                <li>A long, complex password could take centuries to crack using brute force attacks.</li>
                <li>Never reuse passwords across multiple accounts.</li>
            </ul>
        </div>

        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded">
            <h3 class="font-semibold text-yellow-700 mb-2">Tips for Creating Strong Passwords</h3>
            <ul class="list-disc pl-6 space-y-1 text-sm text-gray-700">
                <li>Use at least 12 characters – the longer, the better.</li>
                <li>Mix uppercase and lowercase letters, numbers, and symbols.</li>
                <li>Avoid using dictionary words, names, or easily guessable patterns (like “123456” or “password”).</li>
                <li>Consider using a passphrase that is both unique and memorable.</li>
            </ul>
        </div>

        <div class="bg-green-50 border-l-4 border-green-600 p-4 rounded">
            <h3 class="font-semibold text-green-700 mb-2">Did You Know?</h3>
            <p class="text-sm text-gray-700">
                According to cybersecurity research, a strong password like <code class="bg-gray-200 px-1 py-0.5 rounded">xZ7!vB#9@Wq$</code> can take up to <span class="font-bold text-green-800">thousands of years</span> to crack using brute-force methods. 
            </p>
        </div>

        <div class="text-center">
            <a href="{{ route('password.checker') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition">
                Check Your Password Strength
            </a>
        </div>

        <p class="text-xs text-center text-gray-500 pt-4">
            Stay alert. Stay secure. Protect your digital life.
        </p>
    </div>
</div>
</div>
{{-- < class="min-h-screen bg-gray-100 py-12 px-4">
    <div class="max-w-3xl mx-auto bg-white shadow-xl rounded-lg p-8 text-gray-800 space-y-6">
        <h2 class="text-2xl font-bold text-center text-blue-600">Password Strength & Cybersecurity Awareness</h2>

        <p class="text-lg leading-relaxed">
            Every day, over <span class="font-semibold text-red-600">30 million passwords</span> are stolen or leaked through various cyberattacks. Weak or reused passwords are among the leading causes of these breaches.
        </p>

        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
            <h3 class="font-semibold text-blue-700 mb-2">Why Password Strength Matters</h3>
            <ul class="list-disc pl-6 space-y-1 text-sm text-gray-700">
                <li>Strong passwords help protect your identity and personal data.</li>
                <li>Cybercriminals use automated tools to guess weak passwords in seconds.</li>
                <li>A long, complex password could take centuries to crack using brute force attacks.</li>
                <li>Never reuse passwords across multiple accounts.</li>
            </ul>
        </div>

        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded">
            <h3 class="font-semibold text-yellow-700 mb-2">Tips for Creating Strong Passwords</h3>
            <ul class="list-disc pl-6 space-y-1 text-sm text-gray-700">
                <li>Use at least 12 characters – the longer, the better.</li>
                <li>Mix uppercase and lowercase letters, numbers, and symbols.</li>
                <li>Avoid using dictionary words, names, or easily guessable patterns (like “123456” or “password”).</li>
                <li>Consider using a passphrase that is both unique and memorable.</li>
            </ul>
        </div>

        <div class="bg-green-50 border-l-4 border-green-600 p-4 rounded">
            <h3 class="font-semibold text-green-700 mb-2">Did You Know?</h3>
            <p class="text-sm text-gray-700">
                According to cybersecurity research, a strong password like <code class="bg-gray-200 px-1 py-0.5 rounded">xZ7!vB#9@Wq$</code> can take up to <span class="font-bold text-green-800">thousands of years</span> to crack using brute-force methods. 
            </p>
        </div>

        <div class="text-center">
            <a href="{{ route('password.checker') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition">
                Check Your Password Strength
            </a>
        </div>

        <p class="text-xs text-center text-gray-500 pt-4">
            Stay alert. Stay secure. Protect your digital life.
        </p>
    </div> --}}

<script>
// Live password strength estimation as they type
document.getElementById('password').addEventListener('input', function(e) {
    // You can add live estimation here if needed
});
</script>
@endsection































































{{-- <div class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Password Strength Checker</h1>
    
    <form method="POST" action="{{ route('password.check') }}" class="mb-6">
        @csrf
        <div class="mb-4">
            <label for="password" class="block text-gray-700 mb-2">Enter Password:</label>
            <input type="password" name="password" id="password" 
                   value="{{ session('password') }}"
                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                   required>
        </div>
        <button type="submit" 
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition duration-200">
            Check Strength
        </button>
    </form>

    @if(session('strength'))
    <div class="bg-gray-50 p-4 rounded-lg">
        <div class="mb-4">
            <div class="flex justify-between mb-1">
                <span class="text-sm font-medium">Password Strength</span>
                <span class="text-sm">{{ session('strength') }}%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div class="h-2.5 rounded-full 
                    @if(session('strength') < 40) bg-red-500
                    @elseif(session('strength') < 70) bg-yellow-500
                    @else bg-green-500 @endif" 
                    style="width: {{ session('strength') }}%"></div>
            </div>
        </div>

        @if(session('feedback'))
        <div class="mt-4">
            <h3 class="font-semibold text-gray-800 mb-2">Suggestions:</h3>
            <ul class="list-disc pl-5 space-y-1 text-sm text-gray-600">
                @foreach(session('feedback') as $tip)
                <li>{{ $tip }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
    @endif
</div>
@endsection --}}