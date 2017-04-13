<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Juser extends Model
{
    //
	protected $table='Juser';
    protected $fillable = ['user_id','fname','lname','username'];
    public $primaryKey='user_id';
}
