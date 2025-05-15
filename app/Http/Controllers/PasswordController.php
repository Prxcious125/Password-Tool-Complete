<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\SavedPassword;

class PasswordController extends Controller
{
    // Password Checker Methods
    public function showChecker()
    {
        $savedPasswords = auth()->check() ? auth()->user()->savedPasswords()->latest()->get() : collect();
        return view('password.checker', compact('savedPasswords'));
    }

    public function checkStrength(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $password = $request->input('password');
        $timeToCrack = $this->calculateTimeToCrack($password);
        $entropy = $this->calculateEntropy($password);
        $complexity = $this->getComplexityLevel($password);
        $feedback = $this->getFeedback($password);
        $strength = $this->calculateStrength($password);

        return back()->with([
            'password' => $password,
            'time_to_crack' => $timeToCrack,
            'entropy' => $entropy,
            'length' => strlen($password),
            'complexity' => $complexity,
            'feedback' => $feedback,
            'strength' => $strength
        ]);
    }

    // Password Generator Methods
    public function showGenerator()
    {
        $savedPasswords = auth()->check() ? auth()->user()->savedPasswords()->latest()->get() : collect();
        return view('password.generator', compact('savedPasswords'));
    }

    public function generatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'length' => 'required|integer|min:8|max:64'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $password = $this->generateSecurePassword(
            $request->input('length', 16)
        );

        $timeToCrack = $this->calculateTimeToCrack($password);
        $entropy = $this->calculateEntropy($password);
        $strength = $this->calculateStrength($password);

        return back()->with([
            'generated_password' => $password,
            'time_to_crack' => $timeToCrack,
            'entropy' => $entropy,
            'strength' => $strength,
            'length' => $request->input('length', 16)
        ]);
    }

    // Password Management Methods
    public function showAddForm()
    {
        return view('password.add');
    }

    public function storePassword(Request $request)
    {
        $validated = $request->validate([
            'platform' => 'required|string|max:255',
            'account_identifier' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'purpose' => 'nullable|string|max:255'
        ]);

        $validated['strength'] = $this->calculateStrength($validated['password']);
        $validated['user_id'] = auth()->id();

        SavedPassword::create($validated);

        return redirect()->route('password.history')
                        ->with('success', 'Password added successfully!');
    }

    public function showHistory()
    {
        $savedPasswords = auth()->user()->savedPasswords()
                              ->orderBy('created_at', 'desc')
                              ->paginate(10);
        
        return view('password.history', [
            'savedPasswords' => $savedPasswords
        ]);
    }

    public function deleteSavedPassword(SavedPassword $password)
    {
        if ($password->user_id !== auth()->id()) {
            abort(403);
        }

        $password->delete();
        return back()->with('success', 'Password deleted successfully!');
    }

    // Helper Methods
    private function generateSecurePassword(int $length): string
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+-=[]{}|;:,.<>?';
        $password = '';
        
        // Ensure at least one character from each category
        $password .= $this->randomChar('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
        $password .= $this->randomChar('abcdefghijklmnopqrstuvwxyz');
        $password .= $this->randomChar('0123456789');
        $password .= $this->randomChar('!@#$%^&*()_+-=[]{}|;:,.<>?');
        
        // Fill the rest randomly
        for ($i = strlen($password); $i < $length; $i++) {
            $password .= $chars[random_int(0, strlen($chars) - 1)];
        }
        
        // Shuffle to mix the guaranteed characters
        return str_shuffle($password);
    }

    private function randomChar(string $chars): string
    {
        return $chars[random_int(0, strlen($chars) - 1)];
    }

    private function calculateEntropy(string $password): int
    {
        $poolSize = 0;
        if (preg_match('/[a-z]/', $password)) $poolSize += 26;
        if (preg_match('/[A-Z]/', $password)) $poolSize += 26;
        if (preg_match('/[0-9]/', $password)) $poolSize += 10;
        if (preg_match('/[^A-Za-z0-9]/', $password)) $poolSize += 32;
        
        return (int) round(strlen($password) * log($poolSize, 2));
    }

    private function calculateTimeToCrack(string $password): string
    {
        $entropy = $this->calculateEntropy($password);
        
        // More conservative estimates
        $baseGuessesPerSecond = 1e9; // 1 billion guesses/second
        $hardwareMultiplier = 100; // Account for GPU clusters
        $totalGuessesPerSecond = $baseGuessesPerSecond * $hardwareMultiplier;
        
        $seconds = pow(2, $entropy) / $totalGuessesPerSecond;
        
        // Time units with more conservative estimates
        if ($seconds < 0.001) return 'Instant';
        if ($seconds < 1) return 'Less than a second';
        if ($seconds < 60) return round($seconds, 1).' seconds';
        if ($seconds < 3600) return round($seconds/60).' minutes';
        if ($seconds < 86400) return round($seconds/3600).' hours';
        if ($seconds < 2592000) return round($seconds/86400).' days';
        if ($seconds < 31536000) return round($seconds/2592000).' months';
        if ($seconds < 3153600000) return round($seconds/31536000).' years';
        return round($seconds/3153600000).' centuries';
    }

    private function getComplexityLevel(string $password): string
    {
        $score = 0;
        if (strlen($password) >= 12) $score++;
        if (preg_match('/[A-Z]/', $password)) $score++;
        if (preg_match('/[0-9]/', $password)) $score++;
        if (preg_match('/[^A-Za-z0-9]/', $password)) $score++;
        
        return match($score) {
            0, 1 => 'Very Weak',
            2 => 'Weak',
            3 => 'Strong',
            4 => 'Very Strong',
            default => 'Medium'
        };
    }

    private function calculateStrength(string $password): int
    {
        $score = 0;
        $length = strlen($password);
        
        $score += min(30, $length * 3);
        if (preg_match('/[A-Z]/', $password)) $score += 10;
        if (preg_match('/[a-z]/', $password)) $score += 10;
        if (preg_match('/[0-9]/', $password)) $score += 10;
        if (preg_match('/[^A-Za-z0-9]/', $password)) $score += 10;
        
        if ($password === str_repeat($password[0], $length)) $score -= 30;
        if (preg_match('/^(password|123456)/i', $password)) $score -= 30;
        
        return min(100, max(0, $score));
    }

    private function getFeedback(string $password): array
    {
        $suggestions = [];
        
        if (strlen($password) < 8) {
            $suggestions[] = "Use at least 8 characters";
        }
        if (!preg_match('/[A-Z]/', $password)) {
            $suggestions[] = "Include uppercase letters";
        }
        if (!preg_match('/[0-9]/', $password)) {
            $suggestions[] = "Include numbers";
        }
        if (!preg_match('/[^A-Za-z0-9]/', $password)) {
            $suggestions[] = "Include special characters";
        }
        
        return $suggestions;
    }
}





























































































/*namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
//use App\Models\SavedPassword;

class PasswordController extends Controller
{
    public function showChecker()
    {
        $savedPasswords = auth()->check() ? auth()->user()->savedPasswords()->latest()->get() : collect();
        return view('password.checker', compact('savedPasswords'));
    }

    public function checkStrength(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $password = $request->input('password');
        $strength = $this->calculateStrength($password);
        $feedback = $this->getFeedback($password);

        return back()->with([
            'password' => $password,
            'strength' => $strength,
            'feedback' => $feedback
        ]);
    }

    public function showGenerator()
    {
        $savedPasswords = auth()->check() ? auth()->user()->savedPasswords()->latest()->get() : collect();
        return view('password.generator', compact('savedPasswords'));
    }

    public function generatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'length' => 'required|integer|min:8|max:64',
            'include_numbers' => 'boolean',
            'include_symbols' => 'boolean',
            'include_uppercase' => 'boolean'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $password = $this->generateSecurePassword(
            $request->input('length', 12),
            $request->boolean('include_numbers', true),
            $request->boolean('include_symbols', true),
            $request->boolean('include_uppercase', true)
        );

        $strength = $this->calculateStrength($password);

        return back()->with([
            'generated_password' => $password,
            'strength' => $strength,
            'input' => $request->all()
        ]);
    }

    public function savePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8'
        ]);

        SavedPassword::create([
            'user_id' => auth()->id(),
            'password' => $request->password,
            'strength' => $this->calculateStrength($request->password)
        ]);

        return back()->with('success', 'Password saved successfully!');
    }

    public function deleteSavedPassword(SavedPassword $password)
    {
        if ($password->user_id !== auth()->id()) {
            abort(403);
        }

        $password->delete();
        return back()->with('success', 'Password deleted successfully!');
    }

    private function calculateStrength(string $password): int
    {
        $score = 0;
        $length = strlen($password);
        
        // Length contributes up to 30 points
        $score += min(30, $length * 3);
        
        // Character diversity
        if (preg_match('/[A-Z]/', $password)) $score += 10;
        if (preg_match('/[a-z]/', $password)) $score += 10;
        if (preg_match('/[0-9]/', $password)) $score += 10;
        if (preg_match('/[^A-Za-z0-9]/', $password)) $score += 10;
        
        // Deduct for weak patterns
        if ($password === str_repeat($password[0], $length)) $score -= 30;
        if (preg_match('/^(password|123456)/i', $password)) $score -= 30;
        
        return min(100, max(0, $score));
    }

    private function getFeedback(string $password): array
    {
        $suggestions = [];
        
        if (strlen($password) < 8) {
            $suggestions[] = "Use at least 8 characters";
        }
        if (!preg_match('/[A-Z]/', $password)) {
            $suggestions[] = "Include uppercase letters";
        }
        if (!preg_match('/[0-9]/', $password)) {
            $suggestions[] = "Include numbers";
        }
        if (!preg_match('/[^A-Za-z0-9]/', $password)) {
            $suggestions[] = "Include special characters";
        }
        
        return $suggestions;
    }

    private function generateSecurePassword(
        int $length = 12,
        bool $includeNumbers = true,
        bool $includeSymbols = true,
        bool $includeUppercase = true
    ): string {
        $chars = 'abcdefghijklmnopqrstuvwxyz';
        if ($includeUppercase) $chars .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if ($includeNumbers) $chars .= '0123456789';
        if ($includeSymbols) $chars .= '!@#$%^&*()';
        
        return substr(str_shuffle(str_repeat($chars, 5)), 0, $length);
    }
public function showHistory()
{
    $savedPasswords = auth()->user()->savedPasswords()
                          ->orderBy('created_at', 'desc')
                          ->paginate(10);
    
    return view('password/history', [
        'savedPasswords' => $savedPasswords
    ]);
}
public function showAddForm()
{
    // No need to pass platforms anymore
    return view('password.add');
}

public function storePassword(Request $request)
{
    $validated = $request->validate([
        'platform' => 'required|string|max:255', // Changed from enum validation
        'account_identifier' => 'required|string|max:255',
        'password' => 'required|string|min:8',
        'purpose' => 'nullable|string|max:255',
        'strength' => 'nullable|integer|min:0|max:100'
    ]);

    auth()->user()->savedPasswords()->create($validated);

    return redirect()->route('password.history')
                    ->with('success', 'Password added successfully!');
}

} // End class*/