<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class FormListController extends Controller {
    public function show() {
        // Get all forms created by user and show in list
        $forms = DB::table('forms')
            ->select(['id', 'name', 'open_count', 'submit_count'])
            ->where('created_by', Auth::id())->get()->toArray();

        $data = [];
        foreach($forms as $key => $value) {
            $data[$key] = [
                'id' => $value->id,
                'name' => $value->name,
                'open_count' => $value->open_count,
                'submit_count' => $value->submit_count,
                'stats_url' => route('form-stats', ['id' => $value->id]),
                'form_url' => route('form-by-id', ['id' => $value->id]),
            ];
        }

        return Inertia::render('FormList', ['data' => $data]);
    }

    // TODO: Refactor
    /**
     * Todo: Logic:
     *  if get -> incrementOpenCOunt & show form to be filled
     *  else post -> validate and update DB  -> return success.
     *
     */
    /**
     * @param Request $request
     * @return \Inertia\Response
     */
    public function showById(Request $request) {
        $id = $request->route()->parameters()['id'];
        $url = route('form-by-id', ['id' => $id]);
        $result = DB::table('forms')
            ->select(['specification'])
            ->where('id', $id)->first();

        // Todo: implement error pages
        if(!isset($result->specification)) {
            die('Invalid URL or No record found');
        }

        return Inertia::render('Form', ['formData' => json_decode($result->specification), 'postUrl'=>$url]);

    }
    public function getShowById(Request $request) {
        $id = $request->route()->parameters()['id'];
        //dd($id);
        DB::table('forms')->where('id', $id)->increment('open_count');
        return $this->showById($request);
    }

    public function stats() {
        // Get all forms created by user and show in list
        $stats = DB::table('forms')
            ->select(['id', 'name', 'open_count', 'submit_count'])
            ->where('created_by', Auth::id())->get()->toArray();

        $data = [];
        foreach($stats as $key => $value) {
            $data[$key] = [
                'id' => $value->id,
                'name' => $value->name,
                'open_count' => $value->open_count,
                'submit_count' => $value->submit_count
            ];
        }

        return Inertia::render('FormStats', ['data' => $data]);
    }

    public function sampleForm() {

        $id = 22; //Retrieve from DB
        $sampleData = [
            "name" => "Survey Form",
            "count" => 7,
            "version" => null,
            "fields" => [
                0 => [
                    "label" => "First Name",
                    "input_type" => "text",
                    "required" => true,
                    "min" => null,
                    "max" => null,
                ],
                1 => [
                    "label" => "Last Name Not Required",
                    "input_type" => "text",
                    "required" => false,
                    "min" => null,
                    "max" => null,
                ],
                2 => [
                    "label" => "Age",
                    "input_type" => "number",
                    "required" => true,
                    "min" => 18,
                    "max" => null,
                ],
                3 => [
                    "label" => "number required min",
                    "input_type" => "number",
                    "required" => true,
                    "min" => 10,
                    "max" => null,
                ],
                4 => [
                    "label" => "number not required",
                    "input_type" => "number",
                    "required" => false,
                    "min" => 10,
                    "max" => 20,
                ],
                5 => [
                    "label" => "number required max",
                    "input_type" => "number",
                    "required" => true,
                    "min" => null,
                    "max" => 90,
                ],
                6 => [
                    "label" => "number required min & max",
                    "input_type" => "number",
                    "required" => true,
                    "min" => 10,
                    "max" => 90,
                ],
            ]
        ];
        $url = route('form-by-id', ['id' => $id]);
        return Inertia::render('Form', ['formData' => $sampleData, 'postUrl'=>$url]);
    }
}
