<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasFactory;
    use HasApiTokens;

    protected $guarded = [];
    public $timestamps = false;
    protected $hidden = ['password_account', 'OTP', 'created_at', 'updated_at'];
}
