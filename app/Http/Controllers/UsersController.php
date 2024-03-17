<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Day;
use App\Models\User;
use App\Models\Course;
use App\Models\Timetable;

use App\Services\Helpers;


use Illuminate\Http\Request;

use App\Models\SecurityQuestion;

use Illuminate\Support\Facades\DB;
use App\Services\ProfessorsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Events\PasswordResetRequested;


class UsersController extends Controller
{
    protected $service;

    // public function __construct()
    // {
    //     $this->middleware('auth', ['only' => ['showAccountPage', 'showActivationPage', 'updateAccount']]);
    // }

    public function __construct(ProfessorsService $service)
    {
        $this->service = $service;
        $this->middleware('auth', ['only' => ['showAccountPage', 'showActivationPage', 'updateAccount']]);
    }

    /**
     * Show page for logging user in
     */
    public function showLoginPage()
    {
        return view('auth.login');
    }

    /**
     * Find Students
     *
     * @param Illuminate\Http\Request $request The HTTP request
     */

    /**
     * Log in a user
     *
     * @param Illuminate\Http\Request $request The HTTP request
     */
    public function loginUser(Request $request)
    {
        $rules = [
            "email" => "required|email",
            'password' => 'required'
        ];

        $this->validate($request, $rules);

        // $field = filter_var($request->login_field, FILTER_VALIDATE_EMAIL) ? 'email' : 'username'; 

        // $credentials = [
        //     $field => $request->login_field, 
        //     'password' => $request->password
        // ];

        if (auth()->attempt(\request()->only('email', 'password'))) {
            // Authentication was successful
            return redirect()->intended('/'); // Redirect as needed
        } 

        return redirect()->back()->withErrors(['Invalid credentials']);

        // $user = User::first();

        // if (!$user) {
        //     return redirect()->back()->withErrors(['No user account has been set up yet']);
        // }

        // if (!Hash::check($request->password, $user->password)) {
        //     return redirect()->back()->withErrors(['Password is invalid']);
        // }

        // Auth::login($user);

        // return redirect('/');
    }

    /**
     * Show account activation page where new user can set up his
     * account
     *
     * @return Illuminate\Http\Response Account activation view
     */
    public function showActivationPage()
    {
        $user = Auth::user();
        $questions = SecurityQuestion::all();

        return view('users.activate', compact('user', 'questions'));
    }

    /**
     * Activate and set up account for user
     *
     * @param Illuminate\Http\Request $request The HTTP request
     * @return Illuminate\Http\Response Redirect to home page
     */
    public function activateUser(Request $request)
    {
        $user = Auth::user();

        if ($user->activated) {
            return redirect()->back()->withError('Your account is already activated');
        }

        $rules = [
            'name' => 'required',
            'password' => 'required|confirmed',
            'security_question_id' => 'required|exists:security_questions,id',
            'security_question_answer' => 'required'
        ];

        $messages = [
            'security_question_id.required' => 'A security question must be selected.',
            'security_question_answer.required' => 'Add an answer for security question.'
        ];

        $this->validate($request, $rules, $messages);

        $user->update([
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'security_question_id' => $request->security_question_id,
            'security_question_answer' => $request->security_question_answer,
            'activated' => true
        ]);

        return redirect('/');
    }

    /**
     * Show the page to reuqest new password
     */
    public function showPasswordRequestPage()
    {
        $user = User::first();

        return view('users.password_request', compact('user'));
    }

    /**
     * Handle the request to reset password after user forgets
     * password
     *
     * @param Illuminate\Http\Request $request The HTTP request
     */
    public function requestPassword(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'security_question_answer' => 'required'
        ];

        $this->validate($request, $rules);

        $user = User::first();

        if ($user->security_question_answer != $request->security_question_answer) {
            return redirect()->back()->withErrors(['Your answer is not valid']);
        }

        $token = Helpers::generateRandomString();

        DB::table('password_resets')->delete();
        DB::table('password_resets')->insert([
            'user_id' => $user->id,
            'token' => $token,
            'expiry_date' => Carbon::now()->addDay()->toDateTimeString()
        ]);

        event(new PasswordResetRequested($token, $request->email));

        return redirect('/reset_password');
    }

    /**
     * Show page for password reset
     *
     */
    public function showResetPassword()
    {
        return view('users.password_reset');
    }

    /**
     * Handle reset of password
     */
    public function resetPassword(Request $request)
    {
        $token = DB::table('password_resets')->first();

        $rules = [
            'token' => 'required'
        ];

        $this->validate($request, $rules);

        if (!$token || ($token && $token->token != $request->token)) {
            return redirect()->back()->withErrors(['Invalid token']);
        }

        if (Carbon::now()->gt(Carbon::parse($token->expiry_date))) {
            return redirect()->back()->withErrors(['Token has expired.Please request for new token']);
        }

        $user = User::first();
        $user->update([
            'activated' => false
        ]);

        Auth::login($user);
        return redirect('/');
    }

    /**
     * Show account settings page
     *
     */
    public function showAccountPage()
    {
        $user = Auth::user();
        $questions = SecurityQuestion::all();

        return view('users.account', compact('user', 'questions'));
    }

    /**
     * Update user account
     *
     * @param Illuminate\Http\Request $request The HTTP request
     */
    public function updateAccount(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'email' => 'required|email|unique:users,email,' . $user->id,
            'name' => 'required',
            'security_question_id' => 'required',
            'security_question_answer' => 'required'
        ];

        if ($request->has('password') && $request->password) {
            $rules['password'] = 'confirmed';
            $rules['old_password'] = 'required';
        };

        $this->validate($request, $rules);

        $data = [
            'email' => $request->email,
            'name' => $request->name,
            'security_question_id' => $request->security_question_id,
            'security_question_answer' => $request->security_question_answer
        ];

        if ($request->has('password') && $request->password) {
            if (!Hash::check($request->old_password, $user->password)) {
                return redirect()->back()->withErrors(['Current password is invalid']);
            }

            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->back()->with('status', 'Your account has been updated');
    }

    // function find(Request $request){
    //     $request->validate([
    //       'query'=>'required|min:2'
    //     ]);

    //     $search_text = $request->input('query');

    //     $professors = DB::table('professors')
    //     ->where('name', 'like', '%' . $search_text . '%')
    //     ->paginate(2);

    //     $professor_schedules = ProfessorSchedule::all();

    //     return view('auth/login', ['professor_schedules' => $professors]);
    // }

    public function find(Request $request) {
        $request->validate([
            'query' => 'required|min:2'
        ]);

        $search_text = $request->input('query');
        
        $timetables = Timetable::where('name', 'like', '%' . $search_text . '%')->get();

        // if ($request->ajax()) {
        //     return view('professors.table', compact('professors'));
        // }

        return view('auth/login', compact('timetables'));
    }
}
