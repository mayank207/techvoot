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
                                <form class="form" action="{{route('users.store')}}" id="edit_users_form" method="post" enctype="multipart/form-data">
                                    @csrf
                                     <!--first Name -->
                                    <div class="fv-row mb-4">
                                        <label class="required fs-6 fw-bold mb-2">Name</label>
                                        <input type="text" class="form-control form-control-solid" id="name" placeholder="" value="{{old('name')}}" name="name"/>
                                        @if ($errors->has('name'))
                                        <div class="error">
                                            <strong>{{ $errors->first('name') }}</strong></div>
                                        @endif
                                    </div>
                                    <!-- end-first Name -->
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

                                    <!-- Email -->
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
                                    <!--end-Email -->

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