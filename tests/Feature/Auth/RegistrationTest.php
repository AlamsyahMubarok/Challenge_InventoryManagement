<?php

use App\Models\Role;
use App\Models\User;

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register with gmail email', function () {
    Role::query()->firstOrCreate([
        'name' => 'staff',
    ]);

    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'testuserregister@gmail.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();

    $response->assertRedirect(route('dashboard', absolute: false));

    $user = User::query()->where('email', 'testuserregister@gmail.com')->first();

    expect($user)->not->toBeNull();
    expect($user->role->name)->toBe('staff');
});
