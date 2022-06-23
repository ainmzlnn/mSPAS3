@extends('layouts.master')
@section('title','View Profile')
@section('content')

<!-- <body> -->

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
            <h3 class="card-title">Account Holder Information</h3>
        </div>
        <div class="card-body box-profile">
            <div class="text-center">
                <img class="img-fluid img-circle" src="{{$user->picture}}" style="width: 180px; height:180px" id='image_preview' alt="User profile picture">
            </div>
            <br>
            <form class="form-horizontal" action="{{ route('users.update',$user) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <div class="custom-file text-center">
                        <input type="file" accept="image/*" name="fileToUpload" value="{{$user->picture}}" id="inputImage" onchange="loadFile(event)" />
                    </div>
                </div>
                <div class="form-group">
                    <label>Account Type:</label>
                    <select name="role" class="form-control role-selector" data-parent="parent-info" required>
                        <option value="parent" @if($user->hasRole('parent')) selected @endif>Parent</option>
                        <option value="teacher" @if($user->hasRole('teacher')) selected @endif>Teacher</option>
                    </select>
                </div>
                <div class="form-group row">
                    <label for="inputName" class="col-sm-3 col-form-label">Name:</label>
                    <div class="col-sm-9">
                        <input name="name" type="text" class="form-control" id="inputMatricNo" value="{{$user->name}}" placeholder="" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputTelefon" class="col-sm-3 col-form-label">Phone No.: </label>
                    <div class="col-sm-9">
                        <input name="phone" type="text" class="form-control" id="inputName" value="{{$user->phone}}" placeholder="" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail" class="col-sm-3 col-form-label">Email:</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" id="inputemail" name="email" value="{{$user->email}}" placeholder="" required>
                    </div>
                </div>

                <hr style="width:50%;text-align:left;margin-left:0">
                <div class="parent-info {{ $user->hasRole('parent') ? '' : 'd-none' }}">
                    <h3 class="card-title">Parents/Guardian Information</h3>
                    <br>
                    <br>
                    <div class="form-group row">
                        <label for="inputName2" class="col-sm-3 col-form-label">Father/Guardian Name:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputemail" name="father_name" value="{{$user->father_name}}" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail2" class="col-sm-3 col-form-label">Father/Guardian Email:</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="inputemail" name="father_email" value="{{$user->father_email}}" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputTelefon" class="col-sm-3 col-form-label">Father/Guardian Phone:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputemail" name="father_phone" value="{{$user->father_phone}}" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputName3" class="col-sm-3 col-form-label">Mother/Guardian Name:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputemail" name="mother_name" value="{{$user->mother_name}}" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-3 col-form-label">Mother/Guardian Email:</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="inputemail" name="mother_email" value="{{$user->mother_email}}" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputTelefon3" class="col-sm-3 col-form-label">Mother/Guardian Phone:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputemail" name="mother_phone" value="{{$user->mother_phone}}" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputAlamat" class="col-sm-3 col-form-label">Address: </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputalamat" name="address" value="{{$user->address}}" placeholder="">
                        </div>
                    </div>
                </div>
                {{-- Teacher Info --}}
                <div class="teacher-info {{ $user->hasRole('teacher') ? '' : 'd-none' }}">
                    <h3 class="card-title">Teacher Information</h3>
                    <br>
                    <br>
                    {{-- Class --}}
                    <div class="form-group row">
                        <label for="inputName2" class="col-sm-3 col-form-label">Class:</label>
                        <div class="col-sm-9">
                            <select name="class_id" class="form-control">
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                    <option value="{{$class->id}}" @if($user->class_id == $class->id) selected @endif>{{$class->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <input type="submit" value="Update" class="btn btn-warning">
                    {{-- <input type="submit" value="Delete" class="btn btn-danger"> --}}
                </div>
            </form>
        </div>
    </div>

    @if($user->hasRole('parent'))
    <br>
    <br>
    <a href="{{ route('users.student.create', $user) }}" class="btn btn-success float-right">
        <i class="fa fa-plus"></i>&nbsp; Add
    </a>
    <br>
    <br>
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Student Information</h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped projects">
                <thead>
                    <tr>
                        <th style="width: 10%" class="text-center">ID</th>
                        <th style="width: 10%" class="text-center">Name</th>
                        <th style="width: 10%" class="text-center">Class</th>
                        <th style="width: 10%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($user->students as $student)
                    <tr>
                        <td style="width: 10%" class="text-center">{{$student->id}}</td>
                        <td style="width: 10%" class="text-center">{{$student->name}}</td>
                        <td class="project-state">{{$student->class->name}}</td>
                        <td style="width: 10%" class="text-center">
                            <a class="btn btn-info btn-sm" href="{{route('students.edit', $student)}}">
                                <i class="fas fa-folder"></i>&nbsp;View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td>No students.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
        let roleSelector = document.querySelector('.role-selector');
        let parentInfo = document.querySelector('.parent-info');
        let teacherInfo = document.querySelector('.teacher-info');

        roleSelector.addEventListener('change', function() {
            if (this.value == 'parent') {
                parentInfo.classList.remove('d-none');
                teacherInfo.classList.add('d-none');
            } else if (this.value == 'teacher') {
                parentInfo.classList.add('d-none');
                teacherInfo.classList.remove('d-none');
            } else {
                parentInfo.classList.add('d-none');
                teacherInfo.classList.add('d-none');
            }
        });
    });

    function readURL(input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $(previewId).css('background-image', 'url(' + e.target.result + ')');
                $(previewId).hide();
                $(previewId).fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    var loadFile = function(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('image_preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
        document.getElementById('image_preview').innerText = event.target.files[0]['name'];
    };
</script>
@endpush