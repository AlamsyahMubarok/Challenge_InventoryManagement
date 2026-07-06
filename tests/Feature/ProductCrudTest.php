<?php

it('allows staff to view product detail', function () {
    $staff = inventraUser('staff');

    $category = inventraCategory([
        'name' => 'Kategori Produk Detail',
    ]);

    $product = inventraProduct($category, [
        'name' => 'Laptop Detail Pest',
        'code' => 'PST-PRD-001',
    ]);

    $this->actingAs($staff)
        ->get(route('products.show', $product))
        ->assertOk()
        ->assertSee('Laptop Detail Pest')
        ->assertSee('PST-PRD-001');
});

it('allows staff to create product without image', function () {
    $staff = inventraUser('staff');

    $category = inventraCategory([
        'name' => 'Kategori Produk Create',
    ]);

    $response = $this->actingAs($staff)
        ->post(route('products.store'), [
            'category_id' => $category->id,
            'code' => 'PST-PRD-002',
            'name' => 'Mouse Wireless Pest',
            'description' => 'Barang dibuat dari automated test.',
            'stock' => 15,
            'minimum_stock' => 5,
            'light_damage_stock' => 0,
            'heavy_damage_stock' => 0,
            'maintenance_stock' => 0,
            'location' => 'Gudang Test',
            'condition' => 'Baik',
        ]);

    $response->assertRedirect(route('products.index'));

    $this->assertDatabaseHas('products', [
        'category_id' => $category->id,
        'code' => 'PST-PRD-002',
        'name' => 'Mouse Wireless Pest',
        'stock' => 15,
        'minimum_stock' => 5,
        'location' => 'Gudang Test',
        'condition' => 'Baik',
    ]);
});

it('allows staff to update product', function () {
    $staff = inventraUser('staff');

    $category = inventraCategory([
        'name' => 'Kategori Produk Update',
    ]);

    $product = inventraProduct($category, [
        'code' => 'PST-PRD-003',
        'name' => 'Keyboard Lama Pest',
        'stock' => 8,
    ]);

    $response = $this->actingAs($staff)
        ->put(route('products.update', $product), [
            'category_id' => $category->id,
            'code' => 'PST-PRD-003-NEW',
            'name' => 'Keyboard Baru Pest',
            'description' => 'Deskripsi produk sudah diperbarui.',
            'stock' => 20,
            'minimum_stock' => 4,
            'light_damage_stock' => 1,
            'heavy_damage_stock' => 0,
            'maintenance_stock' => 0,
            'location' => 'Gudang Update',
            'condition' => 'Baik',
        ]);

    $response->assertRedirect(route('products.index'));

    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'code' => 'PST-PRD-003-NEW',
        'name' => 'Keyboard Baru Pest',
        'stock' => 20,
        'minimum_stock' => 4,
        'light_damage_stock' => 1,
        'location' => 'Gudang Update',
    ]);
});

it('allows staff to delete product', function () {
    $staff = inventraUser('staff');

    $product = inventraProduct(attributes: [
        'code' => 'PST-PRD-004',
        'name' => 'Produk Hapus Pest',
    ]);

    $response = $this->actingAs($staff)
        ->delete(route('products.destroy', $product));

    $response->assertRedirect(route('products.index'));

    $this->assertDatabaseMissing('products', [
        'id' => $product->id,
    ]);
});

it('can search products by name', function () {
    $staff = inventraUser('staff');

    inventraProduct(attributes: [
        'name' => 'Monitor Search Pest',
        'code' => 'PST-SEARCH-001',
    ]);

    inventraProduct(attributes: [
        'name' => 'Printer Search Pest',
        'code' => 'PST-SEARCH-002',
    ]);

    $this->actingAs($staff)
        ->get(route('products.index', [
            'search' => 'Monitor',
        ]))
        ->assertOk()
        ->assertSee('Monitor Search Pest')
        ->assertDontSee('Printer Search Pest');
});
