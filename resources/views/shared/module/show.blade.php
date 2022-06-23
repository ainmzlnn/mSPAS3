@extends('layouts.master')

@section('title', auth()->user()->hasRole('teacher') ? 'Grading Student Academic' :'Academic Progress')
@section('content')
<!-- <body> -->

<section class="content">
    <div class="col-md-7 offset-md-2">
        @if($errors->any())
        <div class="alert alert-danger">
            <h5><i class="icon fas fa-ban"></i> Error!</h5>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </div>
        @endif
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <h5><i class="icon fas fa-check"></i> Success!</h5>
            <p>{{ $message }}</p>
        </div>
        @endif
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">{{ auth()->user()->hasRole('teacher') ? "Grading Student's Academical Progress" :
                    "Academic Progress" }}</h3>
            </div>
            <div class="card-body box-profile">

                @if(auth()->user()->hasRole('teacher'))
                <form class="form-horizontal" method="post" action="{{ route('modules.grade', [$module, $student]) }}">
                    @csrf
                    @endif
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Month</label>
                                <input type="text" class="form-control" placeholder="" name="" value="{{ $module->month->name }}" readonly>
                            </div>
                        </div>
                    </div>
                    @forelse($module->progresses as $progress)
                    @if(auth()->user()->hasRole('teacher'))
                    <input type="hidden" name="progresses[{{$loop->iteration}}][id]" value="{{ $progress->id }}">
                    @endif
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Progress {{ $loop->iteration }}</label>
                                <textarea class="form-control" name="progress[]" readonly disabled>{{ $progress->progress }}</textarea></div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Percentage</label>
                                <input type="text" class="form-control" placeholder="" name="progresses[{{$loop->iteration}}][progress]" value="{{ $progress? $student->getProgress($progress)->progress :'' }}" {{
                                    auth()->user()->hasRole('teacher') ? '' : 'readonly disabled' }}>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group" style="text-align: center;">
                                <label>Target</label>
                                <input style="text-align: center;" type="text" class="form-control" value="{{ $progress->target->name }}" name="target[]" readonly disabled>
                            </div>
                        </div>
                    </div>
                    @empty
                    {{-- Empty state --}}
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>No data found!</strong>
                    </div>
                    @endforelse
                    @if(auth()->user()->hasRole('teacher'))
                    <div class="text-right">
                        <input type="submit" value="Generate" class="btn btn-success">
                    </div>
                    @endif
                </form>
            </div>
        </div>

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Student Academic Progress</h3>
            </div>
            <div class="card-body box-profile">
                <br>
                <div class="container">
                    <div class="row"><br />
                        <div class="col-md-12">
                            <div class="progress">
                                <div class="one primary-color"></div>
                                <div class="two primary-color"></div>
                                <div class="three no-color"></div>
                                @php
                                $percent = $student->getTotalModuleScore($module);
                                $class= $percent >= 100 ? 'success' : 'orange';
                                @endphp
                                <div class="progress-bar bg-{{$class}}" style="width: {{$percent}}%;"></div>
                            </div>
                            <small>{{$percent}}% Complete</small>
                        </div>
                    </div>
                </div>
                <a class="btn btn-secondary float-right" target="_blank" href="{{ route('modules.print', ['student' => $student, 'module' => $module]) }}">
                    Print
                </a>
            </div>
        </div>

        <!-- <a class="btn btn-secondary float-right" target="_blank"
            href="{{ route('modules.print', ['student' => $student, 'module' => $module]) }}">
            Print
        </a> -->
    </div>

</section>
@endsection