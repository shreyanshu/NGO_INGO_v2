<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class country extends Model
{
    public function organization()
    {
    	return $this->belongsTo(Organization::class);
    }
}
