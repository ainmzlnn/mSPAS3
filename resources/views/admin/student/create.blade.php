@extends('layouts.master')

@section('title','Add Student')
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
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <h5><i class="icon fas fa-check"></i> Success!</h5>
            <p>{{ $message }}</p>
        </div>
        @endif
        <div class="card card-outline">
            <div class="card-header bg-info">
                <h3 class="card-title">Student Personal Information</h3>
            </div>
            <!-- Form Maklumat Peribadi Pelajar -->
            <div class="card-body card-block col-sm-12">
                <form action="{{ route('users.student.store', $user) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-group">
                        <div class="custom-file text-center">
                            <input type="file" accept="image/*" name="picture" id="inputImage"
                                onchange="loadFile(event)" />
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label class=" form-control-label">Name:</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" id="nama-pelajar" name="name" placeholder="" class="form-control"
                                required="" value="{{ old('name') }}">
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
                                <option value="{{$age->id}}" @if(old('age_id')==$age->id) selected
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
                                <option value="{{$class->id}}" @if(old('class_id')==$class->id) selected
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
                                        class="form-check-input" required="" {{ old('gender_id') == $gender->id ? 'checked' :NULL}}>{{$gender->name}} &nbsp;
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
                                required="">{{ old('address') }}</textarea>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="select" class=" form-control-label">Race:</label>
                        </div>
                        <div class="col-12 col-md-3">
                            <select name="race_id" id="select" class="form-control" required="">
                                @foreach($races as $race)
                                <option value="{{$race->id}}" @if(old('race_id')==$race->id) selected  @endif>{{$race->name}}</option>
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
                                <option value="{{$religion->id}}" @if(old('religion_id')==$religion->id) selected
                                    @endif>{{$religion->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- Submit button form -->
                    <div class="card-footer" style="text-align: right;">
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fa fa-dot-circle-o"></i> Save
                        </button>
                    </div>
                </form>
            </div>
            <!-- End of Form Maklumat Peribadi Pelajar -->
        </div>
    </div>
</section>
@endsection