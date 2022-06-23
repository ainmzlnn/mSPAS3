@extends('layouts.master')
@section('title','Register Account')
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
                <h3 class="card-title">Register New Account</h3>
            </div>

            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                @method('POST')
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Account Type <span aria-hidden="true" class="text-danger">*</span></label>
                            <select class="form-control role-selector" name="role" required>
                                <option value="parent" {{ old('role')=='parent' ? 'selected' : '' }}>Parent</option>
                                <option value="teacher" {{ old('role')=='teacher' ? 'selected' : '' }}>Teacher</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputName">Name <span aria-hidden="true"
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="exampleInputName" value="{{ old('name') }}"
                                name="name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Email address <span aria-hidden="true"
                                    class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="" value="{{ old('email') }}" name="email"
                                required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputPhone">Phone No. <span aria-hidden="true"
                                    class="text-danger">*</span></label>
                            <input type="tel" class="form-control" id="exampleInputPhone" value="{{ old('phone') }}"
                                name="phone" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Password <span aria-hidden="true"
                                    class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="" name="password" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Password confirmation <span aria-hidden="true"
                                    class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="" name="password_confirmation">
                        </div>
                    </div>

                    {{-- Optional --}}
                    <fieldset class="border p-2 parent-input {{ old('role') == 'parent' ? '' : 'd-none' }}">
                        <legend class="col-form-label col-sm-2 pt-0 font-weight-bold">Parent only</legend>
                        <div class="row">
                            {{-- father name --}}
                            <div class="form-group col-md-6">
                                <label for="exampleInputFatherName">Father's Name</label>
                                <input type="text" class="form-control" id="exampleInputFatherName"
                                    value="{{ old('father_name') }}" name="father_name">
                            </div>
                            {{-- father email --}}
                            <div class="form-group col-md-6">
                                <label for="exampleInputFatherEmail">Father's Email</label>
                                <input type="email" class="form-control" id="exampleInputFatherEmail"
                                    value="{{ old('father_email') }}" name="father_email">
                            </div>
                            {{-- Father tel --}}
                            <div class="form-group col-md-6">
                                <label for="exampleInputFatherPhone">Father's Phone No.</label>
                                <input type="tel" class="form-control" id="exampleInputFatherPhone"
                                    value="{{ old('father_phone') }}" name="father_phone">
                            </div>

                            {{-- Mother name --}}
                            <div class="form-group col-md-6">
                                <label for="exampleInputMotherName">Mother's Name</label>
                                <input type="text" class="form-control" id="exampleInputMotherName"
                                    value="{{ old('mother_name') }}" name="mother_name">
                            </div>

                            {{-- Mother email --}}
                            <div class="form-group col-md-6">
                                <label for="exampleInputMotherEmail">Mother's Email</label>
                                <input type="email" class="form-control" id="exampleInputMotherEmail"
                                    value="{{ old('mother_email') }}" name="mother_email">
                            </div>

                            {{-- Mother tel --}}
                            <div class="form-group col-md-6">
                                <label for="exampleInputMotherPhone">Mother's Phone No.</label>
                                <input type="tel" class="form-control" id="exampleInputMotherPhone"
                                    value="{{ old('mother_phone') }}" name="mother_phone">
                            </div>

                            {{-- address --}}
                            <div class="form-group col-md-6">
                                <label for="exampleInputAddress">Address</label>
                                <textarea class="form-control" id="exampleInputAddress" value="{{ old('address') }}"
                                    name="address">
                                </textarea>
                            </div>
                        </div>
                    </fieldset>
                    {{-- Optional for teacher --}}
                    <fieldset class="border p-2 teacher-input {{ old('role') == 'teacher' ? '' : 'd-none' }}">
                        <legend class="col-form-label col-sm-2 pt-0 font-weight-bold">Teacher only</legend>
                        <div class="row">
                            {{-- Class --}}
                            <div class="form-group col-md-6">
                                <label for="exampleInputClass">Class</label>
                                <select class="form-control" id="exampleInputClass" name="class_id">
                                    <option value="">Select Class</option>
                                    @foreach ($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('class')==$class->id ? 'selected' : '' }}>{{
                                        $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</section>
{{-- push to stack script --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let roleSelector = document.querySelector('.role-selector');
        let parentInput = document.querySelector('.parent-input');
        let teacherInput = document.querySelector('.teacher-input');

        if(roleSelector.value == 'parent'){
        parentInput.classList.remove('d-none');
        }else if(roleSelector.value == 'teacher'){
        teacherInput.classList.remove('d-none');
        }
        roleSelector.addEventListener('change', function () {
            parentInput.classList.toggle('d-none');
            teacherInput.classList.toggle('d-none');
        });
    });
</script>
@endpush
@endsection