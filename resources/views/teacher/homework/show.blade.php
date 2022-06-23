@extends('layouts.master')
@section('title','Assessing Homework')
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

<div>
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
    <table class="table table projects">
        <thead style="background-color: white;">
            <tr>
                <th style="width: 10%" class="text-center">Student</th>
                <th style="width: 10%" class="text-center">Class</th>
                <th style="width: 10%" class="text-center">Due date</th>
                <th style="width: 10%" class="text-center">Submission</th>
                <th style="width: 10%" class="text-center">Feedback</th>
                <th style="width: 10%" class="text-center">Comment</th>
                <th style="width: 10%" class="text-center">Marks</th>
                <th style="width: 10%" class="text-center">Action</th>
            </tr>
        </thead>
        <tbody style="background-color: white;">
            @foreach($homework->students as $student)
            @forelse($student->submissions as $submission)
            @if($submission->grade === NULL)
            <form class="content" method="POST" action="{{ route('homeworks.mark', $submission) }}"
                enctype="multipart/form-data">
                @csrf
                @endif
                <tr>
                    <td style="width: 10%" class="">{{ $student->name}}</td>
                    <td style="width: 10%" class="">{{ $homework->class->name}}</td>
                    <td style="width: 10%" class="text-center">{{ $homework->to->format('d-m-Y')}}</td>
                    <td style="width: 10%" class="text-center">
                        <a class="btn btn-info" href="{{ $submission->file}}" download="homework"
                            target="_blank">Download</a>
                    </td>
                    <td style="width: 10%" class="text-center">
                        @if($submission->feedback === NULL)
                        <input name="feedback" type="file" class="form-control" id="file"
                            accept="image/*, application/pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                            required>
                        @else
                        <a class="btn btn-info" href="{{ $submission->feedback}}" download="feedback"
                            target="_blank">Download</a>
                        @endif
                    </td>
                    <td style="width: 10%" class="text-center">
                        <input name="comment" type="text" class="form-control" id="exampleInput" placeholder="comment"
                            value="{{$submission->comment}}" {{ $submission->grade ? 'readonly disabled' : NULL }}>
                    </td>
                    <td style="width: 10%" class="text-center">
                        <input name="grade" type="text" class="form-control" id="exampleInput" placeholder="/10"
                            value="{{$submission->grade}}" {{ $submission->grade ? 'readonly disabled' : NULL }}
                        required>
                    </td>
                    <td style="width: 10%" class="text-center">
                        @if($submission->grade)
                        <span class="badge badge-success">Graded</span>
                        @else
                        <button type="submit" class="btn btn-success float-right">Submit</button>
                        @endif
                    </td>
                </tr>
            </form>
            @empty
            <tr>
                <td style="width: 10%" class="">{{ $student->name}}</td>
                <td style="width: 10%" class="">{{ $homework->class->name}}</td>
                <td style="width: 10%" class="text-center">{{ $homework->to->format('d-m-Y')}}</td>
                <td style="width: 10%" class="text-center">
                    <span class="badge badge-danger">No submission</span>
                </td>
                <td style="width: 10%" class="text-center">
                    <input name="file" type="file" class="form-control" id="exampleInput" placeholder="">
                </td>
                <td style="width: 10%" class="text-center">
                    <input name="comment" type="text" class="form-control" id="exampleInput" placeholder="comment">
                </td>
                <td style="width: 10%" class="text-center">
                    <input name="grade" type="text" class="form-control" id="exampleInput" placeholder="/10">
                </td>
                <td style="width: 10%" class="text-center">
                    <span class="badge badge-danger">Not submitted</span>
                </td>
            </tr>
            @endforelse
            @endforeach
        </tbody>
    </table>
</div>
</section>

@endsection