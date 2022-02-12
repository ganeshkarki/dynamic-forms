<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class FormCreateController extends Controller {

    public function show() {
        // TODO: Return session data if exist in case coming back from Preview Screen
        return Inertia::render('CreateForm');
    }

    public function create() {
    }

    public function submit(Request $request) {
        // Todo Server Side Validation
        $post = $request->post();
        $formName = $post['specification']['name'];

        DB::table('forms')->insert([
            'name' => $formName,
            'specification' => json_encode($post['specification']),
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('dashboard');
    }
}
