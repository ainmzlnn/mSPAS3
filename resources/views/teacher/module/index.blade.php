@extends('layouts.master')
@section('title','Student Academic Progress')
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
        <nav class="nav nav-pills justify-content-end">
            <!-- <a class="nav-item nav-link {{ ( !request()->query('age') || request()->query('age') == '' || request()->query('age') == 'all') ? 'active' : null}}"
                id="nav-all-tab" data-toggle="tab" href="?age=all" aria-controls="nav-all"
                aria-selected="{{ (!request()->query('age') || request()->query('age') == '') ? 'true': 'false'}}">All</a> -->

            @foreach ( $ages as $age )
            <a class="nav-item nav-link {{ ( request()->query('age')  == $age->name) ? 'active' : null}}" id="nav-{{$age->name}}-tab" data-toggle="tab" href="?age={{$age->name}}" aria-controls="nav-{{$age->name}}" aria-selected="{{ ( request()->query('age')  == $age->name) ? 'true': 'false'}}">{{ $age->name }}</a>
            @endforeach
        </nav>
    </div>
    <div>
        <table class="table table-striped projects">
            <thead style="background-color: white;">
                <tr>
                    <th style="width: 10%" class="text">Subject</th>
                    <!-- <th style="width: 10%" class="text">Class</th> -->
                </tr>
            </thead>
            <tbody>
                @forelse($modules as $module)
                <tr data-widget="expandable-table" aria-expanded="false">
                    <td style="background-color: #F3CAB0;">
                        <i class="expandable-table-caret fas fa-caret-right fa-fw"></i>{{ $module->subject->name }}
                    </td>
                </tr>
                <tr class="expandable-body" style="background-color: white;">
                    <td>
                        <div class="p-0">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th>Class</th>
                                        <th>Updated Date</th>
                                        <th>Progress</th>
                                        <th class="text-center">Percentage</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($module->students as $student)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->class->name }}</td>
                                        <td>{{ $student->updated_at->format('d/m/Y') }}</td>
                                        <td>
                                            @php
                                            $progress = $student->getTotalModuleScore($module) ?? 0 ;
                                            $class = $progress >= 100 ? 'success' : 'orange';
                                            @endphp
                                            <div class="progress progress-xs">
                                                <div class="progress-bar bg-{{$class}}" style="width: {{ $progress }}%">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-{{$class}}">{{ $student->getTotalModuleScore($module)
                                                ??
                                                '0' }}%</span>
                                        </td>
                                        <td style="width: 10%" class="align-center">
                                            <a class="btn btn-info btn-sm" href="{{ route('modules.show', [$module, $student]) }}">
                                                <i class="fas fa-folder">
                                                </i>
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <h5>No data</h5>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>No data found!</strong>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection