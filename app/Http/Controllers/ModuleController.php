<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreModuleRequest;
use App\Models\Age;
use App\Models\Module;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Month;
use App\Models\Target;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        if (!$request->age || $request->age == '')
            return redirect()->route('modules.index',['age'=>'4 Years Old']);

        $ages = Age::has('modules')->get();

        $role = auth()->user()->roles()->first()->name;
        $withRelations = $this->getWithRelations($role);

        $modules = Module::with($withRelations)
            ->when(
                $this->isValidAge($request),
                function ($query) use ($request) {
                    $query->whereHas('age', function ($query) use ($request) {
                        $query->where('name', $request->age);
                    });
                }
            )->get();
        return view($role . '.module.index', compact('modules', 'ages'));
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return bool
     */
    public function isValidAge(Request $request): bool
    {
        return $request->age && Age::where('name', $request->age)->exists();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreModuleRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreModuleRequest $request)
    {
        $module = Module::create($request->validated());
        $validProgresses = array_filter($request->progress, function ($progress) {
            return $progress['progress'] !== null && $progress['progress'] !== '' && $progress['target_id'] !== null && $progress['target_id'] !== '';
        });

        $module->progresses()->createMany($validProgresses);

        return redirect()->route('modules.index')->with('success', 'Module has been added successfully.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $ages = Age::all();
        $targets = Target::all();
        $subjects = Subject::all();
        $months = Month::all();
        return view('admin.module.edit', compact('subjects', 'ages', 'targets', 'months'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Module  $module
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Module $module)
    {
        $ages = Age::all();
        $targets = Target::all();
        $subjects = Subject::all();
        $months = Month::all();
        return view('admin.module.edit', compact('subjects', 'ages', 'targets', 'module', 'months'));
    }

    public function storeGrade(Request $request, Module $module, Student $student)
    {
        $validated = $request->validate([
            'progresses.*.id' => ['nullable', 'exists:module_progress,id'],
            'progresses.*.progress' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ]);

        $last = 100;
        foreach ($validated['progresses'] as $progress) {
            if ($progress['progress'] && $last < 100) {
                return redirect()->back()->withErrors(['progresses' => 'Progresses must be in ascending order.']);
            }
        }

        foreach ($validated['progresses'] as $progress) {
            if ($progress['progress']) {
                $student->moduleProgress()->updateOrCreate(
                    ['progress_id' => $progress['id']],
                    ['progress' => $progress['progress']]
                );
            }
        }

        return redirect()->route('modules.index')->with('success', 'Module has been added successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreModuleRequest  $request
     * @param  \App\Models\Module                     $module
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreModuleRequest $request, Module $module)
    {
        $module->update($request->validated());
        $module->progresses()->delete();
        $module->progresses()->createMany($this->getValidProgress($request));

        return redirect()->route('modules.index')->with('success', 'Module has been updated successfully.');
    }

    public function show(Module $module, Student $student)
    {
        $module->load('progresses');
        return view('shared.module.show', compact('module', 'student'));
    }

    /**
     * @param $role
     *
     * @return string[]
     */
    public function getWithRelations($role): array
    {
        $withRelations = ['subject', 'age'];
        if ($role === 'parent') {
            $withRelations = ['subject', 'age', 'progresses'];
        }
        if ($role === 'teacher') {
            $withRelations = ['subject', 'age', 'progresses', 'students'];
        }
        return $withRelations;
    }

    /**
     * @param  \App\Http\Requests\StoreModuleRequest  $request
     *
     * @return mixed
     */
    public function getValidProgress(StoreModuleRequest $request)
    {
        return array_filter($request->progress, function ($progress) {
            return $progress['progress'] !== null && $progress['progress'] !== '' && $progress['target_id'] !== null && $progress['target_id'] !== '';
        });
    }

    public function print(Student $student, Module $module = null) {
        return view('shared.module.print', compact('student', 'module'));
    }
}
