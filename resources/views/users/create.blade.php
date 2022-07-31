@extends('layouts.main')
@section('content')
<div class="d-flex flex-column-fluid">
    <div class="container-xxl">
        <!--begin::sub category Row-->
        <div class="row g-xl-8">
            <!--begin:: column-->
            <div class="col-xl-8">
                <!--begin::sub category-->
                <div class="post d-flex flex-column-fluid" id="kt_post">
                    <!--begin::Container-->
                    <div id="kt_content_container" class="container">
                        <!--begin::Card-->
                        <div class="card">
                            <!--begin::Card body-->
                            <div class="card-body">
                                <h3 class="card-title align-items-start flex-column mb-5">
                                    <span class="fw-bolder text-dark">Add User</span>
                                </h3>
                                <form class="form" action="{{route('users.store')}}" id="add_users_form" method="post">
                                    @csrf
                                     <!-- Name -->
                                    <div class="fv-row mb-4">
                                        <label class="required fs-6 fw-bold mb-2">Name</label>
                                        <input type="text" class="form-control form-control-solid" id="name" placeholder="" value="{{old('name')}}" name="name"/>
                                        @if ($errors->has('name'))
                                        <div class="error">
                                            <strong>{{ $errors->first('name') }}</strong></div>
                                        @endif
                                    </div>
                                    <!-- end- Name -->
                                    <!-- Email -->
                                    <div class="fv-row mb-4">
                                        <label class="required fs-6 fw-bold mb-2">
                                            <span >Email</span>
                                        </label>
                                        <input type="email" id="email" class="form-control form-control-solid" value="{{old('email')}}" placeholder="" name="email" />
                                        @if ($errors->has('email'))
                                        <div class="error">
                                            <strong>{{ $errors->first('email') }}</strong></div>
                                        @endif
                                    </div>
                                    <!--end-Email -->

                                    <!-- PAssword -->
                                    <div class="fv-row mb-4">
                                        <label class="required fs-6 fw-bold mb-2">
                                            <span >Password</span>
                                        </label>
                                        <input type="password" id="password" class="form-control form-control-solid" value="{{old('password')}}" placeholder="" name="password" />
                                        @if ($errors->has('password'))
                                        <div class="error">
                                            <strong>{{ $errors->first('password') }}</strong></div>
                                        @endif
                                    </div>
                                    <!--end-PAssword -->

                                    <!-- confirm PAssword -->
                                    <div class="fv-row mb-4">
                                        <label class="required fs-6 fw-bold mb-2">
                                            <span >Confirm Password</span>
                                        </label>
                                        <input type="password" id="confirm_password" class="form-control form-control-solid" value="{{old('confirm_password')}}" placeholder="" name="confirm_password" />
                                        @if ($errors->has('confirm_password'))
                                        <div class="error">
                                            <strong>{{ $errors->first('confirm_password') }}</strong></div>
                                        @endif
                                    </div>
                                    <!--end-confirm PAssword -->

                                    <div class="file-field input-field">

                                        <div class='file-loading'><input id='add_image' name='add_image'
                                                type='file' class='file'></div>
                                        <strong><span class='text-danger' id='error_add_image'> </span></strong>


                                    </div>

                                    <div class="fv-row mb-15">
                                        <!--begin::Button-->
                                        <a href="{{route('users.index')}}" class="btn btn-light me-3">Cancel</a>
                                        <!--end::Button-->
                                        <!--begin::Button-->
                                        <input type="submit" id="edit_users_form_submit" data-kt-banner-action="submit" class="btn btn-primary">
                                            <span class="indicator-progress">Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>

                                    </div>
                                </form>
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::sub category-->
            </div>
            <!--end:: column-->
        </div>
        <!--end::sub category Row-->
    </div>
</div>
@endsection
@section('external-scripts')
<script>
    var id=0;
        $("#add_users_form").validate({
        rules: {
            name: {
                required:true ,
                noSpace:true,
            },
            email: {
                checkemail:true,
				required: true,
				remote: {
                        type: 'post',
                        url: "{{route('user.email_exists')}}",
                        data: {'_token': $("input[name=_token]").val(),id:id},
                        dataFilter: function (data)
                        {
                            var json = JSON.parse(data);
                            if (json.valid === true) {
                                return '"true"';
                            } else {
                                return "\"" + json.message + "\"";
                            }
                        }
                    }

				},
            password:{
                required:true ,
                noSpace:true,
                pwcheck:true,
            },
            confirm_password:{
                required:true ,
                equalTo: "#password",
                noSpace:true,
            }
        },
        messages: {
            name: 'Please enter name',
            email:{
                required:"Please enter email",
                remote:"Email is already exists",
                checkemail:"Please enter valid email",
            },
            password:{
                required:"Please enter password",
            },
            confirm_password:{
                required:"Please enter confirm password",
                equalTo:"password & confirm password are not match"
            }
        },
        submitHandler: function (form) {

            return true;
        },
        success: function(label,element) {
            label.parent().removeClass('has-danger');
        },
    });
</script>
<script>
    $(document).ready(function() {
        $("#add_image").fileinput({
            showCaption: false,
            dropZoneEnabled: false
        });
    });
</script>
@endsection
