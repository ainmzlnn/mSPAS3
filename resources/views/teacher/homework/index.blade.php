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
                    <th style="width: 10%" class="text-center">Class</th>
                    <th style="width: 10%" class="text-center">Subject</th>
                    <th style="width: 10%" class="text-center">Date Given</th>
                    <th style="width: 10%" class="text-center">Due Date</th>
                    <th style="width: 10%" class="text-center">Submitted</th>
                    <th style="width: 10%" class="text-center">Action</th>
                </tr>
            </thead>

            <tbody style="background-color: white;">
                @forelse ($homeworks as $homework)
                <tr>
                    <td style="width: 10%" class="text-center">{{ $homework ->class->name }}</td>
                    <td style="width: 10%" class="text-center">{{ $homework ->subject->name }}</td>
                    <td style="width: 10%" class="text-center">{{ $homework ->from->format('d-m-Y') }}</td>
                    <td style="width: 10%" class="text-center">{{ $homework ->to->format('d-m-Y') }}</td>
                    <td style="width: 20%" class="text-center"><span
                            class="badge badge-{{$homework->submissionRate() < 1 ? 'danger' : 'success'}}">{{$homework->current_status}}</span>
                    </td>
                    <td style="width: 10%" class="text-center">
                        <a class="btn btn-info btn-sm" href="{{ route('homeworks.show', $homework) }}">
                            <i class="fas fa-folder"></i>&nbsp;View
                        </a>
                        <a class="btn btn-warning btn-sm" href="{{ route('teacher.homeworks.edit', $homework) }}">
                            &nbsp;Edit
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No Homework</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <br>
    <a class="btn btn-success float-right" href="{{ route('homeworks.create') }}" style="color: white; "><i
            class="fa fa-plus"></i>&nbsp;Add</a>
</section>

@endsection