@extends('layouts.master')
@section('title','List of Academic Progress')
@section('content')

<style>
    table {
        border-collapse: separate;
        border-spacing: 0 5px;
    }

    tr {
        border-radius: 10px
    }
</style>

<section class="content">


    <div>
        <table class="table table-striped projects">
            <thead style="background-color: white;">
                <tr>
                    <th style="width: 10%" class="text">Student</th>
                </tr>
            </thead>
            <tbody>
                @foreach (auth()->user()->students as $student)
                <tr data-widget="expandable-table" aria-expanded="false">
                    <td style="background-color: #F3CAB0;">
                        <i class="expandable-table-caret fas fa-caret-right fa-fw"></i>{{ $student->name }}
                    </td>
                </tr>
                <tr class="expandable-body" style="background-color: white;">
                    <td>
                        <div class="p-0">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <!-- <th>Student</th> -->
                                        <th>Subject</th>
                                        <th style="width: 10%, text-center;">Updated Date</th>
                                        <th>Progress</th>
                                        <th style="width: 10%">Percentage</th>
                                        <th style="width: 10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($student->modules as $module)
                                    <tr>
                                        <!-- <td>{{$student->name}}</td> -->
                                        <td>{{$module->subject->name}}</td>
                                        <td>{{$module->updated_at}}</td>
                                        <td>
                                            @php
                                            $progress = $student->getTotalModuleScore($module) ?? 0;
                                            $class = $progress >= 100 ? 'success' : 'orange';
                                            @endphp
                                            <div class="progress progress-xs">
                                                <div class="progress-bar bg-{{$class}}" style="width: {{ $progress }}%">
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{$class}}">{{ $student->getTotalModuleScore($module) ?? '0' }}%</span>
                                        </td>
                                        <td style="width: 10%" class="text-center">
                                            <a class="btn btn-info btn-sm" href="{{ route('modules.show', [$module, $student]) }}">
                                                <i class="fas fa-folder">
                                                </i>
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr style="width: 10%" class="text-center">
                                        <a class="btn btn-secondary float-right" target="_blank" href="{{ route('modules.print', $student) }}">
                                            Print
                                        </a>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
                <!-- <body> -->
                <!-- /.content -->
                @endforeach
            </tbody>
        </table>
</section>

<!-- </body> -->
@endsection
