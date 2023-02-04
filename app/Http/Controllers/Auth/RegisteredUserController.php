<?php

namespace App\Http\Controllers\Auth;

use Notification;
// use App\Models\Station;
use App\Models\Role;
use App\Models\User;
use App\Models\Department;
use App\Models\ActivityLog;
use App\Models\Designation;
use App\Models\CRS\Facility;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Notifications\SendEmailNotification;

class RegisteredUserController extends Controller
{
    public function index()
    {
        $users = User::addSelect([
            'department_name' => Department::select('department_name')->whereColumn('department_id', 'departments.id'),
            'dept_name' => Department::select('department_name')->whereColumn('department_id', 'departments.id'),
            'designation_name' => Designation::select('name')->whereColumn('designation_id', 'designations.id'),
        ])->with('facility', 'facility.parent')->latest()->get();

        $departments = Department::all();
        $designations = Designation::all();
        $facilities = Facility::with('parent')->orderBy('facility_name', 'asc')->get();
        $logs = ActivityLog::all();
        $roles = Role::all();

        return view('admin.dashboard', compact('users', 'designations', 'departments', 'facilities', 'logs', 'roles'));
    }

      /**
       * Display the registration view.
       *
       * @return \Illuminate\View\View
       */
      public function getEmployee($emp_id)
      {
          $employee = Employee::select('id', 'first_name', 'last_name', 'emp_id', 'prefix', 'email', 'contact')->where('emp_id', $emp_id)->get();

          return response()->json($employee[0]);
      }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'surname' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Rules\Password::defaults()],
            'title' => ['required', 'string', 'max:6'],
            'contact' => ['string', 'max:20'],
            'is_active' => ['required', 'integer', 'max:3'],
            'avatar' => ['image', 'mimes:jpg,png', 'max:200'],
        ]);

        $input = $request->all();
        $eventuser = auth()->user()->id;
        $patient = 1;
        $lab_no = 'BL001';
        $event = 'added patient'.' '.$patient;

        $greeting = 'Hello'.' '.$request->first_name;
        $body = 'Your password is'.' '.$request->password;
        $actiontext = 'Click to Login';
        $details = [
            'greeting' => $greeting,
            'body' => $body,
            'actiontext' => $actiontext,
            'actionurl' => 'https://crs.co.ug',
        ];

        $photoPath = '';
        $signaturePath = '';

        if ($request->hasFile('avatar') && $request->hasFile('signature')) {
            $request->validate(['avatar' => 'image']);
            $photoName = date('YmdHis').$request->surname.'.'.$request->file('avatar')->extension();
            $signatureName = date('YmdHis').$request->surname.'.'.$request->file('signature')->extension();
            $photoPath = $request->file('avatar')->storeAs('photos', $photoName, 'public');
            $signaturePath = $request->file('signature')->storeAs('signatures', $signatureName, 'public');
        } elseif ($request->hasFile('avatar')) {
            $request->validate(['avatar' => 'image']);
            $photoName = date('YmdHis').$request->surname.'.'.$request->file('avatar')->extension();
            $photoPath = $request->file('avatar')->storeAs('photos', $photoName, 'public');
            $signaturePath = '';
        } elseif ($request->hasFile('signature')) {
            $signatureName = date('YmdHis').$request->surname.'.'.$request->file('signature')->extension();
            $signaturePath = $request->file('signature')->storeAs('signatures', $signatureName, 'public');
            $photoPath = '';
        } else {
            $photoPath = '';
            $signaturePath = '';
        }

        $user = User::create([

            'surname' => $input['surname'],
            'first_name' => $input['first_name'],
            'other_name' => $input['middle_name'],
            'name' => $input['surname'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'title' => $input['title'],
            'contact' => $input['contact'],
            'facility_id' => $input['facility_id'],
            'department_id' => $input['department_id'],
            'designation_id' => $input['designation_id'],
            'avatar' => $photoPath,
            'signature' => $signaturePath,
            'is_active' => $input['is_active'],

        ]);
        $user->attachRole($request->rolename);
        $insertedUser = User::findOrFail($user->id);
        Notification::send($insertedUser, new sendEmailNotification($details));

        return redirect()->back()->with('success', 'User Added Successfully and Password sent to '.$input['email']);
    }

    public function update(Request $request, User $user)
    {
        if ($request->filled(['password', 'password_confirmation', 'current_password'])) {
            if ($request->password == $request->password_confirmation && Hash::check($request->current_password, auth()->user()->password)) {
                $request->validate([
                    'password' => ['required', 'confirmed', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*#?&]/', Rules\Password::defaults()],
                ]);
            } else {
                return redirect()->back()->with('error', 'Either current password is incorrect or password confirmation failed');
            }
            $input = Hash::make($request->password);
            $user->update([
                'password' => $input,
            ]);

            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login');
        } else {
            $request->validate([
                'surname' => ['required', 'string', 'max:255'],
                'first_name' => ['required', 'string', 'max:255'],
                'title' => ['required', 'string', 'max:6'],
                'contact' => ['string', 'max:20'],
                'is_active' => ['required', 'integer', 'max:3'],
                'avatar' => ['image', 'mimes:jpg,png', 'max:200'],
            ]);
            $input = $request->all();
            $storagePath1 = storage_path('app/public/').$user->avatar;
            $storagePath2 = storage_path('app/public/').$user->signature;

            $photoPath = '';
            $signaturePath = '';

            if ($request->hasFile('avatar') && $request->hasFile('signature')) {
                $request->validate(['avatar' => 'image']);
                $photoName = date('YmdHis').$request->emp_id.'.'.$request->file('avatar')->extension();
                $signatureName = date('YmdHis').$request->emp_id.'.'.$request->file('signature')->extension();
                $photoPath = $request->file('avatar')->storeAs('photos', $photoName, 'public');
                $signaturePath = $request->file('signature')->storeAs('signatures', $signatureName, 'public');
                if (file_exists($storagePath1) || file_exists($storagePath2)) {
                    @unlink($storagePath1);
                    @unlink($storagePath2);
                }

                $user->update([

                    'surname' => $input['surname'],
                    'first_name' => $input['first_name'],
                    'other_name' => $input['other_name'],
                    'username' => $input['surname'],
                    'email' => $input['email'],
                    'title' => $input['title'],
                    'contact' => $input['contact'],
                    'facility_id' => $input['facility_id'],
                    'department_id' => $input['department_id'],
                    'designation_id' => $input['designation_id'],
                    'avatar' => $photoPath,
                    'signature' => $signaturePath,
                    'is_active' => $input['is_active'],
                ]);
            } elseif ($request->hasFile('avatar')) {
                $request->validate(['avatar' => 'image']);
                $photoName = date('YmdHis').$request->emp_id.'.'.$request->file('avatar')->extension();
                $photoPath = $request->file('avatar')->storeAs('photos', $photoName, 'public');
                $signaturePath = $user->signature;

                if (file_exists($storagePath1)) {
                    @unlink($storagePath1);
                }
                $user->update([

                    'surname' => $input['surname'],
                    'first_name' => $input['first_name'],
                    'other_name' => $input['other_name'],
                    'name' => $input['surname'],
                    'email' => $input['email'],
                    'title' => $input['title'],
                    'contact' => $input['contact'],
                    'facility_id' => $input['facility_id'],
                    'department_id' => $input['department_id'],
                    'designation_id' => $input['designation_id'],
                    'avatar' => $photoPath,
                    'is_active' => $input['is_active'],
                ]);
            } elseif ($request->hasFile('signature')) {
                $signatureName = date('YmdHis').$request->emp_id.'.'.$request->file('signature')->extension();
                $signaturePath = $request->file('signature')->storeAs('signatures', $signatureName, 'public');
                $photoPath = $user->photo;
                if (file_exists($storagePath2)) {
                    @unlink($storagePath2);
                }
                $user->update([

                    'surname' => $input['surname'],
                    'first_name' => $input['first_name'],
                    'other_name' => $input['other_name'],
                    'name' => $input['surname'],
                    'email' => $input['email'],
                    'title' => $input['title'],
                    'contact' => $input['contact'],
                    'facility_id' => $input['facility_id'],
                    'department_id' => $input['department_id'],
                    'designation_id' => $input['designation_id'],
                    'signature' => $signaturePath,
                    'is_active' => $input['is_active'],
                ]);
            } else {
                $photoPath = $user->avatar;
                $signaturePath = $user->signature;
                $user->update([

                    'surname' => $input['surname'],
                    'first_name' => $input['first_name'],
                    'other_name' => $input['other_name'],
                    'name' => $input['surname'],
                    'email' => $input['email'],
                    'title' => $input['title'],
                    'contact' => $input['contact'],
                    'facility_id' => $input['facility_id'],
                    'department_id' => $input['department_id'],
                    'designation_id' => $input['designation_id'],
                    'signature' => $signaturePath,
                    'avatar' => $photoPath,
                    'is_active' => $input['is_active'],
                ]);
            }

            return redirect()->back()->with('success', 'User Updated Successfully');
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $user = User::create([

            'surname' => 'Auto',
            'first_name' => 'Lab',
            'other_name' => 'API',
            'name' => 'Auto Lab',
            'email' => 'autolab@crs.co.ug',
            'password' => Hash::make('autolab@2023'),
            'title' => 'Mr',
            'contact' => '073373737',
            'facility_id' => '26',
            'department_id' => '2',
            'designation_id' => '4',
            'is_active' => '1',
         ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['data' => $user,'access_token' => $token, 'token_type' => 'Bearer', ]);
    }
}
