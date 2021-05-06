<?php

namespace App\Http\Controllers;

use App\Log;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role_id !== 3) {
            return redirect()->route('orders.index');
        }
        $users = User::all();

        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->role_id !== 3) {
            return redirect()->route('orders.index');
        }
        $roles = Role::all();
        return view('user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->role_id !== 3) {
            return redirect()->route('orders.index');
        }
        $validatedData = $request->validate([
            'name' => 'required|min:3|max:50',
            'surname' => 'required|min:3|max:50',
            'email' => 'required|email',
            'username' => 'required',
            'role_id' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);
        $validatedData['password'] = Hash::make($validatedData['password']);
        $create = User::create($validatedData);

        Log::createLog('user', Auth::user()->username . ' created user, id: ' . $create->id);

        return redirect('/users')->with('success', 'User was successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->role_id !== 3) {
            return redirect()->route('orders.index');
        }
        $user = User::findOrFail($id);
        $roles = Role::all();

        return view('user.edit', compact('user', 'roles'));
    }

    /**
     * Show the form for editing current user
     *
     * @return \Illuminate\Http\Response
     */
    public function editSelf()
    {
        $user = Auth::user();
        $roles = Role::all();

        return view('user.editself', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateSelf(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|min:3|max:50',
            'surname' => 'required|min:3|max:50',
            'password_old' => 'required',
            'password' => 'sometimes|confirmed|min:6|nullable',
        ]);
        if (!isset($validatedData['password']) || empty($validatedData['password'])) {
            unset($validatedData['password']);
        } else {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }
        if (Hash::check($validatedData['password_old'], Auth::user()->password)) {
            unset($validatedData['password_old']);
            User::whereId(Auth::user()->id)->update($validatedData);

            Log::createLog('user', Auth::user()->username . ' updated his own info, id: ' . Auth::user()->id);

            return redirect('/orders')->with('success', 'Settings were successfully updated');
        }

        return redirect()->back()->withErrors(['password_old'=>'Password is invalid']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->role_id !== 3) {
            return redirect()->route('orders.index');
        }
        $validatedData = $request->validate([
            'name' => 'required|min:3|max:50',
            'surname' => 'required|min:3|max:50',
            'role_id' => 'required',
            'password' => 'sometimes|confirmed|min:6|nullable',
        ]);
        if (!isset($validatedData['password']) || empty($validatedData['password'])) {
            unset($validatedData['password']);
        } else {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }
        User::whereId($id)->update($validatedData);

        Log::createLog('user', Auth::user()->username . ' updated user, id: ' . $id);

        return redirect('/users')->with('success', 'User was successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->role_id !== 3) {
            return redirect()->route('orders.index');
        }
        $user = User::findOrFail($id);
        $user->delete();

        Log::createLog('user', Auth::user()->username . ' deleted user, id: ' . $id);

        return redirect('/users')->with('success', 'User was successfully deleted');
    }
}
