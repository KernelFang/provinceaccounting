<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $fillable = [
        'employee_code',
        'name',
        'gender',
        'father_name',
        'mother_name',
        'spouse_name',
        'email',
        'phone',
        'nid',
        'dob',
        'address',
        'permanent_address',
        'joining_date',
        'exit_date',
        'status',
        'employment_type',
        'assigned_assets',
        'remarks',
        'department_id',
        'designation_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'dob' => 'date',
        'joining_date' => 'date',
        'exit_date' => 'date',
        'department_id' => 'integer',
        'designation_id' => 'integer',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
