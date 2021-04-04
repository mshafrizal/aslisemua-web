<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FutherSubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newFurtherSubCategories = [
            // [
            //     'id' => '63bbaeb3-7782-4e06-8882-954272965b22',
            //     'name' => 'Diamond',
            //     'description' => 'Diamond',
            //     'file_path' => null,
            //     'parent' => 'Necklace',
            //     'is_published' => 1,
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            //     'created_by' => 'Pandhu Wibowo',
            //     'updated_by' => 'Pandhu Wibowo',
            //     'subcategory_id' => '9e697486-853e-4081-bed2-65822e11ed89'
            // ],
            [
                'id' => '44f214a8-3ad4-4f2f-b7c1-698ee0f14b54',
                'name' => 'Bed',
                'description' => 'Bed',
                'file_path' => null,
                'parent' => 'Wardrobe',
                'is_published' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'created_by' => 'Pandhu Wibowo',
                'updated_by' => 'Pandhu Wibowo',
                'subcategory_id' => '93f6c85d-a236-4425-a2e0-eb393c2731f4'
            ]
        ];
        DB::table('further_subcategories')->insert($newFurtherSubCategories);
    }
}
