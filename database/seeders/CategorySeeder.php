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
                'id' => 'c92808e4-47c0-4fd4-8ed5-765abbd2774b',
                'name' => 'Men',
                'slug' => 'men',
                'description' => 'Men',
                'file_path' => null,
                'parent' => '',
                'is_published' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'created_by' => 'Khalifa',
                'updated_by' => 'Khalifa'
            ],
            [
                'id' => 'ca187fc8-7f9e-4b7a-ab30-d331142b5bba',
                'name' => 'Women',
                'slug' => 'women',
                'description' => 'Women',
                'file_path' => null,
                'parent' => '',
                'is_published' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'created_by' => 'Khalifa',
                'updated_by' => 'Khalifa'
            ],
            [
                'id' => 'ce87e284-100a-4003-a1b7-00009a0e8b6a',
                'name' => 'Watches',
                'slug' => 'watches',
                'description' => 'Watches',
                'file_path' => null,
                'parent' => '',
                'is_published' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'created_by' => 'Khalifa',
                'updated_by' => 'Khalifa'
            ],
            [
                'id' => '54ce287f-c357-491c-a933-67c87243616c',
                'name' => 'Jewelry',
                'slug' => 'jewelry',
                'description' => 'Jewelry',
                'file_path' => null,
                'parent' => '',
                'is_published' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'created_by' => 'Pandhu Wibowo',
                'updated_by' => 'Pandhu Wibowo'
            ],
            [
                'id' => 'b3d55ed0-e374-400d-a302-19ea5cbfaf82',
                'name' => 'Handbags',
                'slug' => 'handbags',
                'description' => 'Handbags',
                'file_path' => null,
                'parent' => '',
                'is_published' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'created_by' => 'Khalifa',
                'updated_by' => 'Khalifa'
            ],
            [
                'id' => 'ac274602-7c83-47b0-adba-d5abe463152e',
                'name' => 'Jackets',
                'slug' => 'jackets',
                'description' => 'Jackets',
                'file_path' => null,
                'parent' => '',
                'is_published' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'created_by' => 'Khalifa',
                'updated_by' => 'Khalifa'
            ],
            [
                'id' => 'e8876cee-f17a-49ac-a5aa-196e43f69dee',
                'name' => "Men's Boots",
                'slug' => 'mens-boots',
                'description' => "Men's Boots",
                'file_path' => null,
                'parent' => '',
                'is_published' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'created_by' => 'Khalifa',
                'updated_by' => 'Khalifa'
            ],
            [
                'id' => '2eb86eee-5f51-4142-b3bc-2498e618d97a',
                'name' => "Men's Jackets",
                'slug' => 'mens-jackets',
                'description' => "Men's Jackets",
                'file_path' => null,
                'parent' => '',
                'is_published' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'created_by' => 'Khalifa',
                'updated_by' => 'Khalifa'
            ],
            [
                'id' => '952939e5-d35b-413e-a194-78b1969482e4',
                'name' => "Heels",
                'slug' => 'heels',
                'description' => "Heels",
                'file_path' => null,
                'parent' => '',
                'is_published' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'created_by' => 'Khalifa',
                'updated_by' => 'Khalifa'
            ],
            [
                'id' => 'd220211b-13a1-4424-9eaa-e04f6ed4fa26',
                'name' => "Women's Glasses",
                'slug' => 'womens-glasses',
                'description' => "Women's Glasses",
                'file_path' => null,
                'parent' => '',
                'is_published' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'created_by' => 'Khalifa',
                'updated_by' => 'Khalifa'
            ],
            [
                'id' => '290dd698-408c-4062-b319-a0109dbffddd',
                'name' => "Men's Grooming",
                'slug' => 'mens-grooming',
                'description' => "Men's Grooming",
                'file_path' => null,
                'parent' => '',
                'is_published' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'created_by' => 'Khalifa',
                'updated_by' => 'Khalifa'
            ],
            [
                'id' => 'b578699c-e289-48db-bdd9-1aee5c83cdb5',
                'name' => "Earrings",
                'slug' => 'earrings',
                'description' => "earrings",
                'file_path' => null,
                'parent' => '',
                'is_published' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'created_by' => 'Khalifa',
                'updated_by' => 'Khalifa'
            ],
            [
                'id' => '298db7d4-826d-46ee-ab4b-c7fa5edda7bc',
                'name' => 'Bags',
                'slug' => 'bags',
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
                'slug' => 'clothes',
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
                'slug' => 'furniture',
                'description' => 'Furniture',
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
