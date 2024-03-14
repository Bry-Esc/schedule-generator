<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CollegeClass;
use service;

class SectionController extends Controller
{
    public function index(Request $request)
    {
        
        if ($request->ajax()) {
            return view('section.table', compact('section'));
        }

        // return view('section.index', compact('section'));
        return view('section.index');
    }
}
