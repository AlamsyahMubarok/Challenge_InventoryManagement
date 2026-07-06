<?php

beforeEach(function () {
    inventraRole('admin');
    inventraRole('staff');
    inventraRole('manager');
});

it('shows category detail with products in that category', function () {
    $staff = inventraUser('staff');

    $category = inventraCategory([
        'name' => 'Elektronik Test',
        'description' => 'Kategori elektronik untuk test.',
    ]);

    $otherCategory = inventraCategory([
        'name' => 'Kategori Lain',
        'description' => 'Kategori lain untuk test.',
    ]);

    $product = inventraProduct($category, [
        'name' => 'Laptop Test Kategori',
        'code' => 'TEST-CAT-001',
    ]);

    inventraProduct($otherCategory, [
        'name' => 'Barang Kategori Lain',
        'code' => 'TEST-CAT-002',
    ]);

    $this->actingAs($staff)
        ->get(route('categories.show', $category))
        ->assertOk()
        ->assertSee('Elektronik Test')
        ->assertSee('Laptop Test Kategori')
        ->assertSee('TEST-CAT-001')
        ->assertDontSee('Barang Kategori Lain')
        ->assertSee(route('products.show', $product), false);
});
