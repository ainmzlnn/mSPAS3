@extends('layouts.master')
@section('title','Homework Submission')
@section('content')

@if($student->canUploadHomework($homework))
<form class="content" method="POST" action="{{ route('homeworks.update', [$homework, $student]) }}"
    enctype="multipart/form-data">
    @csrf
    @endif
    <div>
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Upload Homework</h3>
            </div>
            <div class="card-body my-dropzone">
                <label><strong>Homework Description: </strong></label>
                <p>{{ $homework->description}} </p>
                <br>
                <div id="actions" class="row">
                    <div class="col-lg-6">
                        <div class="btn-group w-50">
                            
                            @if($student->canUploadHomework($homework))
                            <input name="file" type="file" class="form-control" id="exampleInput" placeholder="">
                            @else

                            <a class="btn btn-secondary" href="{{ $student->submission($homework)->file}}"
                                download="homework" target="_blank">Download</a>
                            @endif

                        </div>
                    </div>
                </div>
                @if($student->canUploadHomework($homework))
                <button type="submit" class="btn btn-success float-right">Submit</button>
                @endif
            </div>
        </div>

        @if(!$student->canUploadHomework($homework))
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Teacher Feedback</h3>
            </div>

            <div class="card-body">
                @if($student->isGraded($homework))
                <div id="actions">
                    <div class="col-sm-6">
                        <label>Materials</label>
                        <br>
                        <div class="btn-group w-50">
                            @if($student->hasFeedback($homework))
                            <a class="btn btn-success" href="{{ $student->getFeedback($homework) }}" download="feedback" target="_blank">Download</a>
                            @else
                            <span class="badge badge-danger">No Feedback</span>
                            @endif
                        </div>
                    </div>
                    <br>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Comment</label>
                            @if($student->submission($homework)->comment)
                            <input name="comment" type="text" class="form-control"
                                value="{{$student->submission($homework)->comment}}" reaonly disabled>
                            @else
                            <p>No Comment</p>
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-1">
                        <label>Marks(/10)</label>
                        <input readonly type="text" class="form-control"
                            value="{{$student->submission($homework)->grade}}" readonly disabled>
                    </div>
                </div>
                @else
                <p>Teacher has not given the feedback yet.</p>
                @endif
            </div>

        </div>
        @endif
        @if($student->canUploadHomework($homework))
</form>
@endif

@endsection