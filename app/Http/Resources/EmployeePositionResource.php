<?php

namespace App\Http\Resources;

use App\Models\EmployeePosition;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class EmployeePositionResource
 *
 * @mixin EmployeePosition
 *
 * @package App\Http\Resources
 */
class EmployeePositionResource extends JsonResource
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
            'parent' => $this->whenLoaded('parent', function () {
                return new EmployeeResource($this->parent);
            }),
            'children' => $this->whenLoaded('children', function () {
                return EmployeeResource::collection($this->children);
            }),
        ];
    }
}
