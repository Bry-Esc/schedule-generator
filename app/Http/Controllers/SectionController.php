<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use service;

class SectionController extends Controller
{
    public function index(Request $request)
    {
        
        if ($request->ajax()) {
            return view('rooms.table', compact('rooms'));
        }

        return view('rooms.index', compact('rooms'));
    }
}
