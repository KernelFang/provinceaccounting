<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Visa extends Model
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $fillable = [
        'purpose', 'country', 'description', 'from_date', 'to_date', 'purchase_date', 'customer', 'person', 'mobile_number', 'emergency_number', 'agent_cost', 'customer_price', 'customer_payment', 'customer_due', 'profit', 'status', 'created_by', 'updated_by',
    ];

    protected $casts = [
        'from_date' => 'date',
        'to_date' => 'date',
        'purchase_date' => 'date',
        'person' => 'integer',
        'agent_cost' => 'decimal:2',
        'customer_price' => 'decimal:2',
        'customer_payment' => 'decimal:2',
        'customer_due' => 'decimal:2',
        'profit' => 'decimal:2',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
