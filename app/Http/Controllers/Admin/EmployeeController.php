<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        return view('admin.employees.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'position'      => 'nullable|string|max:255',
            'employee_type' => 'required|in:harian,borongan,mingguan',
            'salary_rate'   => 'nullable|numeric|min:0',
            'phone'         => 'nullable|string|max:20',
            'address'       => 'nullable|string',
            'join_date'     => 'nullable|date',
            'is_active'     => 'boolean',
        ]);

        Employee::create($validated);
        return redirect()->route('admin.employees.index')->with('success', 'Pegawai berhasil ditambahkan');
    }

    public function edit(Employee $employee)
    {
        return view('admin.employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'position'      => 'nullable|string|max:255',
            'employee_type' => 'required|in:harian,borongan,mingguan',
            'salary_rate'   => 'nullable|numeric|min:0',
            'phone'         => 'nullable|string|max:20',
            'address'       => 'nullable|string',
            'join_date'     => 'nullable|date',
            'is_active'     => 'boolean',
        ]);

        $employee->update($validated);
        return redirect()->route('admin.employees.index')->with('success', 'Pegawai berhasil diupdate');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('admin.employees.index')->with('success', 'Pegawai berhasil dihapus');
    }
}