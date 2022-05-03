<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\EmployeePosition;
use Carbon\Carbon;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    public const URI = '/api/v1/employees';

    public function test_get_employees(): void
    {
        $response = $this->get(self::URI);

        $response->assertStatus(200);
        $response->assertJsonCount(Employee::count());
    }

    public function test_get_employee(): void
    {
        /** @var Employee $employee */
        $employee = Employee::factory()->create();

        $response = $this->get(self::URI . '/' . $employee->id);

        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) => $json->hasAll(['id', 'name', 'start_date', 'end_date']));
        $response->assertJsonFragment([
            'id' => $employee->id,
            'name' => $employee->name,
            'start_date' => $employee->start_date->format('Y-m-d'),
            'end_date' => null,
        ]);
    }

    public function test_get_employee_with_relations()
    {
        /** @var Employee $employee */
        $employee = Employee::factory()->create();

        $response = $this->get(self::URI . '/' . $employee->id . '?include=position,position.children,position.parent');

        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) => $json->hasAll([
            'id',
            'name',
            'start_date',
            'end_date',
            'position'
        ]));
        $response->assertJsonStructure([
            'position' => [
                'id',
                'name',
                'children',
                'parent',
            ]
        ]);
        $response->assertJsonPath('position.id', $employee->position->id);
    }

    public function test_get_employee_with_appended_attributes()
    {
        $parentPosition = EmployeePosition::create([
            'name' => 'Test parent position',
            'parent_id' => 1002,
        ]);
        $childPosition = EmployeePosition::create([
            'name' => 'Test child position',
            'parent_id' => $parentPosition->id,
        ]);
        /** @var Employee $employee */
        $employee = Employee::factory()->create(['position_id' => $parentPosition->id]);
        /** @var Employee $subordinate */
        $subordinate = Employee::factory()->create(['position_id' => $childPosition->id]);

        $response = $this->get(self::URI . '/' . $employee->id . '?append=superior,subordinates');
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) => $json->hasAll([
            'id',
            'name',
            'start_date',
            'end_date',
            'superior',
            'subordinates',
        ]));
        $response->assertJsonStructure([
            'superior' => [
                'id',
                'name',
                'start_date',
                'end_date',
            ],
            'subordinates' => [
                [
                    'id',
                    'name',
                    'start_date',
                    'end_date',
                ],
            ],
        ]);
        $response->assertJsonPath('superior.id', $employee->superior->id);
        $response->assertJsonPath('subordinates.0.id', $subordinate->id);
    }

    public function test_get_employee_not_found(): void
    {
        $response = $this->get(self::URI . '/10000000');

        $response->assertStatus(404);
    }

    public function test_create_employee(): void
    {
        $position = EmployeePosition::create([
            'name' => 'Test position',
            'parent_id' => 1002,
        ]);

        $data = [
            'name' => 'Brad Pit',
            'position_id' => $position->id,
            'start_date' => Carbon::now()->format('Y-m-d'),
        ];

        $response = $this->post(self::URI, $data);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'message',
            'data' => [
                'id',
                'name',
                'start_date',
                'end_date',
            ]
        ]);
    }

    public function test_create_employee_with_errors(): void
    {
        $data = [
            'name' => '',
            'position_id' => '1000000',
            'start_date' => '1321654',
        ];

        $response = $this->post(self::URI, $data);

        $response->assertStatus(302);
    }

    public function test_update_employee(): void
    {
        $employee = $this->createCustomEmployee();

        $data = [
            'name' => $employee->name,
            'position_id' => $employee->position->id,
            'start_date' => $employee->start_date->addDay()->format('Y-m-d'),
        ];

        $response = $this->put(self::URI . '/' . $employee->id, $data);

        $response->assertStatus(200);
    }

    public function test_delete_employee(): void
    {
        $employee = $this->createCustomEmployee();

        $response = $this->delete(self::URI . '/' . $employee->id);

        $response->assertStatus(200);
    }

    /**
     * @return Employee
     */
    private function createCustomEmployee(): Employee
    {
        $position = EmployeePosition::create([
            'name' => 'Test position',
            'parent_id' => 1002,
        ]);

        return Employee::factory()->create(['position_id' => $position->id]);
    }
}
