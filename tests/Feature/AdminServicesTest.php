<?php

use App\Models\Service;
use App\Models\User;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'customer', 'guard_name' => 'web']);
});

test('guests are redirected from admin services page to login', function () {
    $response = $this->get('/app/services');

    $response->assertRedirect('/login');
});

test('non-admin customer cannot access admin services page', function () {
    $customer = User::factory()->create();
    $customer->assignRole('customer');

    $response = $this->actingAs($customer)->get('/app/services');

    $response->assertForbidden();
});

test('admin can view services list page', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    Service::factory()->create([
        'title' => 'VIP Flight Ticketing',
        'slug' => 'vip-flight-ticketing',
        'subtitle' => 'Domestic and international',
        'is_active' => true,
    ]);

    $response = $this->actingAs($admin)->get('/app/services');

    $response->assertOk();
    $response->assertSee('VIP Flight Ticketing');
    $response->assertSee('Services');
});

test('admin can create, toggle, and delete a service via livewire', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    Livewire\Livewire::actingAs($admin)
        ->test('pages::admin.services')
        ->call('openCreateModal')
        ->assertSet('showFormModal', true)
        ->set('title', 'Zanzibar Private Boat Tour')
        ->set('slug', 'zanzibar-private-boat-tour')
        ->set('subtitle', 'Luxury private catamaran cruise')
        ->set('description', 'Full day excursion to Mnemba Atoll with seafood lunch.')
        ->set('sort_order', 10)
        ->set('is_active', true)
        ->call('save')
        ->assertSet('showFormModal', false);

    $service = Service::where('slug', 'zanzibar-private-boat-tour')->first();
    expect($service)->not->toBeNull()
        ->and($service->title)->toBe('Zanzibar Private Boat Tour')
        ->and($service->is_active)->toBeTrue();

    // Toggle active status
    Livewire\Livewire::actingAs($admin)
        ->test('pages::admin.services')
        ->call('toggleActive', $service->id);

    expect($service->fresh()->is_active)->toBeFalse();

    // Delete service
    Livewire\Livewire::actingAs($admin)
        ->test('pages::admin.services')
        ->call('confirmDelete', $service->id)
        ->assertSet('showDeleteModal', true)
        ->call('deleteService')
        ->assertSet('showDeleteModal', false);

    expect(Service::find($service->id))->toBeNull();
});
