<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class FlatPricingHistory extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'flat_id',
        'price',
        'effective_date',
        'changed_by',
        'remarks',
    ];

    protected $casts = [
        'flat_id' => 'integer',
        'price' => 'decimal:2',
        'effective_date' => 'date',
        'changed_by' => 'integer',
    ];

    public function flat()
    {
        return $this->belongsTo(Flat::class);
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
