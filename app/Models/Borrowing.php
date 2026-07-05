<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Borrowing extends Model
{
    protected $fillable = [
        'user_id',
        'borrower_name',
        'borrow_date',
        'due_date',
        'return_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'borrow_date' => 'date',
        'due_date' => 'date',
        'return_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(BorrowingDetail::class);
    }

    public function isOverdue(): bool
    {
        if ($this->status !== 'borrowed') {
            return false;
        }

        if (! $this->due_date) {
            return false;
        }

        return Carbon::parse($this->due_date)->lt(today());
    }

    public function getStatusLabelAttribute(): string
    {
        if ($this->status === 'returned') {
            return 'Dikembalikan';
        }

        if ($this->isOverdue()) {
            return 'Terlambat';
        }

        return 'Dipinjam';
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status_label) {
            'Dikembalikan' => 'bg-green-50 text-green-600 border border-green-100',
            'Terlambat' => 'bg-red-50 text-red-600 border border-red-100',
            'Dipinjam' => 'bg-yellow-50 text-yellow-700 border border-yellow-100',
            default => 'bg-slate-100 text-slate-600 border border-slate-200',
        };
    }
}
