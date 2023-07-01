<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('email','!=','super-admin@makadi-heights.com')->get();

        if (Auth::user()->hasRole('manager')) {
            $users = User::where('manager_id',Auth::user()->id)->with('users')->get();
        }

        $count = count($users);

        return view('users.index', compact('users', 'count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('name','!=','super admin')
        // ->where('name','!=','makadi-admin')
        // ->where('name','!=','finance')
        ->pluck('name');

        $managers = "";

        if (Auth::user()->hasRole('manager')) {
            $roles = Role::where('name','sales')->pluck('name');
        }

        if (Auth::user()->hasRole('makadi-admin') || Auth::user()->hasRole('makadi-super-admin')) {
            // $roles = Role::where('name','sales')->orWhere('name','manager')->pluck('name');
            $managers = User::with("roles")->whereHas("roles", function($q) {
                $q->whereIn("name", ["manager"]);
            })->get();
        }

        return view('users.create', compact('roles','managers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
                'ends_with:orascomdh.com,orascomhd.com,makadiheights.com'
            ],
            'manager' => ['required_if:role,sales'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        if (Auth::user()->hasRole('manager')) {
            $user->syncRoles('sales');
            $user->manager_id = Auth::user()->id;
            $user->save();
        }
        elseif (Auth::user()->hasRole('makadi-admin') || Auth::user()->hasRole('super admin') || Auth::user()->hasRole('makadi-super-admin')) {
            $user->syncRoles($request->role);
            if ($user->hasRole('sales')) {
                $user->manager_id = $request->manager;
            }
            $user->save();
        }
        else {
            $user->syncRoles($request->role);
        }

        return redirect()
            ->route('users')
            ->with('status', 'User Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $user = User::findOrFail($request->id);

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $user = User::findOrFail($request->id);
        $roles = Role::where('name','!=','super admin')
        // ->where('name','!=','makadi-admin')
        // ->where('name','!=','finance')
        ->pluck('name');

        $managers = "";

        if (Auth::user()->hasRole('manager')) {
            $roles = Role::where('name','sales')->pluck('name');
        }

        if (Auth::user()->hasRole('makadi-admin') || Auth::user()->hasRole('makadi-super-admin')) {
            // $roles = Role::where('name','sales')->orWhere('name','manager')->pluck('name');
            $managers = User::with("roles")->whereHas("roles", function($q) {
                $q->whereIn("name", ["manager"]);
            })->get();
        }
        return view('users.edit', compact('user','roles','managers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = User::findOrFail($request->id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email,'.$user->id,
                'ends_with:orascomdh.com,orascomhd.com,makadiheights.com'
            ],
            'manager' => ['required_if:role,sales'],
            'password' => ['confirmed'],
        ]);
        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            // 'password' => Hash::make($request->password),
        ]);

        if (isset($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        if (Auth::user()->hasRole('manager')) {
            $user->syncRoles('sales');
            $user->manager_id = Auth::user()->id;
            $user->save();
        }
        elseif (Auth::user()->hasRole('makadi-admin') || Auth::user()->hasRole('super admin') || Auth::user()->hasRole('makadi-super-admin')) {
            $user->syncRoles($request->role);
            if ($user->hasRole('sales')) {
                $user->manager_id = $request->manager;
            }
            $user->save();
        }
        else {
            $user->syncRoles($request->role);
        }

        if (!$user->hasRole('sales')) {
            $user->manager_id = null;
            $user->save();
        }

        return redirect()
            ->route('users')
            ->with('status', 'User Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = User::findOrFail($request->id);

        $user->delete();

        return redirect()
            ->route('users')
            ->with('status', 'User Deleted Successfully');
    }

    public function showWhatsNew(Request $request) {
        $minutes = 60;
        setcookie("whats_new", true, time() + 3600);
        return view('dashboard');
    }

    public function unSetCookie(Request $request)
    {
        setcookie("whats_new", false, time() + 3600);
        // $minutes = 60;
        return view('dashboard');
    }
}
