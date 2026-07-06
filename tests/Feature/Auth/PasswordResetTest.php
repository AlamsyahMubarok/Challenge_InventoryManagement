<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

test('reset password link screen can be rendered', function () {
    $response = $this->get('/forgot-password');

    $response->assertStatus(200);
});

test('reset password link can be requested', function () {
    $user = inventraUser('staff', [
        'email' => 'passwordresetuser@gmail.com',
    ]);

    $response = $this->post('/forgot-password', [
        'email' => $user->email,
    ]);

    $response->assertSessionHasNoErrors();
    $response->assertSessionHas('status');

    $this->assertDatabaseHas('password_reset_tokens', [
        'email' => $user->email,
    ]);
});

test('reset password screen can be rendered', function () {
    $user = inventraUser('staff', [
        'email' => 'passwordresetscreen@gmail.com',
    ]);

    $token = Password::broker()->createToken($user);

    $response = $this->get(route('password.reset', [
        'token' => $token,
        'email' => $user->email,
    ]));

    $response->assertStatus(200);
});

test('password can be reset with valid token', function () {
    $user = inventraUser('staff', [
        'email' => 'passwordresetvalid@gmail.com',
        'password' => bcrypt('old-password'),
    ]);

    $token = Password::broker()->createToken($user);

    $response = $this->post(route('password.store'), [
        'token' => $token,
        'email' => $user->email,
        'password' => 'new-password',
        'password_confirmation' => 'new-password',
    ]);

    $response->assertSessionHasNoErrors();
    $response->assertRedirect(route('login'));

    expect(Hash::check('new-password', $user->refresh()->password))->toBeTrue();
});
