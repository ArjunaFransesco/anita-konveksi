<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int    $id
 * @property string $name
 * @property string $position
 * @property string $employee_type
 * @property float  $salary_rate
 * @property string $phone
 * @property string $address
 * @property \Illuminate\Support\Carbon $join_date
 * @property bool   $is_active
 */
class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'position', 'employee_type', 'salary_rate',
        'phone', 'address', 'join_date', 'is_active'
    ];

    protected $casts = [
        'salary_rate' => 'decimal:2',
        'join_date'   => 'date',
        'is_active'   => 'boolean',
    ];
}