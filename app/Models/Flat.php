<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Flat extends Model
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $fillable = [
        'project_id',
        'building_no',
        'floor_no',
        'flat_no',
        'total_flat_area_sqft',
        'cost_per_sqft',
        'base_price',
        'is_reselled',
        'client_owner_status',
        'current_owner_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'project_id' => 'integer',
        'total_flat_area_sqft' => 'decimal:2',
        'cost_per_sqft' => 'decimal:2',
        'base_price' => 'decimal:2',
        'is_reselled' => 'boolean',
        'current_owner_id' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function currentOwner()
    {
        return $this->belongsTo(Client::class, 'current_owner_id');
    }

    public function pricingHistories()
    {
        return $this->hasMany(FlatPricingHistory::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function incomes()
    {
        return $this->hasMany(Income::class);
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
