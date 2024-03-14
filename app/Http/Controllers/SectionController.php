<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CollegeClass;
use service;

class SectionController extends Controller
{
    // Display a listing of the resource
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return view('section.table', compact('section'));
        }

        return view('section.index');
    }

    // Show the form for creating a new resource
    public function create()
    {
        // 
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        $rules = [
            'program_code' => 'required',
            'level' => 'required'
        ]; 

        $this->validate($request, $rules);

        // $section = $this->service->store($request->all());

        // if ($section) {
        //     return response()->json(['message' => 'Professor added'], 200);
        // } else {
        //     return response()->json(['error' => 'An unknown system error occurred'], 500);
        // }

    }

    // Display the specified resource
    public function show(Section $section)
    {
        // 
    }

    // Show the form for editing the specified resource
    public function edit(Section $section)
    {
        // 
    }

    // Update the specified resource in storage
    public function update(Request $request, Section $section)
    {
        // 
    }

    // Remove the specified resource from storage
    public function destroy(Section $section)
    {
        // 
    }
}
