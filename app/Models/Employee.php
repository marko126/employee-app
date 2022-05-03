<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Employee
 *
 * @property int    $id
 * @property int    $position_id
 * @property string $name
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property-read EmployeePosition $position
 *
 * @package App\Models
 */
class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = [
        'start_date',
        'end_date',
    ];

    /**
     * Employee has a position
     */
    public function position(): BelongsTo
    {
        return $this->belongsTo(EmployeePosition::class, 'position_id');
    }
}
