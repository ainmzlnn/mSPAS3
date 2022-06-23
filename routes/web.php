<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FullCalenderController;
use App\Http\Controllers\HomeworkController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::redirect('/', '/login');

Auth::routes(['register' => false]);

Route::middleware('auth')->group(function () {
    Route::get('/home', [DashboardController::class, 'index'])->name('home');

    Route::group(['middleware' => ['role:admin']], function () {
        Route::resource('/users', UserController::class)->except('show');
        Route::get('/users/{user}/student', [StudentController::class, 'create'])->name("users.student.create");
        Route::post('/users/{user}', [StudentController::class, 'store'])->name("users.student.store");

        Route::post('/calender', [DashboardController::class, 'ajax'])->name('calender.ajax');
    });
    Route::group(['middleware' => ['role:admin|parent']], function () {
        Route::resource('students', StudentController::class)->only(['index', 'edit', 'update']);
    });

    Route::group(['middleware' => ['role:teacher|parent']], function () {
        Route::resource('homeworks', HomeworkController::class)->only(['index', 'create', 'store', 'show']);
        Route::get('/homeworks/{homework}/edit', [HomeworkController::class, 'teacherEdit'])->name("teacher.homeworks.edit");
        Route::post('/homeworks/{homework}', [HomeworkController::class, 'teacherUpdate'])->name("teacher.homeworks.update");
        Route::get('/homeworks/{homework}/student/{student}', [HomeworkController::class, 'edit'])->name('homeworks.edit');
        Route::post('/homeworks/{homework}/student/{student}', [HomeworkController::class, 'update'])->name('homeworks.update');
        Route::post('/homeworks/{homeworkSubmission}/mark', [HomeworkController::class, 'mark'])->name('homeworks.mark');
        Route::get('/modules/{student}/print/{module?}', [ModuleController::class, 'print'])->name('modules.print');
    });

    Route::resource('/modules', ModuleController::class)->except('show');
    Route::get('/modules/{module}/student/{student}', [ModuleController::class, 'show'])->name('modules.show');
    Route::post('/modules/{module}/student/{student}', [ModuleController::class, 'storeGrade'])->name('modules.grade');
    Route::get('/calender', [DashboardController::class, 'calender'])->name('calender.show');

    Route::get('/create', function () {
        return view('admin.class.create');
    });

    Route::get('/edit', function () {
        return view('admin.class.edit');
    });
});
