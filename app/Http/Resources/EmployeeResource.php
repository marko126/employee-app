<?php

namespace App\Http\Resources;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class EmployeeResource
 *
 * @mixin Employee
 *
 * @package App\Http\Resources
 */
class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'start_date' => $this->start_date?->format('Y-m-d'),
            'end_date' => $this->end_date?->format('Y-m-d'),
            'position' => $this->whenLoaded('position', function () {
                return new EmployeePositionResource($this->position);
            }),
            'superior' => $this->whenAppended('superior', function () {
                return $this->superior ? new EmployeeResource($this->superior) : null;
            }),
            'subordinates' => $this->whenAppended('subordinates', function () {
                return $this->subordinates ? EmployeeResource::collection($this->subordinates) : null;
            }),
        ];
    }
}
