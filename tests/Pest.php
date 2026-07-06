<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

uses(Tests\TestCase::class, RefreshDatabase::class)->in('Feature', 'Unit');

function inventraRole(string $name): Role
{
    $role = Role::query()->where('name', $name)->first();

    if ($role) {
        return $role;
    }

    return Role::forceCreate([
        'name' => $name,
    ]);
}

function inventraUser(string $roleName = 'admin', array $attributes = []): User
{
    $role = inventraRole($roleName);

    return User::forceCreate(array_merge([
        'name' => ucfirst($roleName).' Test',
        'email' => $roleName.'_'.Str::random(8).'@gmail.com',
        'email_verified_at' => now(),
        'password' => Hash::make('password123'),
        'role_id' => $role->id,
    ], $attributes));
}

function inventraCategory(array $attributes = []): Category
{
    return Category::forceCreate(array_merge([
        'name' => 'Kategori Test '.Str::upper(Str::random(5)),
        'description' => 'Kategori untuk kebutuhan pengujian.',
    ], $attributes));
}

function inventraProduct(?Category $category = null, array $attributes = []): Product
{
    $category ??= inventraCategory();

    return Product::forceCreate(array_merge([
        'category_id' => $category->id,
        'code' => 'TEST-'.Str::upper(Str::random(8)),
        'name' => 'Barang Test '.Str::upper(Str::random(5)),
        'description' => 'Barang untuk kebutuhan pengujian.',
        'stock' => 10,
        'minimum_stock' => 3,
        'light_damage_stock' => 0,
        'heavy_damage_stock' => 0,
        'maintenance_stock' => 0,
        'location' => 'Ruang Test',
        'condition' => 'Baik',
        'image' => null,
    ], $attributes));
}
