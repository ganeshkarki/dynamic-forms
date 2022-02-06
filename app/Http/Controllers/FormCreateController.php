<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class FormCreateController extends Controller {

    public function show() {
        // TODO: Return session data if exist in case coming back from Preview Screen
        return Inertia::render('CreateForm');
    }

    public function create() {
    }

    public function preview() {
    }

    public function submit() {
    }
}
