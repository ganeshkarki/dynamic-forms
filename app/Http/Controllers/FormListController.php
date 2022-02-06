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
            ->select(['id', 'name'])
            ->where('created_by', Auth::id())->get()->toArray();

        $data = [];
        foreach($forms as $key => $value) {
            $data[$key] = [
                'id' => $value->id,
                'name' => $value->name,
                'url' => route('form-by-id', ['id'=>$value->id])
            ];
        }

        return Inertia::render('FormList', ['data' => $data]);
    }

    public function showById() {

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
