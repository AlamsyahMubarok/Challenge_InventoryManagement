<?php

it('redirects guest from dashboard to login', function () {
    $this->get(route('dashboard'))
        ->assertRedirect(route('login'));
});

it('allows admin staff and manager to access dashboard', function (string $roleName) {
    $user = inventraUser($roleName);

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk();
})->with([
    'admin',
    'staff',
    'manager',
]);

it('shows reports page for admin and manager', function (string $roleName) {
    $user = inventraUser($roleName);

    inventraProduct(attributes: [
        'name' => 'Barang Laporan Pest',
        'stock' => 2,
        'minimum_stock' => 5,
    ]);

    $this->actingAs($user)
        ->get(route('reports.index'))
        ->assertOk()
        ->assertSee('Barang Laporan Pest');
})->with([
    'admin',
    'manager',
]);

it('allows admin and manager to export csv report', function (string $roleName) {
    $user = inventraUser($roleName);

    inventraProduct(attributes: [
        'name' => 'Barang Export CSV Pest',
        'stock' => 3,
        'minimum_stock' => 5,
    ]);

    $this->actingAs($user)
        ->get(route('reports.export.csv'))
        ->assertOk();
})->with([
    'admin',
    'manager',
]);
