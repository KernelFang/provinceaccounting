<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Audit extends Model
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $fillable = [
        'auditable_id',
        'auditable_type',
        'action',
        'old_values',
        'new_values',
        'user_id',
        'ip_address',
    ];

    protected $casts = [
        'old_values' => 'encrypted:array',
        'new_values' => 'encrypted:array',
        'ip_address' => 'encrypted',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * Log the audit action (CRUD, login, logout)
     */
    public static function createAudit($action, $auditable, $oldValues = null, $newValues = null)
    {
        self::create([
            'auditable_id' => $auditable->id,
            'auditable_type' => get_class($auditable),
            'action' => $action,
            'old_values' => $oldValues ? json_encode($oldValues) : null,
            'new_values' => $newValues ? json_encode($newValues) : null,
            'user_id' => auth()->check() ? auth()->id() : null,
            'ip_address' => request()->ip(),
        ]);
    }
}
