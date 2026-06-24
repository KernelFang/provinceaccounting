<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PortalBalance extends Model
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $fillable = [
        'transaction_type', 'info', 'date', 'portal', 'recharge', 'sender', 'reference', 'remarks', 'created_by', 'updated_by',
    ];

    protected $casts = [
        'date' => 'date',
        'recharge' => 'decimal:2',
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
