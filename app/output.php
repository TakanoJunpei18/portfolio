<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class output extends Model
{
    protected  $table = 'outputs';
    protected  $guarded= array('id');
    
    public static $rules = array(
        'title' => 'required',
        'body' => 'required',
    );

 
}