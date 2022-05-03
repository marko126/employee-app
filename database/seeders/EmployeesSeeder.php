<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->data() as $data) {
            Employee::create($data);
        }
    }

    public function data(): array
    {
        return [
            [
                'id' => 100,
                'name' => 'John Smith',
                'position_id' => 1000,
                'start_date' => '2018-01-05',
            ],
            [
                'id' => 101,
                'name' => 'Brad Miller',
                'position_id' => 1001,
                'start_date' => '2019-06-17',
            ],
            [
                'id' => 102,
                'name' => 'Sheryl Cunningham',
                'position_id' => 1002,
                'start_date' => '2020-10-01',
            ],
            [
                'id' => 103,
                'name' => 'Irving Romero',
                'position_id' => 1003,
                'start_date' => '2021-01-04',
            ],
            [
                'id' => 104,
                'name' => 'Olive Payne',
                'position_id' => 1004,
                'start_date' => '2021-01-04',
            ],
            [
                'id' => 105,
                'name' => 'Jean Watts',
                'position_id' => 1005,
                'start_date' => '2021-04-01',
            ],
            [
                'id' => 106,
                'name' => 'Gregory Hampton',
                'position_id' => 1006,
                'start_date' => '2021-05-01',
            ],
            [
                'id' => 107,
                'name' => 'Willis Castro',
                'position_id' => 1008,
                'start_date' => '2019-05-25',
            ],
        ];
    }
}
