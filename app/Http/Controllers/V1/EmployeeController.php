<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $employees = Employee::query();

        $position = $request->get('position');

        if (!empty($position)) {
            $employees = $employees->whereHas('position', function (Builder $subQuery) use ($position) {
                return $subQuery->where('name', 'LIKE', "%$position%");
            });
        }

        $employees = $employees->get();

        if (!empty($request->get('include'))) {
            $employees = $employees->load(explode(',', $request->get('include')));
        }

        if (!empty($request->get('append'))) {
            $employees = $employees->append(explode(',', $request->get('append')));
        }

        return $this->respond(EmployeeResource::collection($employees));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EmployeeRequest $request
     * @return JsonResponse
     */
    public function store(EmployeeRequest $request): JsonResponse
    {
        $employee = Employee::create($request->all());

        return $this->respondCreated(new EmployeeResource($employee));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $employee = Employee::findOrFail($id);

        if (!empty($request->get('include'))) {
            $employee = $employee->load(explode(',', $request->get('include')));
        }

        if (!empty($request->get('append'))) {
            $employee = $employee->append(explode(',', $request->get('append')));
        }

        return $this->respond(new EmployeeResource($employee));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EmployeeRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(EmployeeRequest $request, int $id): JsonResponse
    {
        $employee = Employee::findOrFail($id);
        $employee->update($request->all());

        return $this->respondUpdated(new EmployeeResource($employee));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return $this->respondDeleted();
    }
}
