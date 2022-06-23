@extends('layouts.master')

@section('title','Add Class Information')
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
                <h3 class="card-title">Class Information</h3>
            </div>
            <!-- Form Maklumat Peribadi Pelajar -->
            <div class="card-body card-block col-sm-12">
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <!-- <div class="form-group">
                        <div class="custom-file text-center">
                            <input type="file" accept="image/*" name="picture" id="inputImage"
                                onchange="loadFile(event)" />
                        </div>
                    </div> -->

                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label class=" form-control-label">Teacher:</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <select name="name_id" id="select" class="form-control" required="">
                                <!-- <option value="0" hidden="">Please select</option> -->

                                <option value="Mrs. Fatima" selected>Mrs. Fatima</option>
                                <option value="Miss Aisya">Miss Aisya</option>
                                <option value="Mr. John ">Mr. John</option>

                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label class=" form-control-label">Age: </label>
                        </div>
                        <div class="col-md-3">
                            <select name="age_id" id="select" class="form-control" required="">
                                <!-- <option value="0" hidden="">Please select</option> -->

                                <option value="4 Years Old" selected>4 Years Old</option>
                                <option value="5 Years Old">5 Years Old</option>
                                <option value="6 Years Old">6 Years Old</option>

                            </select>
                        </div>
                        <div class="col-md-3" style="text-align: right;">
                            <label class=" form-control-label">Class: </label>
                        </div>
                        <div class="col-md-3">
                            <select name="class_id" id="select" class="form-control" required="">
                                <!-- <option value="0" hidden="">Please select</option> -->

                                <option value="4 Orchid" selected>4 Orchid</option>
                                <option value="4 Sunflower" selected>4 Sunflower</option>
                                <option value="4 Daisy" selected>4 Daisy</option>
                                <option value="5 Orchid" selected>5 Orchid</option>
                                <option value="5 Sunflower" selected>5 Sunflower</option>
                                <option value="5 Daisy" selected>5 Daisy</option>
                                <option value="6 Orchid" selected>6 Orchid</option>
                                <option value="6 Sunflower" selected>6 Sunflower</option>
                                <option value="6 Daisy" selected>6 Daisy</option>
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