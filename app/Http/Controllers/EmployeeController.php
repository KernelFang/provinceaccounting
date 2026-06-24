<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Designation;
use App\Http\Requests\EmployeeRequest;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $query = Employee::with(['department','designation']);

        // date range filtering (joining_date)
        $start = null;
        $end = null;
        $rangeInput = request('date_range');
        if ($rangeInput) {
            $r = trim($rangeInput);
            if (preg_match('/\d{4}-\d{2}-\d{2}\s*-\s*\d{4}-\d{2}-\d{2}/', $r) || preg_match('/\d{1,2}\/\d{1,2}\/\d{4}\s*-\s*\d{1,2}\/\d{1,2}\/\d{4}/', $r)) {
                $parts = preg_split('/\s*-\s*/', $r, 2);
                if (count($parts) === 2) {
                    try {
                        $a = \Carbon\Carbon::parse($parts[0]);
                        $b = \Carbon\Carbon::parse($parts[1]);
                        $start = $a->copy()->startOfDay();
                        $end = $b->copy()->endOfDay();
                    } catch (\Exception $e) {
                        $start = null; $end = null;
                    }
                }
            }
        } elseif ($joining = request('joining_date')) {
            try {
                $d = \Carbon\Carbon::parse($joining);
                $start = $d->copy()->startOfDay();
                $end = $d->copy()->endOfDay();
            } catch (\Exception $e) {
                $start = null; $end = null;
            }
        }

        if ($start && $end) {
            $query->whereBetween('joining_date', [$start->toDateString(), $end->toDateString()]);
        }

        if ($code = request('employee_code')) {
            $query->where('employee_code', 'like', "%{$code}%");
        }

        if ($name = request('name')) {
            $query->where('name', 'like', "%{$name}%");
        }

        if ($dept = request('department_id')) {
            $query->where('department_id', $dept);
        }

        if ($desig = request('designation_id')) {
            $query->where('designation_id', $desig);
        }

        // pagination size control
        $perPageInput = request('per_page');
        $defaultPerPage = 25;
        if ($perPageInput === 'all') {
            $employees = $query->latest()->get();
        } else {
            $perPage = is_numeric($perPageInput) ? (int) $perPageInput : $defaultPerPage;
            $allowed = [$defaultPerPage, 100, 500, 1000, 5000];
            if (! in_array($perPage, $allowed)) {
                $perPage = $defaultPerPage;
            }
            $employees = $query->latest()->paginate($perPage)->withQueryString();
        }

        $employeesTotal = method_exists($employees, 'total') ? $employees->total() : $employees->count();

        $departments = Department::orderBy('name')->get();
        $designations = Designation::orderBy('title')->get();

        return view('employees.index', compact('employees','departments','designations','start','end','employeesTotal'));
    }

    public function create()
    {
        $departments = Department::pluck('name','id');
        $designations = Designation::pluck('title','id');
        return view('employees.create', compact('departments','designations'));
    }

    public function store(EmployeeRequest $request)
    {
        Employee::create($request->validated() + $request->except(['employee_code','name','email','department_id','designation_id']));
        return redirect()->route('employees.index');
    }

    public function edit(Employee $employee)
    {
        $departments = Department::pluck('name','id');
        $designations = Designation::pluck('title','id');
        return view('employees.edit', compact('employee','departments','designations'));
    }

    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }

    public function update(EmployeeRequest $request, Employee $employee)
    {
        $employee->update($request->validated() + $request->except(['employee_code','name','email','department_id','designation_id']));
        return redirect()->route('employees.index');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index');
    }
}
