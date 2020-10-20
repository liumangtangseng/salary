<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'staff';

    public function salary()
    {
        return $this->hasMany(Salary::class,'staff_id','id');
    }
}
