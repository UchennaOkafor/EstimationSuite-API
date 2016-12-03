<?php

namespace App\Http\Controllers;

use App\Models\Part;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class PartsController extends Controller
{
    public function __construct() {
        $this->middleware('item.exists', ['only' => ['update', 'destroy']]);
    }

    private function getRequestValidator(Request $request) {
        return Validator::make($request->all(), [
            "name" => "required|max:255",
            "weight" => "required",
            "units" => "required",
            "stock" => "required",
            "length" => "required",
            "width" => "required",
            "sales_price" => "required",
            "purchase_price" => "required"
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return response()->json(Part::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validator = $this->getRequestValidator($request);

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->messages()], 403);
        }

        $part = new Part($request->all());
        $part->save();
        return response()->json($part);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        return response()->json(Part::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $validator = $this->getRequestValidator($request);

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->messages()], 403);
        }

        $part = Part::find($id)->fill($request->all());
        $part->save();
        return response()->json($part);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        Part::destroy($id);
        return response()->json(["msg" => "Item {$id} successfully deleted"]);
    }

    public function search($name) {
        return response()->json(Part::where("name", "LIKE", "%{$name}%")->get());
    }
}
