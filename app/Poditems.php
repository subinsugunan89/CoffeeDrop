<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Poditems extends Model
{
    public function prices()
    {
        return $this->hasMany('App\PodPriceDetails');
    }
}
