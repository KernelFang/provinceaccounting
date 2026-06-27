<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class Expense extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'title',
        'project_id',
        'expense_type_id',
        'flat_id',
        'payment_method_id',
        'date',
        'expense_details',
        'amount',
        'transaction_reference',
        'payment_status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'title' => 'string',
        'project_id' => 'integer',
        'expense_type_id' => 'integer',
        'flat_id' => 'integer',
        'payment_method_id' => 'integer',
        'date' => 'date',
        'amount' => 'decimal:2',
        'payment_status' => 'string',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
    ];

    public function audits()
    {
        return $this->morphMany(Audit::class, 'auditable');
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

    public function user()
    {
        return $this->createdBy();
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function expenseType()
    {
        return $this->belongsTo(ExpenseType::class);
    }

    public function expenseCategory()
    {
        return $this->expenseType();
    }

    public function flat()
    {
        return $this->belongsTo(Flat::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function pettyCashEntry()
    {
        return $this->hasOne(PettyCash::class);
    }

    protected static function booted()
    {
        static::creating(function ($expense) {
            if (auth()->check()) {
                $expense->created_by = auth()->id();
            }
        });

        static::updating(function ($expense) {
            if (auth()->check()) {
                $expense->updated_by = auth()->id();
            }
        });

        static::deleting(function ($expense) {
            if (auth()->check()) {
                $expense->deleted_by = auth()->id();
            }

            static::removePettyCashEntry($expense);
        });

        static::saved(function ($expense) {
            static::syncPettyCashEntry($expense);
        });

        static::restored(function ($expense) {
            static::syncPettyCashEntry($expense);
        });

        // This is not longer needed since we are now auditing all models globally in AppServiceProvider, but I'm leaving it here commented out for reference
        // static::created(function ($expense) {
        //     Audit::createAudit('create', $expense, null, $expense->getAttributes());
        // });

        // static::updated(function ($expense) {
        //     Audit::createAudit('update', $expense, $expense->getOriginal(), $expense->getAttributes());
        // });

        // static::deleted(function ($expense) {
        //     Audit::createAudit('delete', $expense, $expense->getOriginal(), null);
        // });
    }

    protected static function syncPettyCashEntry(self $expense): void
    {
        static::removePettyCashEntry($expense);

        if ($expense->payment_status !== 'petty_cash') {
            return;
        }

        PettyCash::create([
            'title' => 'Expense '.($expense->transaction_reference ?: $expense->id),
            'transaction_type' => 'debit_expense',
            'amount' => $expense->amount,
            'current_balance' => round(PettyCash::balance() - (float) $expense->amount, 2),
            'expense_id' => $expense->getKey(),
            'description' => $expense->expense_details,
            'date' => $expense->date?->toDateString() ?? now()->toDateString(),
            'created_by' => Auth::id() ?? $expense->created_by,
            'updated_by' => Auth::id() ?? $expense->updated_by,
        ]);
    }

    protected static function removePettyCashEntry(self $expense): void
    {
        PettyCash::query()
            ->where('expense_id', $expense->getKey())
            ->where('transaction_type', 'debit_expense')
            ->delete();
    }
}
