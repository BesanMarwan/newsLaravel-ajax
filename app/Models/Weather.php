<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    protected $table="weather";
    protected $guarded=[];
    public $timestamps = true;

}
