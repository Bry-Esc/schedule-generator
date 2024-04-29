<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\Section;
use App\Models\Timetable;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\ProfessorSched;
use App\Services\TimetableService;
use App\Events\TimetablesRequested;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TimetablesController extends Controller
{

    protected TimetableService $service;

    /**
     * Create a new instance of this controller and set up
     * middlewares on this controller methods
     */
    public function __construct(TimetableService $service)
    {
        $this->service = $service;
        // $this->middleware('auth');
        // $this->middleware('activated');
    }

    /**
     * Handle ajax request to load timetable to populate
     * timetables table on dashboard
     *
     */
    public function index()
    {
        $timetables = Timetable::orderBy('created_at', 'DESC')->paginate(10);

        return view('dashboard.timetables', compact('timetables'));
    }

    /**
     * Create a new timetable object and hand over to genetic algorithm
     * to generate
     *
     * @param \Illuminate\Http\Request $request The HTTP request
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'academic_period_id' => 'required',
            // 'days' => 'required'
        ];

        $messages = [
            'name.required' => 'A school year must be selected',
            'academic_period_id.required' => 'An academic period must be selected',
            'days.required' => 'At least one day must be selected'
        ];

        $this->validate($request, $rules, $messages);

        $errors = [];
        $dayIds = [];

        // $days = Day::all();

        // foreach ($days as $day) {
        //     if ($request->has('day_' . $day->id)) {
        //         $dayIds[] = $day->id;
        //     }
        // }
        
        // Check if MTh is selected
        if ($request->has('MTh')) {
            // Get the IDs of Monday and Thursday
            $mthIds = Day::whereIn('name', ['Monday', 'Thursday'])->pluck('id')->toArray();

            // Merge the MTh IDs with the existing day IDs
            $dayIds = array_merge($dayIds, $mthIds);
        }

        // Check if TF is selected
        if ($request->has('TF')) {
            // Get the IDs of Tuesday and Friday
            $tfIds = Day::whereIn('name', ['Tuesday', 'Friday'])->pluck('id')->toArray();

            // Merge the TF IDs with the existing day IDs
            $dayIds = array_merge($dayIds, $tfIds);
        }

        // Check if WS is selected
        if ($request->has('WS')) {
            // Get the IDs of Wednesday and Saturday
            $wsIds = Day::whereIn('name', ['Wednesday', 'Saturday'])->pluck('id')->toArray();

            // Merge the WS IDs with the existing day IDs
            $dayIds = array_merge($dayIds, $wsIds);
        }

        if (!count($dayIds)) {
            $errors[] = 'At least one day must be selected';
        }

        if (count($errors)) {
            return response()->json(['errors' => $errors], 422);
        }

        $otherChecks = $this->service->checkCreationConditions();

        if (count($otherChecks)) {
            return response()->json(['errors' => $otherChecks], 422);
        }

        $timetable = Timetable::create([
            'user_id' => Auth::user()->id,
            'academic_period_id' => $request->academic_period_id,
            'status' => 'IN PROGRESS',
            'name' => $request->name
        ]);

        if ($timetable) {
            $timetable->days()->sync($dayIds);
        }

        event(new TimetablesRequested($timetable));

        return response()->json(['message' => 'A schedule is being generated. Check back after 3 minutes'], 200);
    }

    /**
     * Remove the specified timetable from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $timetable = Timetable::find($id);

        if (!$timetable) {
            return redirect('/')->with('error', 'Timetable not found');
        }

        $timetable->delete();

        return response()->json(['message' => 'Schedule Deleted'], 200);
    }

    /**
     * Display a printable view of timetable set
     *
     * @param int $id
     */
    public function view($id)
    {
        $timetable = Timetable::find($id);

        if (!$timetable) {
            return redirect('/');
        } else {
            $path = $timetable->file_url;
            $timetableData =  Storage::get($path);
            $timetableName = $timetable->name;
            return view('timetables.view', compact('timetableData', 'timetableName'));
        }
    }

    public function render($id)
    {
        $sectionSchedule = Section::find($id);

        if (!$sectionSchedule) {
            return redirect('/');
        } else {
            $path = $sectionSchedule->file_url;
            $timetableData = Storage::get($path);
            $timetableName = $sectionSchedule->name;
            return view('timetables.render', compact('timetableData', 'timetableName'));
        }
    }

    public function renderProfSched($id)
    {
        $profSched = ProfessorSched::find($id);

        if (!$profSched) {
            return redirect('/');
        } else {
            $path = $profSched->file_url;
            $timetableData = Storage::get($path);
            $timetableName = $profSched->name;
            return view('timetables.render', compact('timetableData', 'timetableName'));
        }
    }
}
