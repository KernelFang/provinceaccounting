<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Income extends Model
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $fillable = [
        'project_id',
        'flat_id',
        'client_id',
        'payment_method_id',
        'purpose',
        'price',
        'invoice_no',
        'clearing_status',
        'remarks',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'project_id' => 'integer',
        'flat_id' => 'integer',
        'client_id' => 'integer',
        'payment_method_id' => 'integer',
        'price' => 'decimal:2',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function flat()
    {
        return $this->belongsTo(Flat::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
