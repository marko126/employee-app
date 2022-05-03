<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class EmployeePosition
 *
 * @property int    $id
 * @property int    $parent_id
 * @property string $name
 * @property-read EmployeePosition $parent
 * @property-read Collection|EmployeePosition[] $children
 *
 * @package App\Models
 */
class EmployeePosition extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'employees_positions';

    /**
     * Position can have parent position
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(EmployeePosition::class, 'parent_id');
    }

    /**
     * Position can have children positions
     */
    public function children(): HasMany
    {
        return $this->hasMany(EmployeePosition::class, 'parent_id');
    }
}
