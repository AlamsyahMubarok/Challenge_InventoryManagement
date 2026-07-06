<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    private array $allowedDemoEmails = [
        'admin@example.com',
        'staff@example.com',
        'manager@example.com',
    ];

    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $email = strtolower(trim((string) $request->input('email')));

        $request->merge([
            'email' => $email,
        ]);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:'.User::class,
                function ($attribute, $value, $fail) {
                    $email = strtolower(trim((string) $value));

                    if (! $this->isAllowedEmail($email)) {
                        $fail('Harap gunakan email valid @gmail.com.');
                    }
                },
            ],

            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $staffRoleId = Role::where('name', 'staff')->value('id');

        $user = User::create([
            'name' => $request->name,
            'email' => $email,
            'password' => Hash::make($request->password),
            'role_id' => $staffRoleId,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    private function isAllowedEmail(string $email): bool
    {
        $email = strtolower(trim($email));

        return str_ends_with($email, '@gmail.com')
            || in_array($email, $this->allowedDemoEmails, true);
    }
}
