<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Sale extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'issue_date', 'issued_portal', 'service_type', 'gds_pnr', 'airline_pnr', 'agent_fare', 'customer_fare', 'customer_payment', 'customer_due', 'segment', 'last_date_of_payment', 'airline', 'flight_type', 'trip', 'pax_name', 'tkt_number', 'passport_nid', 'flight_date', 'return_date', 'flight_status', 'top_balance', 'current_balance', 'agent_price', 'sell_price', 'profit', 'segment_fare', 'contact_no', 'customer_name', 'customer_phone', 'images', 'videos', 'documents', 'links', 'created_by', 'updated_by',
    ];

    // casts for dates, decimals and attachment arrays
    protected $casts = [
        'issue_date' => 'date',
        'last_date_of_payment' => 'date',
        'flight_date' => 'date',
        'return_date' => 'date',

        'agent_fare' => 'decimal:2',
        'customer_fare' => 'decimal:2',
        'customer_payment' => 'decimal:2',
        'customer_due' => 'decimal:2',
        'top_balance' => 'decimal:2',
        'current_balance' => 'decimal:2',
        'agent_price' => 'decimal:2',
        'sell_price' => 'decimal:2',
        'profit' => 'decimal:2',
        'segment_fare' => 'decimal:2',

        'images' => 'array',
        'videos' => 'array',
        'documents' => 'array',
        'links' => 'array',
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
