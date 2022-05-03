<?php

namespace Database\Seeders;

use App\Models\EmployeePosition;
use Illuminate\Database\Seeder;

class PositionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->data() as $data) {
            EmployeePosition::create($data);
        }
    }

    public function data(): array
    {
        return [
            [
                'id' => 1000,
                'name' => 'Chief Executive Officer',
                'parent_id' => null,
            ],
            [
                'id' => 1001,
                'name' => 'Chief Technology Officer',
                'parent_id' => 1000,
            ],
            [
                'id' => 1002,
                'name' => 'Team Lead',
                'parent_id' => 1001,
            ],
            [
                'id' => 1003,
                'name' => 'Senior Backend Developer',
                'parent_id' => 1002,
            ],
            [
                'id' => 1004,
                'name' => 'Senior Frontend Developer',
                'parent_id' => 1002,
            ],
            [
                'id' => 1005,
                'name' => 'Junior Backend Developer',
                'parent_id' => 1002,
            ],
            [
                'id' => 1006,
                'name' => 'Junior Frontend Developer',
                'parent_id' => 1002,
            ],
            [
                'id' => 1007,
                'name' => 'Quality Assurance Engineer',
                'parent_id' => 1002,
            ],
            [
                'id' => 1008,
                'name' => 'Financial Manager',
                'parent_id' => 1000,
            ],
            [
                'id' => 1009,
                'name' => 'Accountant',
                'parent_id' => 1008,
            ],
        ];
    }
}
