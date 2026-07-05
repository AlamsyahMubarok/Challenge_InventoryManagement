<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'code',
        'name',
        'description',
        'stock',
        'minimum_stock',
        'light_damage_stock',
        'heavy_damage_stock',
        'maintenance_stock',
        'location',
        'condition',
        'image',
    ];

    protected $casts = [
        'stock' => 'integer',
        'minimum_stock' => 'integer',
        'light_damage_stock' => 'integer',
        'heavy_damage_stock' => 'integer',
        'maintenance_stock' => 'integer',
    ];

    protected $appends = [
        'image_url',
        'total_physical_stock',
        'unavailable_stock',
        'is_low_stock',
        'stock_alert_label',
        'stock_alert_badge_class',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function borrowingDetails(): HasMany
    {
        return $this->hasMany(BorrowingDetail::class);
    }

    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }

        $baseUrl = trim((string) config('filesystems.disks.supabase.public_url'));

        if ($baseUrl === '') {
            return null;
        }

        $baseUrl = rtrim($baseUrl, '/');
        $path = ltrim($this->image, '/');

        return "{$baseUrl}/{$path}";
    }

    public function getBorrowedQuantityAttribute(): int
    {
        if (array_key_exists('borrowed_quantity', $this->attributes)) {
            return (int) $this->attributes['borrowed_quantity'];
        }

        return (int) $this->borrowingDetails()
            ->whereHas('borrowing', function ($query) {
                $query->where('status', 'borrowed');
            })
            ->sum('quantity');
    }

    public function getUnavailableStockAttribute(): int
    {
        return (int) $this->light_damage_stock
            + (int) $this->heavy_damage_stock
            + (int) $this->maintenance_stock;
    }

    public function getTotalPhysicalStockAttribute(): int
    {
        return (int) $this->stock
            + (int) $this->borrowed_quantity
            + (int) $this->light_damage_stock
            + (int) $this->heavy_damage_stock
            + (int) $this->maintenance_stock;
    }

    public function getIsLowStockAttribute(): bool
    {
        return (int) $this->stock <= (int) $this->minimum_stock;
    }

    public function getStockAlertLabelAttribute(): string
    {
        $stock = (int) $this->stock;
        $minimumStock = (int) $this->minimum_stock;

        if ($stock <= 0) {
            return 'Stok Habis';
        }

        if ($stock <= $minimumStock) {
            return 'Stok Menipis';
        }

        return 'Stok Aman';
    }

    public function getStockAlertBadgeClassAttribute(): string
    {
        return match ($this->stock_alert_label) {
            'Stok Habis' => 'bg-red-50 text-red-600 border border-red-100',
            'Stok Menipis' => 'bg-yellow-50 text-yellow-700 border border-yellow-100',
            default => 'bg-green-50 text-green-600 border border-green-100',
        };
    }

    public function getInventoryStatusAttribute(): string
    {
        $stock = (int) $this->stock;
        $borrowedQuantity = (int) $this->borrowed_quantity;

        if ($borrowedQuantity > 0 && $stock > 0) {
            return 'Sebagian Dipinjam';
        }

        if ($borrowedQuantity > 0 && $stock <= 0) {
            return 'Dipinjam Semua';
        }

        if ($stock > 0) {
            return 'Tersedia';
        }

        return 'Habis';
    }

    public function getInventoryStatusBadgeClassAttribute(): string
    {
        return match ($this->inventory_status) {
            'Tersedia' => 'bg-green-50 text-green-600 border border-green-100',
            'Sebagian Dipinjam' => 'bg-yellow-50 text-yellow-700 border border-yellow-100',
            'Dipinjam Semua' => 'bg-orange-50 text-orange-600 border border-orange-100',
            'Habis' => 'bg-red-50 text-red-600 border border-red-100',
            default => 'bg-slate-100 text-slate-600 border border-slate-200',
        };
    }
}
