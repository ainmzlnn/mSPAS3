<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index(Request $request)
    {
        $teachers = User::whereHas("roles", function($q){ $q->where("name", "teacher"); })->count();
        $parents = User::whereHas("roles", function($q){ $q->where("name", "parent"); })->count();
        $students = Student::count();

        return view('shared.dashboard.index', compact('teachers', 'parents', 'students'));
    }


    /**
     * Write code on Method
     *
     * @return \Illuminate\Http\JsonResponse()
     */
    public function calender(Request $request) {
        if ($request->ajax()) {
            $data = Event::whereDate('start', '>=', $request->start)
                ->whereDate('end',   '<=', $request->end)
                ->get(['id', 'title', 'start', 'end']);

            return response()->json($data);
        }
        return abort(404);
    }

    /**
     * Write code on Method
     *
     * @return \Illuminate\Http\JsonResponse()
     */
    public function ajax(Request $request)
    {
        switch ($request->type) {
            case 'add':
                $event = Event::create([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                ]);

                return response()->json($event);
                break;

            case 'update':
                $event = Event::find($request->id)->update([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                ]);

                return response()->json($event);
                break;

            case 'delete':
                $event = Event::find($request->id)->delete();

                return response()->json($event);
                break;

            default:
                # code...
                break;
        }
    }

}
