<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Models\Project;
use App\Models\Set;

use App\Http\Requests;

class StatsController extends Controller
{
    public function showStats() {
        $stats = [
            "total_projects" => Project::all()->count(),
            "total_sets" => Set::all()->count(),
            "total_parts" => Part::all()->count()
        ];

        return response()->json($stats);
    }
}
