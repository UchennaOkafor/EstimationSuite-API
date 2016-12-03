<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProjectsController extends Controller
{
    public function __construct() {
        $this->middleware("item.exists", ["only" => ["update", "destroy"]]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $projects = Project::all();

        foreach ($projects as $project) {
            //The id of the pivot is the project set id. The project set id is the association between project and set
            foreach ($project->sets as $set) {
                $set["parts"] = $set->parts($set->pivot->id);
            }
        }

        return response()->json($projects);
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

        $project = new Project();
        $project->name = $request->input("name");
        $project->save();
        return response()->json($project);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $project = Project::find($id);

        if ($project != null) {
            foreach ($project->sets as $set) {
                $set["parts"] = $set->parts($set->pivot->id);
            }
        }

        return response()->json($project);
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

        $project = Project::find($id);
        $project->name = $request->input("name");
        $project->save();
        return response()->json($project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        Project::destroy($id);
        return response()->json(["msg" => "Item {$id} successfully deleted"]);
    }

    public function search($name) {
        return response()->json(Project::where("name", "LIKE", "%{$name}%")->get());
    }

    public function createProjectSet(Request $request) {
        $validator = Validator::make($request->all(), [
            "project_id" => "required",
            "set_ids" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->messages()], 403);
        }

        $data = [];
        $setIds = json_decode($request->input("set_ids"), true);

        foreach ($setIds as $setId) {
            $data[] = ["project_id" => $request->input("project_id"), 'set_id' => $setId];
        }

        DB::table("project_set")->insert($data);
        return response()->json(["message" => "Project set association(s) has been created"]);
    }

    public function deleteProjectSet($projectSetId) {
        DB::table("project_set")->where("id", $projectSetId)->delete();
        return response()->json(["message" => "Project set association has been deleted"]);
    }

    /**
     * Gets a list of sets where the set has not been associated with a specific project
     * @param $projectId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSetsNoIn($projectId) {
        $sets = DB::select("SELECT * FROM sets
                          WHERE sets.id NOT IN
                          (SELECT sets.id FROM sets, project_set
                          WHERE sets.id = project_set.set_id
                          AND project_set.project_id = ?)", [$projectId]);

        return response()->json($sets);
    }

    /**
     * Get's a list of parts that does not exist in a projectSet
     * @param $projectSetId int the target project set
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPartsNotIn($projectSetId) {
        //A project set is the association between project and set
        $parts = DB::select("SELECT * FROM parts
                          WHERE parts.id NOT IN
                          (SELECT parts.id FROM parts, set_part
                          WHERE parts.id = set_part.part_id
                          AND set_part.project_set_id = ?)", [$projectSetId]);

        return response()->json($parts);
    }

    /**
     * Generates and displays a report for the specified project
     * @param $projectId int the id of the project to generate a report for
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showReport($projectId) {
        $project = Project::find($projectId);
        $errorMsg = null;

        if ($project == null) {
            $errorMsg = "Sorry, but the project you're looking for does not exist.";

        } else if(count($project->sets) == 0) {
            $errorMsg = "Sorry, but this project does not contain any set(s). Thus a report cannot be generated.";

        } else {
            foreach ($project->sets as $set) {
                $set["parts"] = $set->parts($set->pivot->id);

                $spTotal = 0;
                $ppTotal = 0;
                $weightTotal = 0;

                foreach($set["parts"] as $part) {
                    $spTotal += $part->sales_price;
                    $ppTotal += $part->purchase_price;
                    $weightTotal += $part->weight;
                }

                $set["total_sales_price"] = $spTotal;
                $set["total_purchase_price"] = $ppTotal;
                $set["weight_total"] += $weightTotal;

                $project["total_sales_price"] += $spTotal;
                $project["total_purchase_price"] += $ppTotal;
                $project["weight_total"] += $weightTotal;
            }
        }

        return view("reports.project", ["errorMsg" => $errorMsg, "project" => $project, "currency" => "£"]);
    }
}