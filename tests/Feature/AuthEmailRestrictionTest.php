<?php

use App\Models\User;

beforeEach(function () {
    inventraRole('admin');
    inventraRole('staff');
    inventraRole('manager');
});

it('rejects registration with non gmail email', function () {
    $response = $this->post('/register', [
        'name' => 'User Yahoo',
        'email' => 'user@yahoo.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertSessionHasErrors(['email']);

    expect(User::query()->where('email', 'user@yahoo.com')->exists())->toBeFalse();

    $this->assertGuest();
});

it('allows registration with gmail email and assigns staff role', function () {
    $response = $this->post('/register', [
        'name' => 'User Gmail',
        'email' => 'usergmailtest@gmail.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect('/dashboard');

    $this->assertAuthenticated();

    $user = User::query()->where('email', 'usergmailtest@gmail.com')->first();

    expect($user)->not->toBeNull();

    expect($user->role->name)->toBe('staff');
});

it('allows demo account login with example domain', function () {
    $admin = inventraUser('admin', [
        'name' => 'Admin Demo',
        'email' => 'admin@example.com',
        'password' => bcrypt('admin123'),
    ]);

    $response = $this->post('/login', [
        'email' => 'admin@example.com',
        'password' => 'admin123',
    ]);

    $response->assertRedirect('/dashboard');

    $this->assertAuthenticatedAs($admin);
});

it('rejects login for non gmail account that is not demo account', function () {
    inventraUser('staff', [
        'email' => 'dummy@yahoo.com',
        'password' => bcrypt('password123'),
    ]);

    $response = $this->post('/login', [
        'email' => 'dummy@yahoo.com',
        'password' => 'password123',
    ]);

    $response->assertSessionHasErrors(['email']);

    $this->assertGuest();
});
