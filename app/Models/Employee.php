<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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
 * @property-read Employee $superior
 * @property-read Collection|Employee[] $subordinates
 *
 * @mixin Builder
 *
 * @package App\Models
 */
class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'position_id',
        'start_date',
        'end_date',
    ];

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

    public function getSuperiorAttribute(): ?Employee
    {
        return $this->position->parent?->employee;
    }

    public function getSubordinatesAttribute(): Collection|array|\Illuminate\Support\Collection
    {
        return $this->position->children->map(function (EmployeePosition $position) {
            return $position->employee;
        });
    }
}
