<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function sets() {
        return $this->belongsToMany("App\Models\Set")->withPivot("id");
    }
}