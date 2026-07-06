<?php

it('allows staff to create category', function () {
    $staff = inventraUser('staff');

    $response = $this->actingAs($staff)
        ->post(route('categories.store'), [
            'name' => 'Kategori Pest Test',
            'description' => 'Kategori dibuat dari automated test.',
        ]);

    $response->assertRedirect(route('categories.index'));

    $this->assertDatabaseHas('categories', [
        'name' => 'Kategori Pest Test',
        'description' => 'Kategori dibuat dari automated test.',
    ]);
});

it('allows staff to update category', function () {
    $staff = inventraUser('staff');

    $category = inventraCategory([
        'name' => 'Kategori Lama',
        'description' => 'Deskripsi lama.',
    ]);

    $response = $this->actingAs($staff)
        ->put(route('categories.update', $category), [
            'name' => 'Kategori Baru',
            'description' => 'Deskripsi baru.',
        ]);

    $response->assertRedirect(route('categories.index'));

    $this->assertDatabaseHas('categories', [
        'id' => $category->id,
        'name' => 'Kategori Baru',
        'description' => 'Deskripsi baru.',
    ]);
});

it('allows staff to delete category without products', function () {
    $staff = inventraUser('staff');

    $category = inventraCategory([
        'name' => 'Kategori Hapus',
    ]);

    $response = $this->actingAs($staff)
        ->delete(route('categories.destroy', $category));

    $response->assertRedirect(route('categories.index'));

    $this->assertDatabaseMissing('categories', [
        'id' => $category->id,
    ]);
});

it('prevents deleting category that still has products', function () {
    $staff = inventraUser('staff');

    $category = inventraCategory([
        'name' => 'Kategori Dengan Barang',
    ]);

    inventraProduct($category, [
        'name' => 'Barang Relasi Kategori',
    ]);

    $response = $this->actingAs($staff)
        ->delete(route('categories.destroy', $category));

    $response->assertRedirect(route('categories.index'));
    $response->assertSessionHas('error');

    $this->assertDatabaseHas('categories', [
        'id' => $category->id,
    ]);
});

it('can search categories by name', function () {
    $staff = inventraUser('staff');

    inventraCategory([
        'name' => 'Elektronik Pest',
        'description' => 'Kategori elektronik.',
    ]);

    inventraCategory([
        'name' => 'Furniture Pest',
        'description' => 'Kategori furniture.',
    ]);

    $this->actingAs($staff)
        ->get(route('categories.index', [
            'search' => 'Elektronik',
        ]))
        ->assertOk()
        ->assertSee('Elektronik Pest')
        ->assertDontSee('Furniture Pest');
});
