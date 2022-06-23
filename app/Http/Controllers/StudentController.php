<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Age;
use App\Models\Classes;
use App\Models\Gender;
use App\Models\Race;
use App\Models\Religion;
use App\Models\Student;
use App\Models\User;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $students = auth()->user()->hasRole('parent') ? auth()->user()->students() : Student::query();

        $students = $students->when(request('class'), function ($query) {
            $query->whereHas('class', function ($query) {
                $query->where('name', request('class'));
            });
        })->get();

        $classes = Classes::has('students')->get();
        return view('shared.student.index', compact('students', 'classes'));
    }

    public function create(User $user)
    {
        $classes = Classes::all();
        $ages =  Age::all();
        $genders = Gender::all();
        $races = Race::all();
        $religions = Religion::all();
        return view('admin.student.create', compact('user', 'genders', 'races', 'religions', 'classes', 'ages'));
    }

    public function store(StoreStudentRequest $request, User $user)
    {
        $student = Student::create(array_merge($request->validated(), ['parent_id' => $user->id]));

        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('images', 'public');
            $student->forceFill([
                'picture' => $path,
            ])->save();
        }

        return redirect()->route('users.edit', $user)->with('success', 'Student created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Student $student)
    {
        $classes = Classes::all();
        $ages =  Age::all();
        $genders = Gender::all();
        $races = Race::all();
        $religions = Religion::all();
        return view('shared.student.edit', compact('student', 'classes', 'ages', 'genders', 'races', 'religions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStudentRequest  $request
     * @param  \App\Models\Student                      $student
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        $student->update($request->validated());

        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('images', 'public');
            $student->forceFill([
                'picture' => $path,
            ])->save();
        }

        return redirect()->back()->with('success', 'Student details updated successfully.');
    }
}
