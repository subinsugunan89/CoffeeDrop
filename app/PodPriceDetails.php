<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PodPriceDetails extends Model
{
    public function product()
   {
       return $this->belongsTo('App\Poditems');
   }
}
