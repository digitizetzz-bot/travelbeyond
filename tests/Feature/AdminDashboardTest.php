<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'customer', 'guard_name' => 'web']);
});

test('guests are redirected to login when accessing admin dashboard', function () {
    $response = $this->get('/app/dashboard');

    $response->assertRedirect('/login');
});

test('non-admin customer cannot access admin dashboard', function () {
    $customer = User::factory()->create();
    $customer->assignRole('customer');

    $response = $this->actingAs($customer)->get('/app/dashboard');

    $response->assertForbidden();
});

test('admin can access admin dashboard successfully', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $response = $this->actingAs($admin)->get('/app/dashboard');

    $response->assertOk();
    $response->assertSee('Bookings');
    $response->assertSee('Booking Revenue');
    $response->assertSee('Travel & Beyond');
});

test('admin visiting customer dashboard is redirected to admin dashboard', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $response = $this->actingAs($admin)->get('/dashboard');

    $response->assertRedirect(route('admin.dashboard'));
});

test('customer visiting dashboard sees customer dashboard', function () {
    $customer = User::factory()->create();
    $customer->assignRole('customer');

    $response = $this->actingAs($customer)->get('/dashboard');

    $response->assertOk();
});

test('admin dashboard livewire component handles selection and modal state', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    Livewire\Livewire::actingAs($admin)
        ->test('pages::admin.dashboard')
        ->assertSet('activeBookingModal', null)
        ->call('clearSelection')
        ->assertSet('selected', [])
        ->call('toggleSelect', '#TB-192541')
        ->assertSet('selected', ['#TB-192541'])
        ->call('openBookingModal', '#TB-192541')
        ->assertSet('activeBookingModal', '#TB-192541')
        ->call('setModalTab', 'delivery')
        ->assertSet('activeModalTab', 'delivery')
        ->call('closeBookingModal')
        ->assertSet('activeBookingModal', null);
});
