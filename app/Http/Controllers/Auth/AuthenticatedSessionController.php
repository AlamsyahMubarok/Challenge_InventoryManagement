<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    private array $allowedDemoEmails = [
        'admin@example.com',
        'staff@example.com',
        'manager@example.com',
    ];

    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $email = strtolower(trim((string) $request->input('email')));

        $request->merge([
            'email' => $email,
        ]);

        $request->validate([
            'email' => [
                'required',
                'string',
                'email',
                function ($attribute, $value, $fail) {
                    $email = strtolower(trim((string) $value));

                    if (! $this->isAllowedEmail($email)) {
                        $fail('Harap gunakan email valid @gmail.com.');
                    }
                },
            ],

            'password' => ['required', 'string'],
        ]);

        $this->ensureIsNotRateLimited($request);

        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey($request));

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        $user = Auth::user();

        if ($user instanceof User && ! $this->isAllowedEmail($user->email)) {
            Auth::logout();

            throw ValidationException::withMessages([
                'email' => 'Akun ini tidak dapat digunakan. Harap gunakan email valid @gmail.com.',
            ]);
        }

        RateLimiter::clear($this->throttleKey($request));

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    private function isAllowedEmail(string $email): bool
    {
        $email = strtolower(trim($email));

        return str_ends_with($email, '@gmail.com')
            || in_array($email, $this->allowedDemoEmails, true);
    }

    private function ensureIsNotRateLimited(Request $request): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            return;
        }

        event(new Lockout($request));

        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    private function throttleKey(Request $request): string
    {
        return Str::transliterate(
            Str::lower($request->string('email')).'|'.$request->ip()
        );
    }
}
