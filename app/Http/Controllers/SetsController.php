<?php

namespace App\Http\Controllers;

use App\Models\Set;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SetsController extends Controller
{
    public function __construct() {
        $this->middleware('item.exists', ['only' => ['update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return response()->json(Set::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validator = Validator::make($request->all(), ["name" => "required|max:255"]);

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->messages()], 403);
        }

        $set = new Set();
        $set->name = $request->input("name");
        $set->save();
        return response()->json($set);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        return response()->json(Set::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), ["name" => "required|max:255"]);

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->messages()], 403);
        }

        $set = Set::find($id);
        $set->name = $request->input("name");
        $set->save();

        return response()->json($set);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $project = Set::find($id);
        $project->delete();
        return response()->json(["msg" => "Item successfully deleted", "data" => $project]);
    }

    public function search($name) {
        return response()->json(Set::where("name", "LIKE", "%{$name}%")->get());
    }

    public function createSetPart(Request $request) {
        $validator = Validator::make($request->all(), [
            "project_set_id" => "required",
            "part_ids" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->messages()], 403);
        }

        $data = [];
        $partIds = json_decode($request->input("part_ids"), true);

        foreach ($partIds as $partId) {
            $data[] = ['project_set_id' => $request->input("project_set_id"), 'part_id' => $partId];
        }

        DB::table('set_part')->insert($data);

        return response()->json(["message" => "Set part association(s) has been created"]);
    }

    public function deleteSetPart($projectSetId, $partId) {
        DB::table('set_part')->where('project_set_id', $projectSetId)
            ->where('part_id', $partId)->delete();

        return response()->json(["message" => "Set part association has been deleted"]);
    }
}
