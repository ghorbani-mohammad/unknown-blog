<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JUserView extends Model
{
    //
    protected $table='JUserView';
    protected $fillable = ['user_id','VIEWSTATE','VIEWSTATEGENERATOR','EVENTVALIDATION'];
    public $primaryKey='user_id';


}
