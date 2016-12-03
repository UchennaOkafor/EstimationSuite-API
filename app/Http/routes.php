<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get("reports/project/{projectId}", "ProjectsController@showReport");

Route::group(["prefix" => "api", "middleware" => "api"], function() {
    Route::get("stats", "StatsController@showStats");

    $except = ["except" => ["create", "edit"]];
    Route::resourceParameters(["projects" => "id", "parts" => "id", "sets" => "id"]);

    Route::resource("projects", "ProjectsController", $except);
    Route::resource("parts", "PartsController", $except);
    Route::resource("sets", "SetsController", $except);

    Route::get("projects/search/{name}", "ProjectsController@search");
    Route::get("parts/search/{name}", "PartsController@search");
    Route::get("sets/search/{name}", "SetsController@search");

    Route::post("projects/project_set", "ProjectsController@createProjectSet");
    Route::delete("projects/project_set/{projectSetId}", "ProjectsController@deleteProjectSet");

    Route::post("sets/set_part", "SetsController@createSetPart");
    Route::delete("sets/set_part/{projectSetId}/{partId}", "SetsController@deleteSetPart");

    Route::get("projects/sets/not_in/{projectId}", "ProjectsController@getSetsNoIn");
    Route::get("projects/parts/not_in/{projectSetId}", "ProjectsController@getPartsNotIn");
});