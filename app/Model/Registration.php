<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use DB;

class Registration extends Model
{
    protected $table="registration";

    public static function List() 
    {
        $Displaydetails=DB::table('registration')->get();
        return $Displaydetails;
    }
}
