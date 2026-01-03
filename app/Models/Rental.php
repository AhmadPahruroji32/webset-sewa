<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'rental_code',
        'user_id',
        'equipment_id',
        'quantity',
        'start_date',
        'end_date',
        'duration_days',
        'total_price',
        'status',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'total_price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($rental) {
            $rental->rental_code = 'RNT-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
        });
    }
}
