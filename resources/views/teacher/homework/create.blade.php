@extends('layouts.master')

@section('title','Add Homework')
@section('content')

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
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Add New Homework</h3>
            </div>

            <form action="{{ route('homeworks.store') }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label>Subject <span aria-hidden="true" class="text-danger">*</span></label>
                        <select class="form-control" name="subject_id" required>
                            @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName">Description <span aria-hidden="true" class="text-danger">*</span></label>
                        <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputDateBeri">Date Given <span aria-hidden="true"
                                                                           class="text-danger">*</span></label>
                        <input name="from" type="date" class="form-control" value="{{ old('from') }}" min="2018-01-01"
                               max="2023-12-31">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputDateHantar">Due Date <span aria-hidden="true"
                                                                           class="text-danger">*</span></label>
                        <input name="to" type="date" class="form-control" value="{{ old('to') }}" min="2018-01-01" max="2023-12-31">
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success float-right">Submit</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
