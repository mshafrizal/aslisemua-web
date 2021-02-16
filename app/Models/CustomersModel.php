<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CustomersModel extends Model
{
    public function create($dataValidated) {
        DB::table('customers')->insert($dataValidated);
    }

    public function index() {
        return DB::table('customers')->get();
    }

    public function show($id) {
        return DB::table('customers')->where('id', $id)->get();
    }

    public function updateUser($id, $dataValidated){
        DB::table('customers')->where('id', $id)->update($dataValidated);
    }
}
