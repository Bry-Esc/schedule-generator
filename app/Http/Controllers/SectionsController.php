<?php

namespace App\Http\Controllers;

use App\Models\Section; 
use Illuminate\Http\Request;

class SectionsController extends Controller
{
    /**
     * Display a listing of sections.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::all(); 
        return view('sections.index', compact('sections'));
    }

    /**
     * Show the form for creating a new section.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('/');
    }

    /**
     * Store a newly created section in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'file_url' => 'required' // Add validation rules for file_url
        ]);

        Section::create($validatedData);  
        return redirect('/sections')->with('success', 'Section created successfully!');
    }

    /**
     * Display the specified section.
     *
     * @param  \App\Models\Section $section 
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        return view('sections.show', compact('section'));
    }

    /**
     * Show the form for editing the specified section.
     *
     * @param  \App\Models\Section $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        return view('sections.edit', compact('section'));
    }

    /**
     * Update the specified section in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section $section 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Section $section)
    {
        // (Add validation similar to 'store' action) 
        $rules = [
            'name' => 'required',
            'file_url' => 'required',
        ];

        $this->validate($request, $rules);

        $section->update($request->all());
        return redirect('/sections')->with('success', 'Section updated successfully!');
    }

    /**
     * Remove the specified section from storage.
     *
     * @param  \App\Models\Section $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        $section->delete();
        return redirect('/sections')->with('success', 'Section deleted successfully!');
    }
}
