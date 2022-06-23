<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $users = User::withoutAdmins()
            ->when(($request->role && in_array($request->role, ['teacher', 'parent'])),
                function ($query) use ($request) {
                    $query->role($request->role);
                }
            )->get();

        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(User $user)
    {
        $classes = Classes::all();
        return view('admin.user.edit', compact('user', 'classes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User                      $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());

        if ($request->hasFile('fileToUpload')) {
            $path = $request->file('fileToUpload')->store('images', 'public');
            $user->update(['picture' => $path]);
        }

        if ($request->role !== 'teacher' && $user->hasRole('teacher')) {
            $user->forceFill([
                'class_id' => NULL
            ])->save();
        }
        if ($request->role !== 'parent' && $user->hasRole('parent')) {
            $user->students()->delete();
        }

        $user->roles()->detach();
        $user->assignRole($request->role);

        return redirect()->route('users.edit', $user->id)->with(
            'success',
            'Your profile has been updated successfully.'
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();
        $validated["password"] = Hash::make($validated["password"]);
        $user = User::create($validated);
        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'Account has been added successfully.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $classes = Classes::all();
        return view('admin.user.create', compact('classes'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Account has been deleted successfully.');
    }
}
