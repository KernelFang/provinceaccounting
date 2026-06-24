<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PettyCash extends Model
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $fillable = [
        'title',
        'transaction_type',
        'amount',
        'current_balance',
        'expense_id',
        'description',
        'date',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'current_balance' => 'decimal:2',
        'date' => 'date',
        'expense_id' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
    ];

    public function expense()
    {
        return $this->belongsTo(Expense::class);
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

    /**
     * Total amount added to petty cash (sum of credit_manual entries)
     */
    public static function totalAdded(): float
    {
        return (float) self::where('transaction_type', 'credit_manual')->sum('amount');
    }

    /**
     * Total amount used from petty cash (sum of debit_expense entries)
     */
    public static function totalUsed(): float
    {
        return (float) self::where('transaction_type', 'debit_expense')->sum('amount');
    }

    /**
     * Current petty cash balance: added - used
     */
    public static function balance(): float
    {
        return round(self::totalAdded() - self::totalUsed(), 2);
    }
}
