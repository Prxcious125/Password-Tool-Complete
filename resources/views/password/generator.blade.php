@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center justify-center px-4 sm:px-0 space-y-4 mt-10 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/background.jpeg') }}');">

    <!-- Password Generator Box -->
    <div class="w-full max-w-md bg-white p-4 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Smart Password Generator</h1>
        <form method="POST" action="{{ route('password.generate') }}" class="mb-6">
            @csrf
            <div class="mb-4">
                <label for="length" class="block text-gray-700 mb-2">Password Length:</label>
                <select name="length" id="length" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="12">Standard (12 characters)</option>
                    <option value="16">Strong (16 characters)</option>
                    <option value="20">Very Strong (20 characters)</option>
                    <option value="24">Ultra Secure (24 characters)</option>
                </select>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition duration-200">
                Generate Secure Password
            </button>
        </form>

        @if(session('generated_password'))
        <div class="bg-gray-50 p-4 rounded-lg mb-2">
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Generated Password:</label>
                <div class="flex">
                    <input type="text" id="generatedPassword" 
                           value="{{ session('generated_password') }}"
                           class="flex-grow px-4 py-2 border rounded-l-lg focus:outline-none font-mono text-lg"
                           readonly>
                    <button onclick="copyToClipboard('generatedPassword')"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-r-lg transition duration-200">
                        Copy
                    </button>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Cybersecurity Awareness Box -->
    <div class="w-full max-w-4xl bg-white shadow-lg rounded-lg p-6 text-gray-800 space-y-6">
        <h2 class="text-2xl font-bold text-blue-700">🛡️ Cybersecurity Awareness & Password Safety</h2>

        <!-- Cybersecurity Importance -->
        <div>
            <h3 class="text-xl font-semibold mb-2">🌐 Why Is Cybersecurity Important?</h3>
            <p>
                Every time you go online, you expose yourself to potential threats. Cybercriminals aim to steal personal data, financial credentials, and even your digital identity.
            </p>
            <p class="mt-2 text-red-700 font-semibold">
                🚨 Over 30 million passwords are stolen every day across the globe — that’s more than 350 every second!
            </p>
        </div>

        <!-- Password Best Practices -->
        <div>
            <h3 class="text-xl font-semibold mb-2">🔐 Password Management Tips</h3>
            <ul class="list-disc pl-5 space-y-2">
                <li><strong>Create strong passwords:</strong> Mix uppercase, lowercase, numbers, and symbols.</li>
                <li><strong>Avoid personal info:</strong> Don't use names, birthdays, or common phrases.</li>
                <li><strong>Use unique passwords:</strong> One password per account — no repeats.</li>
                <li><strong>Consider a password manager:</strong> Store and autofill passwords securely.</li>
                <li><strong>Enable Two-Factor Authentication (2FA):</strong> Adds a second layer of protection.</li>
            </ul>
        </div>

        <!-- Common Threats -->
        <div>
            <h3 class="text-xl font-semibold mb-2 text-red-700">⚠️ Common Cyber Threats</h3>
            <ul class="list-disc pl-5 space-y-2">
                <li><strong>Phishing:</strong> Fake emails or links pretending to be trusted sources.</li>
                <li><strong>Malware:</strong> Malicious software like keyloggers that steal credentials.</li>
                <li><strong>Brute-force attacks:</strong> Automated guessing of weak passwords.</li>
                <li><strong>Social engineering:</strong> Manipulation to gain access to private info.</li>
                <li><strong>Wi-Fi sniffing:</strong> Data theft on unsecured public networks.</li>
            </ul>
        </div>

        <!-- Smart Habits -->
        <div>
            <h3 class="text-xl font-semibold mb-2">🧠 Smart Cyber Habits</h3>
            <ul class="list-disc pl-5 space-y-2">
                <li>Log out from devices after use — especially public ones.</li>
                <li>Install antivirus and update it regularly.</li>
                <li>Use HTTPS sites for secure communication.</li>
            </ul>
        </div>
             <div class="text-center">
            <a href="{{ route('password.checker') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition">
                Generate your passwords
            </a>
        </div>

        <p class="text-xs text-center text-gray-500 pt-4">
            Stay alert. Stay secure. Protect your digital life.
        </p>
    </div>
</div>
<script>
function copyToClipboard(elementId) {
    const input = document.getElementById(elementId);
    input.select();
    input.setSelectionRange(0, 99999); // For mobile

    navigator.clipboard.writeText(input.value)
        .then(() => alert("Password copied!"))
        .catch(err => alert("Copy failed: " + err));
}
</script>
@endsection