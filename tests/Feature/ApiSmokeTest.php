<?php

use Laravel\Sanctum\Sanctum;

it('returns authenticated api user', function () {
    $user = inventraUser('staff', [
        'email' => 'apiuser@gmail.com',
    ]);

    Sanctum::actingAs($user);

    $this->getJson('/api/user')
        ->assertOk()
        ->assertJsonFragment([
            'email' => 'apiuser@gmail.com',
        ]);
});

it('allows authenticated user to view api categories', function () {
    $user = inventraUser('staff');

    inventraCategory([
        'name' => 'Kategori API Pest',
    ]);

    Sanctum::actingAs($user);

    $this->getJson('/api/categories')
        ->assertOk()
        ->assertSee('Kategori API Pest');
});

it('allows authenticated user to view api products', function () {
    $user = inventraUser('staff');

    inventraProduct(attributes: [
        'name' => 'Produk API Pest',
        'code' => 'API-PST-001',
    ]);

    Sanctum::actingAs($user);

    $this->getJson('/api/products')
        ->assertOk()
        ->assertSee('Produk API Pest')
        ->assertSee('API-PST-001');
});

it('allows authenticated user to view low stock products from api', function () {
    $user = inventraUser('staff');

    inventraProduct(attributes: [
        'name' => 'Produk Low Stock API Pest',
        'code' => 'API-LOW-001',
        'stock' => 2,
        'minimum_stock' => 5,
    ]);

    inventraProduct(attributes: [
        'name' => 'Produk Aman API Pest',
        'code' => 'API-OK-001',
        'stock' => 20,
        'minimum_stock' => 5,
    ]);

    Sanctum::actingAs($user);

    $this->getJson('/api/products?low_stock=1')
        ->assertOk()
        ->assertSee('Produk Low Stock API Pest');
});

it('allows admin to view api reports', function () {
    $admin = inventraUser('admin');

    inventraProduct(attributes: [
        'name' => 'Produk Report API Pest',
        'stock' => 4,
        'minimum_stock' => 5,
    ]);

    Sanctum::actingAs($admin);

    $this->getJson('/api/reports')
        ->assertOk()
        ->assertSee('Produk Report API Pest');
});
