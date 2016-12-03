<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Set extends Model
{
    public function parts($projectSetId) {
        return DB::table('set_part')
            ->join('parts', 'set_part.part_id', '=', 'parts.id')
            ->where('set_part.project_set_id', '=', $projectSetId)
            ->select("parts.*")
            ->get();
    }
}