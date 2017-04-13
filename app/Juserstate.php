<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Juserstate extends Model
{
    //
    protected $table='JUserState';
    protected $fillable = ['user_id','state'];
    public $timestamps = false;
    public $primaryKey='user_id';
}
