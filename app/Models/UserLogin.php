<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserLogin extends Model
{
    protected $table = "HRIS.dbo.ListMasterLogin";
    protected $primaryKey = 'EmpID';
    public $incrementing = false;   // karena EmpID bukan auto increment
    protected $keyType = 'string';  // EmpID varchar
    public $timestamps = false;

    protected $fillable = [
        'EmpID', 'Password', 'TMS', 'EmpName', 'Role'
    ];
}
