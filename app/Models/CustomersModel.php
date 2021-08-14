<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerAddress;

class CustomersModel extends Model
{
    use HasFactory;

    protected $table = 'customers';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'google_id',
        'name',
        'email',
        'gender',
        'password',
        'phone_number',
        'postal_code',
        'city',
        'district',
        'address',
        'status',
        'is_first_time',
        'is_verified',
        'created_at',
        'updated_at',
        'email_verified_at',
        'remember_token',
        'level'
    ];

    /**
     * Get all of the customer address for the CustomersModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function customerAddress()
    {
        return $this->hasMany(CustomerAddress::class);
    }

    public function create($dataValidated) {
        DB::table('customers')->insert($dataValidated);
    }

    public function index() {
        return DB::table('customers')->get();
    }

    public function show($id) {
        return DB::table('customers')->where('id', $id)->first();
    }

    public function findGoogleUser($googleId) {
        return DB::table('customers')->where('google_id', $googleId)->first();
    }

    public function findGoogleEmail($email) {
        return DB::table('customers')->where('email', $email)->first();
    }

    public function updateUser($id, $dataValidated){
        DB::table('customers')->where('id', $id)->update($dataValidated);
    }

    public function updateGoogleUser($email, $payload) {
        DB::table('customers')->where('email', $email)->update($payload);
    }

    public function verifyAccount($id, $dataVerification) {
        DB::table('customers')->where('id', $id)->update($dataValidated);
    }

    public function forgotPassword($email) {
        return DB::table('customers')->where('email', $email)->first();
    }
}
