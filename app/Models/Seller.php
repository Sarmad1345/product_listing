<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    function getSellerData()
    {
        return $this->hasOne("App\Http\Controllers\ProducConroller");
    }
}
