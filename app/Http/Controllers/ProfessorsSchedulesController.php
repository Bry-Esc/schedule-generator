<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use Response;
use App\Models\Day;
use App\Models\Course;
use App\Models\ProfessorSched;
use App\Models\Timeslot;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\UnavailableTimeslot;
use App\Services\ProfessorsService;
use Illuminate\Support\Facades\Log;

class ProfessorsSchedulesController extends Controller
{
    
    public function __construct(ProfessorsService $service)
    {
        $this->service = $service;
        $this->middleware('auth');
        $this->middleware('activated');
    }

    /**
     * Show landing page for professors module
     *
     * @param Illuminate\Http\Request $request The HTTP request
     */
    public function index(Request $request)
    {
        // $professors = $this->service->all([
        //     'keyword' => 'nonexistent_keyword',
        //     'order_by' => 'name',
        //     'paginate' => 'true',
        //     'per_page' => 20
        // ]);

        $courses = Course::all();
        $days = Day::all();
        $timeslots = Timeslot::all();

        if ($request->ajax()) {
            return view('prof_sched.table', compact('professors'));
        }

        // return view('prof_sched.index', compact('professors', 'courses', 'days', 'timeslots'));
        return view('prof_sched.index');
    }

    /**
     * Add a new professor to the database
     *
     * @param Illuminate\Http\Request The HTTP request
     */
    public function store(Request $request)
    {
        // Log::debug('Professor Data:', $request->all());
        // Log::debug('Department:', $request->department);  // Log specifically
        // Log::debug('Employment Status:', $request->employment_status); // Log specifically

        $rules = [
            'name' => 'required|unique:professors',
            'department' => 'required',
            'employment_status' => 'required'
        ];

        // if ($request->has('email') && $request->email) {
        //     $rules['email'] = 'email';
        // }

        $this->validate($request, $rules);

        $professor = $this->service->store($request->all());

        if ($professor) {
            return response()->json(['message' => 'Professor added'], 200);
        } else {
            return response()->json(['error' => 'An unknown system error occurred'], 500);
        }
    }

    /**
     * Get and return data about a professor
     *
     * @param int $id Id of professor
     * @return Illuminate\Http\Response The data as a JSON response
     */
    public function show($id)
    {
        $professor = $this->service->show($id);

        if ($professor) {
            return response()->json($professor, 200);
        } else {
            return response()->json(['errors' => ['Professor not found']], 404);
        }
    }

    /**
     * Update the professor with the given id
     *
     * @param int $id Id of the professor
     * @param Illuminate\Http\Request $request The HTTP request
     */
    public function update($id, Request $request)
    {
        $professor = Professor::find($id);

        if (!$professor) {
            return response()->json(['errors' => ['Professor does not exist']], 404);
        }

        $rules = [
            'name' => ['required', Rule::unique('professors')->ignore($professor->id)],
            'department' => 'required',
            'employment_status' => 'required',
        ];

        $messages = [
            'name.unique' => 'This Professor already exists',
            'department.required' => 'Select a Department',
            'employment_status.required' => 'Select an Employment Status',
        ];

        if ($request->has('email') && $request->email) {
            $rules['email'] = 'email';
        }

        $this->validate($request, $rules, $messages);

        $professor = $this->service->update($id, $request->all());

        return response()->json(['message' => 'Professor updated'], 200);
    }


    /**
     * Delete the professor with the given id
     *
     * @param int $id Id of professor to delete
     */
    public function destroy($id)
    {
        $professor = Professor::find($id);

        if (!$professor) {
            return response()->json(['error' => 'Professor not found'], 404);
        }

        if ($this->service->delete($id)) {
            return response()->json(['message' => 'Professor has been deleted'], 200);
        } else {
            return response()->json(['error' => 'An unknown system error occurred'], 500);
        }
    }

    public function find(Request $request) {
        $request->validate([
            'query' => 'required'
        ]);

        $search_text = $request->input('query');
        
        // $timetables = Timetable::where('name', 'like', '%' . $search_text . '%')->get();
        $professor_scheds = ProfessorSched::where('name', 'like', $search_text . '%')->get();

        // if ($request->ajax()) {
        //     return view('professors.table', compact('professors'));
        // }

        // $timetables = Timetable::all();

        return view('prof_sched.index', compact('professor_scheds'));
    }
}
