<?php

use App\Models\Destination;
use App\Models\User;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'customer', 'guard_name' => 'web']);
});

test('guests are redirected from admin destinations to login', function () {
    $response = $this->get('/app/destinations');

    $response->assertRedirect('/login');
});

test('non-admin customer cannot access admin destinations', function () {
    $customer = User::factory()->create();
    $customer->assignRole('customer');

    $response = $this->actingAs($customer)->get('/app/destinations');

    $response->assertForbidden();
});

test('admin can view destinations list page', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    Destination::factory()->create([
        'name' => 'Tarangire National Park',
        'slug' => 'tarangire-national-park',
        'region' => 'Northern Safari Circuit',
        'category' => 'National Park',
        'is_active' => true,
    ]);

    $response = $this->actingAs($admin)->get('/app/destinations');

    $response->assertOk();
    $response->assertSee('Tarangire National Park');
    $response->assertSee('Destinations');
});

test('admin can access standalone create page', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $response = $this->actingAs($admin)->get('/app/destinations/create');

    $response->assertOk();
    $response->assertSee('Add Destination');
    $response->assertSee('Photo Gallery');
});

test('admin can create destination with gallery via standalone create page', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    Livewire\Livewire::actingAs($admin)
        ->test('pages::admin.destinations.create')
        ->set('name', 'Ruaha National Park')
        ->set('slug', 'ruaha-national-park')
        ->set('region', 'Southern Circuit')
        ->set('category', 'National Park')
        ->set('description', 'Rugged, semi-arid bush country with massive pride of lions.')
        ->set('highlights', 'Predators, Great Ruaha River, wild dogs, baobab groves')
        ->set('newGalleryUrl', 'https://images.unsplash.com/photo-1516426122078-c23e76319801')
        ->call('addGalleryUrl')
        ->set('is_featured', true)
        ->set('is_active', true)
        ->set('sort_order', 15)
        ->call('save')
        ->assertRedirect(route('admin.destinations'));

    $destination = Destination::where('slug', 'ruaha-national-park')->first();
    expect($destination)->not->toBeNull()
        ->and($destination->name)->toBe('Ruaha National Park')
        ->and($destination->gallery)->toContain('https://images.unsplash.com/photo-1516426122078-c23e76319801')
        ->and($destination->is_featured)->toBeTrue();
});

test('admin can access standalone edit page and update destination gallery', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $destination = Destination::factory()->create([
        'name' => 'Ngorongoro Crater',
        'slug' => 'ngorongoro-crater',
        'gallery' => ['https://images.unsplash.com/photo-1547471080-7cc2caa01a7e'],
    ]);

    $response = $this->actingAs($admin)->get("/app/destinations/{$destination->id}/edit");
    $response->assertOk();
    $response->assertSee('Edit Destination');

    Livewire\Livewire::actingAs($admin)
        ->test('pages::admin.destinations.edit', ['destination' => $destination])
        ->assertSet('name', 'Ngorongoro Crater')
        ->set('newGalleryUrl', 'https://images.unsplash.com/photo-1534567153574-2b12153a87f0')
        ->call('addGalleryUrl')
        ->call('save')
        ->assertRedirect(route('admin.destinations'));

    $fresh = $destination->fresh();
    expect($fresh->gallery)->toHaveCount(2)
        ->and($fresh->gallery)->toContain('https://images.unsplash.com/photo-1534567153574-2b12153a87f0');
});

test('admin can toggle and delete destination from index page', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $destination = Destination::factory()->create([
        'name' => 'Arusha National Park',
        'slug' => 'arusha-national-park',
        'is_active' => true,
        'is_featured' => false,
    ]);

    Livewire\Livewire::actingAs($admin)
        ->test('pages::admin.destinations.index')
        ->call('toggleActive', $destination->id);

    expect($destination->fresh()->is_active)->toBeFalse();

    Livewire\Livewire::actingAs($admin)
        ->test('pages::admin.destinations.index')
        ->call('toggleFeatured', $destination->id);

    expect($destination->fresh()->is_featured)->toBeTrue();

    Livewire\Livewire::actingAs($admin)
        ->test('pages::admin.destinations.index')
        ->call('confirmDelete', $destination->id)
        ->assertSet('showDeleteModal', true)
        ->call('deleteDestination')
        ->assertSet('showDeleteModal', false);

    expect(Destination::find($destination->id))->toBeNull();
});
