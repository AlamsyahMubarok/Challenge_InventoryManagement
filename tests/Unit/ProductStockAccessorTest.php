<?php

use App\Models\Product;

it('marks product as low stock when stock is below or equal minimum stock', function () {
    $product = new Product();

    $product->forceFill([
        'stock' => 4,
        'minimum_stock' => 5,
        'light_damage_stock' => 1,
        'heavy_damage_stock' => 2,
        'maintenance_stock' => 3,
    ]);

    expect($product->is_low_stock)->toBeTrue();
});

it('marks product as not low stock when stock is above minimum stock', function () {
    $product = new Product();

    $product->forceFill([
        'stock' => 10,
        'minimum_stock' => 5,
        'light_damage_stock' => 0,
        'heavy_damage_stock' => 0,
        'maintenance_stock' => 0,
    ]);

    expect($product->is_low_stock)->toBeFalse();
});

it('calculates total damaged and maintenance stock as unavailable stock', function () {
    $product = new Product();

    $product->forceFill([
        'stock' => 10,
        'minimum_stock' => 5,
        'light_damage_stock' => 1,
        'heavy_damage_stock' => 2,
        'maintenance_stock' => 3,
    ]);

    expect($product->unavailable_stock)->toBe(6);
});
