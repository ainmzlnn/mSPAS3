@extends('layouts.master')
@section('title','Homework List')
@section('content')
<style>
    table {
        border-collapse: separate;
        border-spacing: 0 20px;
    }

    tr {
        border-radius: 10px
    }
</style>

<section class="content">
    <div>
        <table class="table table projects">
            <thead style="background-color: white;">
                <tr>
                    <th style="width: 10%" class="text-center">Student</th>
                    <th style="width: 10%" class="text-center">Subject</th>
                    <th style="width: 10%" class="text-center">Due Date</th>
                    <th style="width: 10%" class="text-center">Status</th>
                    <th style="width: 10%" class="text-center">Grade</th>
                    <th style="width: 10%" class="text-center">Action</th>
                </tr>
            </thead>

            <tbody class=" border border-info" style="background-color: white;">
                @foreach($students as $student)
                @foreach($student->homeworks as $homework)
                <tr>
                    <td style="width: 10%" class="">{{ $student->name }}</td>
                    <td style="width: 10%" class="">{{ $homework->subject->name }}</td>
                    <td style="width: 10%" class="text-center">{{ $homework->to->format('d/m/Y') }}</td>
                    <td style="width: 10%" class="text-center">
                        @if($student->hasSubmitted($homework))
                        <span class="badge badge-success">Submitted</span>
                        @else
                        <span class="badge badge-danger">Not Submitted</span>
                        @endif
                    </td>
                    <td style="width: 10%" class="text-center">
                        @if($student->isGraded($homework))
                        <span class="badge badge-success">Graded</span>
                        @else
                        <span class="badge badge-danger">Not Graded</span>
                        @endif
                    </td>
                    <td style="width: 10%" class="text-center">
                        <a class="btn btn-info btn-sm" href="{{ route('homeworks.edit', [$homework, $student]) }}">
                            <i class="fas fa-folder"></i>&nbsp;View
                        </a>
                    </td>
                </tr>
                @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection