@extends('layouts.master')
@section('title','Account List')
@section('content')
<style>
    table {
        border-collapse: separate;
        border-spacing: 0 20px;
    }

    tr {
        border-radius: 10px;
    }
</style>

<!-- <section class="content"> -->
<!-- <div> -->
<div>
    <a class="btn btn-success float-left" href="{{ route('users.create') }}"><i class="fas fa-plus"></i>&nbsp;Register</a>
    <nav class="nav nav-pills justify-content-end">
        <a class="nav-item nav-link {{ (request()->query('role') !== 'teacher' && request()->query('role') !== 'parent') ? 'active' : null}}" id="nav-all-tab" data-toggle="tab" href="?role=all" aria-controls="nav-all" aria-selected="{{(request()->query('role') !== 'teacher' && request()->query('role') !== 'parent') ? 'true': 'false'}}">All</a>
        <a class="nav-item nav-link {{ request()->query('role') === 'teacher' ? 'active' : null}}" id="nav-teacher-tab" data-toggle="tab" href="?role=teacher" aria-controls="nav-teacher" aria-selected="{{request()->query('role') === 'teacher' ? 'true': 'false'}}">Teacher</a>
        <a class="nav-item nav-link {{ request()->query('role') === 'parent' ? 'active' : null}}" id="nav-parent-tab" data-toggle="tab" href="?role=parent" aria-controls="nav-teacher" aria-selected="{{request()->query('role') === 'parent' ? 'true': 'false'}}">Parent</a>
    </nav>
</div>

<div>
    <!-- <br> -->
    <!-- <div class="container-fluid"> -->

    <!-- </div> -->
    <!-- <div class="container-fluid"> -->
    <table class="table projects" id="nav-teacher-tab">
        <thead style="background-color: white;">
            <tr>
                <th style="width: 10%" class="text-center">Name</th>
                <th style="width: 10%" class="text-center">Email</th>
                <th style="width: 10%" class="text-center">Phone No.</th>
                <th style="width: 10%" class="text-center">Account Type</th>
                <!-- <th style="width: 10%" class="text-center">Class</th> -->
                <th style="width: 10%" class="text-center">Action</th>
            </tr>
        </thead>

        <tbody style="background-color: #F3CAB0;">
            @forelse ($users as $user)
            <tr>
                <td class="text-center">{{ $user->name }}</td>
                <td class="project-state">{{ $user->email }}</td>
                <td class="text-center">{{ $user->phone }}</td>
                <td class="text-center">{{ $user->hasRole('teacher') ? 'Teacher' : 'Parent' }}</td>
                <!-- <td class="text-center">{{ $user->class->name ?? 'N/A' }}</td> -->
                <td class="text-center">
                    <a class="btn btn-info btn-sm" href="{{ route('users.edit', $user->id) }}"><i class="fas fa-folder"></i>&nbsp;View</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">No data found</td>
            </tr>
            @endforelse
        </tbody>


    </table>
    <!-- </div> -->
</div>
<!-- </div> -->
<!-- </section> -->

@endsection