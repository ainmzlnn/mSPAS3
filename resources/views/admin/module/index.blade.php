@extends('layouts.master')
@section('title','Academic Module')
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
        <button type="button" class="btn btn-success float-left">
            <i class="fa fa-plus"></i>&nbsp;<a href="{{ route('modules.create') }}" style="color: white; ">Add</a></button>
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
        <table class="table table projects">
            <thead style="background-color: white;">
                <tr>
                    <th class="text">Subject</th>
                    <th class="text">Age</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody style="background-color: #F3CAB0;">
                @forelse ( $modules as $module )
                <tr>
                    <td class="">{{ $module->subject->name }}</td>
                    <td class="">{{ $module->age->name }}</td>
                    <td class="text-center">
                        <a class="btn btn-info btn-sm" href="{{ route('modules.edit', $module) }}">
                            <i class="fas fa-folder"></i>&nbsp;View
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center">No module found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>



</section>


@endsection