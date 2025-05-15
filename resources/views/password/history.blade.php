@extends('layouts.app')

@section('title', 'Password History')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        @auth
            @if($savedPasswords->isNotEmpty())
                <div class="mt-8">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Your Password History</h2>
                    
                    <div class="mb-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div class="relative w-full sm:w-96">
                            <input type="text" id="passwordSearch" placeholder="Search by password or purpose..." 
                                   class="w-full pl-4 pr-10 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <div class="absolute right-3 top-2.5 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4 w-full sm:w-auto">
                            <div class="text-sm text-gray-500 whitespace-nowrap">
                                {{ $savedPasswords->total() }} saved passwords
                            </div>
                            <button id="exportBtn" class="text-sm text-blue-600 hover:text-blue-800 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Export
                            </button>
                        </div>
                    </div>

                    <div class="space-y-3" id="passwordHistory">
                        @foreach($savedPasswords as $password)
                        <div class="password-item group flex flex-col sm:flex-row justify-between items-start sm:items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200 border border-gray-200">
                            <div class="mb-3 sm:mb-0 sm:mr-4">
                                <div class="flex items-center">
                                    <span class="font-mono text-gray-800 password-text select-none" onclick="togglePasswordVisibility(this)">
                                        ••••••••••••
                                    </span>
                                    <span class="font-mono text-gray-800 password-actual hidden">{{ $password->password }}</span>
                                    <button class="ml-2 text-gray-400 hover:text-gray-600" onclick="copyPasswordText(this)" data-password="{{ $password->password }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="text-xs text-gray-500 mt-2">
                                    <span>Created: {{ $password->created_at->format('M d, Y H:i') }}</span>
                                    @if($password->purpose)
                                    <span class="ml-2">• Purpose: <span class="font-medium">{{ $password->purpose }}</span></span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-4 self-end sm:self-auto">
                                <div class="flex items-center">
                                    <span class="text-xs font-medium mr-2">Strength:</span>
                                    <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                                        <div class="h-2 rounded-full 
                                            @if($password->strength < 40) bg-red-500
                                            @elseif($password->strength < 70) bg-yellow-500
                                            @else bg-green-500 @endif" 
                                            style="width: {{ $password->strength }}%">
                                        </div>
                                    </div>
                                    <span class="text-xs">{{ $password->strength }}%</span>
                                </div>
                                <form method="POST" action="{{ route('password.delete', $password) }}" onsubmit="return confirm('Are you sure you want to delete this password?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-500 hover:text-red-700 text-sm flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    @if($savedPasswords->hasPages())
                    <div class="mt-6">
                        {{ $savedPasswords->onEachSide(1)->links() }}
                    </div>
                    @endif
                </div>
            @else
                <div class="text-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No saved passwords yet</h3>
                    <p class="mt-1 text-sm text-gray-500">Your generated passwords will appear here when you save them.</p>
                    <div class="mt-6">
                        <a href="{{ route('password.generator') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                            Generate a Password
                        </a>
                    </div>
                </div>
            @endif
        @else
@auth
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold text-gray-800">Your Password History</h2>
    <a href="{{ route('passwords.add') }}" 
       class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
       + Add Password
    </a>
</div>
@endauth
            <div class="text-center py-12">
                <p class="text-gray-500">Please login to view your password history.</p>
            </div>
        @endauth
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    document.getElementById('passwordSearch')?.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const passwordItems = document.querySelectorAll('.password-item');
        
        passwordItems.forEach(item => {
            const passwordText = item.textContent.toLowerCase();
            item.style.display = passwordText.includes(searchTerm) ? '' : 'none';
        });
    });

    // Export functionality
    document.getElementById('exportBtn')?.addEventListener('click', function() {
        const passwords = Array.from(document.querySelectorAll('.password-actual'))
            .map(el => el.textContent)
            .join('\n');
        
        if (passwords) {
            const blob = new Blob([passwords], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'my-passwords-' + new Date().toISOString().split('T')[0] + '.txt';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }
    });
});

function togglePasswordVisibility(element) {
    const container = element.closest('.flex.items-center');
    const hiddenText = container.querySelector('.password-text');
    const actualText = container.querySelector('.password-actual');
    
    if (hiddenText.classList.contains('hidden')) {
        hiddenText.classList.remove('hidden');
        actualText.classList.add('hidden');
    } else {
        hiddenText.classList.add('hidden');
        actualText.classList.remove('hidden');
        
        // Auto-hide after 10 seconds
        setTimeout(() => {
            if (!actualText.classList.contains('hidden')) {
                hiddenText.classList.remove('hidden');
                actualText.classList.add('hidden');
            }
        }, 10000);
    }
}

function copyPasswordText(button) {
    const password = button.getAttribute('data-password');
    navigator.clipboard.writeText(password).then(() => {
        const originalHTML = button.innerHTML;
        button.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        `;
        setTimeout(() => {
            button.innerHTML = originalHTML;
        }, 2000);
    });
}
</script>
@endsection