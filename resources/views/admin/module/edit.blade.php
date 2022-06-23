@extends('layouts.master')

@php
$action = Request::route()->getName() == 'modules.create' ? 'Add' : 'Edit';
@endphp

@section('title',$action.' New Academic Module')
@section('content')

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
            <h3 class="card-title">{{$action}} Module</h3>
        </div>
        <div class="card-body box-profile">
            <form class="form-horizontal" action=" {{ $action == 'Add' ? route('modules.store') : route('modules.update', $module) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method( $action == 'Add' ? 'POST' : 'PUT')
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label>Month</label>
                            <select name="month_id" id="select" class="form-control" required="">
                                <option value="">Select Month</option>
                                @foreach($months as $month)
                                <option value="{{$month->id}}" {{ (($action=='Add' ? old('month_id') : $module->month_id
                                    )==$month->id) ? 'selected' : '' }}>{{$month->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Age</label>
                            <select name="age_id" class="form-control" required="">
                                @foreach($ages as $age)
                                <option value="{{$age->id}}" {{ (($action=='Add' ? old('age_id') : $module->age_id
                                )==$age->id) ? 'selected' : '' }}>{{$age->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Subject</label>
                            <select name="subject_id" class="form-control" required="">
                                @foreach($subjects as $subject)
                                <option value="{{$subject->id}}" {{ (($action=='Add' ? old('subject_id') : $module->
                                subject_id) == $subject->id) ? 'selected' : '' }}>{{$subject->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                @for ($i = 1; $i <= 4; $i++) <div class="row">
                    <div class="col-sm-7">
                        <div class="form-group">
                            <label>Progress {{$i}}:</label>
                            <textarea name="progress[{{$i}}][progress]" class="form-control" placeholder="Progress {{$i}}">{{$action=='Add' ? old('progress['.$i.'][progress]') : $module->progresses[$i-1]['progress'] ?? NULL}}</textarea></div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Target</label>
                            <select name="progress[{{$i}}][target_id]" class="form-control">
                                <option></option>
                                @foreach($targets as $target)
                                <option value="{{$target->id}}" {{ (($action=='Add' ? old('progress['.$i.'][target_id]')
                                    : $module->progresses[$i-1]['target_id'] ?? NULL) == $target->id) ? 'selected' : ''
                                    }}>{{$target->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
        </div>
        @endfor
        <div class="text-center">
            <input type="submit" value="{{ $action == 'Add' ? $action : 'Update' }}" class="btn {{$action != 'Add' ? 'btn-warning' : 'btn-success'}}">
        </div>
        </form>
    </div>
</div>
</div>
@endsection