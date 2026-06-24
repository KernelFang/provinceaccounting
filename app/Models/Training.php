<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Training extends Model
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $fillable = [
        'training_type','title','customer_name','customer_number','package','description','agent_cost','customer_price','customer_payment','customer_due','purchase_date','created_by','updated_by'
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'agent_cost' => 'decimal:2',
        'customer_price' => 'decimal:2',
        'customer_payment' => 'decimal:2',
        'customer_due' => 'decimal:2',
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
