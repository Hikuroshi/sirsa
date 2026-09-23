<?php

use App\Enums\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('renders the login and register pages for guests', function () {
    $this->get(route('login'))->assertOk()->assertSee('Login');
    $this->get(route('register'))->assertOk()->assertSee('Register');
});

it('registers a reporter account', function () {
    $response = $this->post(route('register.store'), [
        'name' => 'Siti Aminah',
        'username' => 'sitiaminah',
        'email' => 'siti@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect(route('login'))->assertSessionHas('success');
    $this->assertDatabaseHas('users', [
        'username' => 'sitiaminah',
        'email' => 'siti@example.com',
        'role' => Role::Reporter->value,
    ]);
    $this->assertGuest();
});

it('rejects duplicate registration data and mismatched password confirmation', function () {
    User::factory()->create([
        'username' => 'existing',
        'email' => 'existing@example.com',
    ]);

    $response = $this->post(route('register.store'), [
        'name' => 'Pengguna Baru',
        'username' => 'existing',
        'email' => 'existing@example.com',
        'password' => 'password123',
        'password_confirmation' => 'berbeda123',
    ]);

    $response->assertSessionHasErrors(['username', 'email', 'password']);
    $this->assertDatabaseCount('users', 1);
});

it('logs in with an email or username', function (string $login) {
    $user = User::factory()->create([
        'username' => 'userlogin',
        'email' => 'user@example.com',
        'password' => 'password123',
    ]);

    $response = $this->post(route('authenticate'), [
        'login' => $login,
        'password' => 'password123',
        'remember' => true,
    ]);

    $response->assertRedirect(route('dashboard'));
    $this->assertAuthenticatedAs($user);
})->with([
    'email' => 'user@example.com',
    'username' => 'userlogin',
]);

it('rejects invalid login credentials', function () {
    User::factory()->create([
        'email' => 'user@example.com',
        'password' => 'password123',
    ]);

    $response = $this->post(route('authenticate'), [
        'login' => 'user@example.com',
        'password' => 'wrong-password',
    ]);

    $response->assertSessionHasErrors('login')->assertSessionHasInput('login', 'user@example.com');
    $this->assertGuest();
});

it('logs out an authenticated user', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('logout'));

    $response->assertRedirect(route('home'));
    $this->assertGuest();
});
