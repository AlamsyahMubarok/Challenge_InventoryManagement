<?php

beforeEach(function () {
    inventraRole('admin');
    inventraRole('staff');
    inventraRole('manager');
});

it('allows admin to access categories', function () {
    $admin = inventraUser('admin');

    $this->actingAs($admin)
        ->get(route('categories.index'))
        ->assertOk();
});

it('allows staff to access categories', function () {
    $staff = inventraUser('staff');

    $this->actingAs($staff)
        ->get(route('categories.index'))
        ->assertOk();
});

it('denies manager from accessing categories', function () {
    $manager = inventraUser('manager');

    $this->actingAs($manager)
        ->get(route('categories.index'))
        ->assertForbidden();
});

it('allows admin to access products', function () {
    $admin = inventraUser('admin');

    $this->actingAs($admin)
        ->get(route('products.index'))
        ->assertOk();
});

it('allows staff to access products', function () {
    $staff = inventraUser('staff');

    $this->actingAs($staff)
        ->get(route('products.index'))
        ->assertOk();
});

it('denies manager from accessing products', function () {
    $manager = inventraUser('manager');

    $this->actingAs($manager)
        ->get(route('products.index'))
        ->assertForbidden();
});

it('allows admin to access reports', function () {
    $admin = inventraUser('admin');

    $this->actingAs($admin)
        ->get(route('reports.index'))
        ->assertOk();
});

it('allows manager to access reports', function () {
    $manager = inventraUser('manager');

    $this->actingAs($manager)
        ->get(route('reports.index'))
        ->assertOk();
});

it('denies staff from accessing reports', function () {
    $staff = inventraUser('staff');

    $this->actingAs($staff)
        ->get(route('reports.index'))
        ->assertForbidden();
});
