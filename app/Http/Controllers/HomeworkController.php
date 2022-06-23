<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHomeworkRequest;
use App\Http\Requests\StoreHomeworkSubmissionRequest;
use App\Models\Classes;
use App\Models\Homework;
use App\Models\HomeworkSubmission;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class HomeworkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        if (auth()->user()->hasRole('parent')) {
            $students = auth()->user()->students()->with(['homeworks' => function ($query) {
                $query->isAvailable()->with('subject');
            }])->get();
            return view('parent.homeworks.index', compact('students'));
        }

        $homeworks = Homework::whereHas('class', function ($query) {
            $query->where('class_id', auth()->user()->class_id);
        })->with(['class', 'subject'])->get();
        return view('teacher.homework.index', compact('homeworks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $subjects = Subject::all();
        return view('teacher.homework.create', compact('subjects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreHomeworkRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreHomeworkRequest $request)
    {
        Homework::create(array_merge($request->validated(), [
            'class_id' => auth()->user()->class_id
        ]));
        return redirect()->route('homeworks.index')->with('success', 'Homework has been added successfully.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function teacherEdit(Homework $homework)
    {
        $subjects = Subject::all();
        $canUpdateMore = $homework->submissions()->count() === 0;
        return view('teacher.homework.edit', compact('homework', 'subjects', 'canUpdateMore'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreHomeworkRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function teacherUpdate(Request $request, Homework $homework)
    {
        $requestValidation = $homework->submissions()->count() > 0 ? ['to' => ['required', 'date']] : [
            'subject_id' => ['required', 'integer', 'exists:subjects,id'],
            'description' => ['required', 'string', 'min:5'],
            'from' => ['required', 'date'],
            'to' => ['required', 'date'],
        ];
        $validated  = $request->validate($requestValidation);
        $homework->update($validated);
        return redirect()->route('homeworks.index')->with('success', 'Homework has been added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Homework  $homework
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Homework $homework)
    {
        $homework->load(['subject', 'class', 'students' => function ($query) use ($homework) {
            $query->with(['submissions' => function ($query) use ($homework) {
                $query->where('homework_id', $homework->id);
            }]);
        }]);

        return view('teacher.homework.show', compact('homework'));
    }

    public function edit(Homework $homework, Student $student)
    {
        $homework->load('class');
        return view('parent.homeworks.edit', compact('student', 'homework'));
    }

    public function update(StoreHomeworkSubmissionRequest $request, Homework $homework, Student $student)
    {
        $path = $request->file('file')->store('homeworks', 'public');
        $homework->submissions()->updateOrCreate([
            'student_id' => $student->id,
        ], [
            'comment' => $request->comment,
            'file' => $path,
        ]);

        return redirect()->route('homeworks.index', [$student, $homework]);
    }

    public function mark(Request $request, HomeworkSubmission $homeworkSubmission)
    {
        $validated = $request->validate([
            'feedback' => ['required', 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx'],
            'comment' => ['nullable'],
            'grade' => ['required'],
        ]);

        if ($request->hasFile('feedback')) {
            $path = $request->file('feedback')->store('feedbacks', 'public');
            $homeworkSubmission->update([
                'feedback' => $path,
            ]);
        }

        $homeworkSubmission->update([
            'comment' => $request->comment,
            'grade' => $request->grade,
        ]);

        return redirect()->back()->with('success', 'Graded successfully.');
    }
}
