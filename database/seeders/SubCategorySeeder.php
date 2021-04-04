<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newSubCategories = [
            [
                'id' => '9e697486-853e-4081-bed2-65822e11ed89',
                'name' => 'Necklace',
                'description' => 'Necklace',
                'file_path' => null,
                'parent' => 'Jewelry',
                'is_published' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'created_by' => 'Pandhu Wibowo',
                'updated_by' => 'Pandhu Wibowo',
                'category_id' => '54ce287f-c357-491c-a933-67c87243616c'
            ],
            [
                'id' => '93f6c85d-a236-4425-a2e0-eb393c2731f4',
                'name' => 'Wardrobe',
                'description' => 'Wardrobe',
                'file_path' => null,
                'parent' => 'Furniture',
                'is_published' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'created_by' => 'Pandhu Wibowo',
                'updated_by' => 'Pandhu Wibowo',
                'category_id' => '348c8cbe-b200-4135-bdcc-c1de0b4530fa'
            ]
        ];
        DB::table('subcategories')->insert($newSubCategories);
    }
}
