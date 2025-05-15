@extends('layouts.app')

@section('title', 'Add New Password')

@section('content')
<div class="max-w-md mx-auto py-6">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-bold mb-6">Add New Platform Password</h2>
        
        <form method="POST" action="{{ route('passwords.store') }}">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Platform Name</label>
                <input type="text" name="platform" required
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                       placeholder="e.g. Facebook, Gmail, Netflix">
                <p class="mt-1 text-sm text-gray-500">Enter the name of the service/platform</p>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Email/Username</label>
                <input type="text" name="account_identifier" required
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                       placeholder="your@email.com">
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Password</label>
                <div class="flex">
                    <input type="password" name="password" id="passwordInput" required
                           class="flex-1 px-4 py-2 border rounded-l-lg focus:ring-2 focus:ring-blue-500"
                           placeholder="••••••••">
                    <button type="button" onclick="togglePasswordVisibility()"
                            class="px-4 bg-gray-100 border-t border-r border-b rounded-r-lg hover:bg-gray-200 transition">
                        👁️
                    </button>
                </div>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Notes (Optional)</label>
                <textarea name="purpose" rows="2"
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                       placeholder="Any additional information"></textarea>
            </div>
            
            <input type="hidden" name="strength" id="strengthValue" value="0">
            
            <div class="mt-6">
                <button type="submit" 
                        class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Save Password
                </button>
            </div>
        </form>
    </div>
    
    <div class="mt-4 text-center">
        <a href="{{ route('password.history') }}" 
           class="text-blue-600 hover:text-blue-800 text-sm inline-flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Password History
        </a>
    </div>
</div>

<script>
function togglePasswordVisibility() {
    const input = document.getElementById('passwordInput');
    const button = event.currentTarget;
    if (input.type === 'password') {
        input.type = 'text';
        button.innerHTML = '🙈';
    } else {
        input.type = 'password';
        button.innerHTML = '👁️';
    }
}

// Optional: Add password strength meter
document.getElementById('passwordInput')?.addEventListener('input', function(e) {
    // Strength calculation logic would go here
    // document.getElementById('strengthValue').value = calculatedStrength;
});
</script>
@endsection