<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class CheckItemExists
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $as = $request->route()->getAction()["as"];
        $tableName = explode(".", $as)[1];

        if (DB::table($tableName)->where("id", $request->id)->count() == 0) {
            $output = ["error_msg" => "Sorry the item you was looking for doesn't exist"];
            return response()->json($output, 404);
        }

        return $next($request);
    }
}