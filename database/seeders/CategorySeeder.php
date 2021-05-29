<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newCategories = [
            [
                'id' => '298db7d4-826d-46ee-ab4b-c7fa5edda7bc',
                'name' => 'Bags',
                'description' => 'Bags',
                'file_path' => null,
                'parent' => '',
                'is_published' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'created_by' => 'Pandhu Wibowo',
                'updated_by' => 'Pandhu Wibowo'
            ],
            [
                'id' => '51fce767-e3e5-4321-8694-30c79623b1bc',
                'name' => 'Clothes',
                'description' => 'Clothes',
                'file_path' => null,
                'parent' => '',
                'is_published' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'created_by' => 'Pandhu Wibowo',
                'updated_by' => 'Pandhu Wibowo'
            ],
            [
                'id' => '348c8cbe-b200-4135-bdcc-c1de0b4530fa',
                'name' => 'Furniture',
                'description' => 'Furniture',
                'file_path' => null,
                'parent' => '',
                'is_published' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'created_by' => 'Pandhu Wibowo',
                'updated_by' => 'Pandhu Wibowo'
            ],
            [
                'id' => '54ce287f-c357-491c-a933-67c87243616c',
                'name' => 'Jewelry',
                'description' => 'Jewelry',
                'file_path' => null,
                'parent' => '',
                'is_published' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'created_by' => 'Pandhu Wibowo',
                'updated_by' => 'Pandhu Wibowo'
            ]
        ];
        DB::table('categories')->insert($newCategories);
    }
}
