@extends('layouts.master')
@section('title','Edit Student Information')
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
            <h3 class="card-title">Student Information</h3>
        </div>
        <div class="card-body box-profile">
            <div class="text-center">
                <img class="img-fluid img-circle" src="{{$student->picture}}" style="width: 180px; height:180px"
                    id='image_preview' alt="User profile picture">
            </div>
            <br>
            <form class="form-horizontal" action="{{ route('students.update',$student) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <div class="custom-file text-center">
                        <input type="file" accept="image/*" name="picture" id="inputImage" onchange="loadFile(event)" />
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col col-md-3">
                        <label class=" form-control-label">Name:</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" id="nama-pelajar" name="name" placeholder="" class="form-control"
                            value="{{$student->name}}" required>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-3">
                        <label class=" form-control-label">Age: </label>
                    </div>
                    <div class="col-md-3">
                        <select name="age_id" id="select" class="form-control" required="">
                            <!-- <option value="0" hidden="">Please select</option> -->
                            @foreach($ages as $age)
                            <option value="{{$age->id}}" @if($student->age_id == $age->id) selected
                                @endif>{{$age->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3" style="text-align: right;">
                        <label class=" form-control-label">Class: </label>
                    </div>
                    <div class="col-md-3">
                        <select name="class_id" id="select" class="form-control" required="">
                            <!-- <option value="0" hidden="">Please select</option> -->
                            @foreach($classes as $class)
                            <option value="{{$class->id}}" @if($student->class_id == $class->id) selected
                                @endif>{{$class->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label class=" form-control-label">Gender: </label>
                    </div>
                    <div class="col col-md-9">
                        <div class="form-check-inline form-check">
                            @foreach($genders as $gender)
                            <label for="inline-radio1" class="form-check-label ">
                                <input type="radio" id="inline-radio1" name="gender_id" value="{{$gender->id}}"
                                    class="form-check-input" required="" {{ $student->gender_id === $gender->id ?
                                'checked' : null }}>{{$gender->name}}
                                &nbsp;
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="textarea-input" class=" form-control-label">Address:</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <textarea name="address" id="textarea-input" rows="5" placeholder="" class="form-control"
                            required="">{{$student->address}}</textarea>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="select" class=" form-control-label">Race:</label>
                    </div>
                    <div class="col-12 col-md-3">
                        <select name="race_id" id="select" class="form-control" required="">
                            @foreach($races as $race)
                            <option {{$student->race_id === $race->id ? 'selected' : null}}
                                value="{{$race->id}}">{{$race->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col col-md-3" style="text-align: right;">
                        <label for="select" class=" form-control-label">Religion:</label>
                    </div>
                    <div class="col-12 col-md-3">
                        <select name="religion_id" id="select" class="form-control" required="">
                            <!-- <option value="0" hidden="">Please select</option> -->
                            @foreach($religions as $religion)
                            <option {{$student->religion_id === $religion->id ? 'selected' : null}}
                                value="{{$religion->id}}">{{$religion->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="text-center">
                    <input type="submit" value="Update" class="btn btn-warning">
                    {{-- <input type="submit" value="Delete" class="btn btn-danger"> --}}
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    function readURL(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(previewId).css('background-image', 'url(' + e.target.result + ')');
                    $(previewId).hide();
                    $(previewId).fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        var loadFile = function (event) {
            var reader = new FileReader();
            reader.onload = function () {
                var output = document.getElementById('image_preview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
            document.getElementById('image_preview').innerText = event.target.files[0]['name'];
        };
        // $(document).ready(function(){
        //     $('#inputImage').change(function(){
        //         readURL(this,'#image_preview')
        //     })
        // })
</script>
@endpush