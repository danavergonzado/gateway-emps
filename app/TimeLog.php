<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimeLog extends Model
{
    //protect table columns
    protected $guarded = [];

    protected $dates = ['timein', 'timeout'];

   public function user()
   {
       return $this->belongsTo('App\User');
   }
    
}
