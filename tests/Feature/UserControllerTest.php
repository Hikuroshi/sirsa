<?php

use App\Enums\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

it('renders the user list for an authenticated user', function () {
    $authenticatedUser = User::factory()->create();
    User::factory()->create(['name' => 'Budi Santoso']);

    $response = $this->actingAs($authenticatedUser)->get(route('user.index'));

    $response->assertOk()->assertSee('Budi Santoso');
});

it('creates a user with username and role', function () {
    $authenticatedUser = User::factory()->create();

    $response = $this->actingAs($authenticatedUser)->post(route('user.store'), [
        'name' => 'Siti Aminah',
        'username' => 'sitiaminah',
        'email' => 'siti@example.com',
        'role' => Role::Admin->value,
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect(route('user.index'))->assertSessionHas('success');
    $this->assertDatabaseHas('users', [
        'username' => 'sitiaminah',
        'email' => 'siti@example.com',
        'role' => Role::Admin->value,
    ]);
});

it('rejects duplicate usernames and invalid roles', function () {
    $authenticatedUser = User::factory()->create(['username' => 'existing']);

    $response = $this->actingAs($authenticatedUser)->post(route('user.store'), [
        'name' => 'Pengguna Baru',
        'username' => 'existing',
        'email' => 'baru@example.com',
        'role' => 'invalid-role',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertSessionHasErrors(['username', 'role']);
    $this->assertDatabaseMissing('users', ['email' => 'baru@example.com']);
});

it('updates a user without changing the password when it is blank', function () {
    $authenticatedUser = User::factory()->create();
    $user = User::factory()->create();
    $originalPassword = $user->password;

    $response = $this->actingAs($authenticatedUser)->put(route('user.update', $user), [
        'name' => 'Nama Diperbarui',
        'username' => $user->username,
        'email' => $user->email,
        'role' => Role::Reporter->value,
        'password' => '',
        'password_confirmation' => '',
    ]);

    $response->assertRedirect(route('user.index'))->assertSessionHas('success');
    $user->refresh();
    expect($user->name)->toBe('Nama Diperbarui')
        ->and($user->role)->toBe(Role::Reporter)
        ->and($user->password)->toBe($originalPassword);
});

it('updates a user password when a new password is provided', function () {
    $authenticatedUser = User::factory()->create();
    $user = User::factory()->create();

    $response = $this->actingAs($authenticatedUser)->put(route('user.update', $user), [
        'name' => $user->name,
        'username' => $user->username,
        'email' => $user->email,
        'role' => $user->role->value,
        'password' => 'new-password',
        'password_confirmation' => 'new-password',
    ]);

    $response->assertRedirect(route('user.index'));
    expect(Hash::check('new-password', $user->fresh()->password))->toBeTrue();
});

it('deletes a user', function () {
    $authenticatedUser = User::factory()->create();
    $user = User::factory()->create();

    $response = $this->actingAs($authenticatedUser)->delete(route('user.destroy', $user));

    $response->assertRedirect(route('user.index'))->assertSessionHas('success');
    $this->assertModelMissing($user);
});
