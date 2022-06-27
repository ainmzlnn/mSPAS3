@extends('layouts.master')
@section('title','Student Information')
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
        @if(auth()->user()->hasRole('admin'))
        <nav class="nav nav-pills justify-content-end">
            <a class="nav-item nav-link {{ "all" === request('class', 'all' ) ? 'active' : '' }} " href="
                {{route('students.index')}}">All</a>
            @foreach($classes as $class)
            <a class="nav-item nav-link {{ $class->name == request('class') ? 'active' : '' }}" href="{{route('students.index', ['class' => $class->name])}}">{{$class->name}}</a>
            @endforeach
        </nav>
        @endif
    </div>
    <!-- <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Senarai Kanak-Kanak</h3>
        </div> -->
    <!-- /.card-header -->
    <!-- Default box -->
    <div>
        <table class="table table projects">
            <thead style="background-color: white;">
                <tr>
                    <th style="width: 10%" class="">
                        Student Name
                    </th>
                    <th style="width: 10%" class="text-center">
                        Class
                    </th>
                    <th style="width: 10%" class="text-center">
                        Action
                    </th>
                </tr>
            </thead>

            <tbody style="background-color: #F3CAB0;">
                @forelse ($students as $student)
                <tr>
                    <td style="width: 10%" class="">
                        {{$student->name}}
                    </td>
                    <td style="width: 10%" class="text-center">
                        {{$student->class->name}}
                    </td>
                    <td style="width: 10%" class="text-center">
                        <a class="btn btn-info btn-sm" href="{{ route('students.edit', $student) }}">
                            <i class="fas fa-folder">
                            </i>
                            View
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center">
                        No data
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- <body> -->
    <!-- /.content -->
</section>

<!-- </body> -->
@endsection