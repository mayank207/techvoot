 <!--begin::Aside Toolbarl-->
 <div class="aside-toolbar flex-column-auto" id="kt_aside_toolbar">
     <!--begin::User-->
     <div class="aside-user d-flex align-items-sm-center justify-content-center py-5">
         <!--begin::Symbol-->

         <!--end::Symbol-->
         <!--begin::Wrapper-->
         <div class="aside-user-info flex-row-fluid flex-wrap ms-5">
             <!--begin::Section-->
             <div class="d-flex">
                 <!--begin::Info-->
                 <div class="flex-grow-1 me-2">
                     <!--begin::Username-->
                     <a href="Javascript:;" class="text-white text-hover-primary fs-6 fw-bold">{{ Auth::user()->name; }}</a>
                     <!--end::Username-->
                     <!--begin::Description-->
                     <span class="text-gray-600 fw-bold d-block fs-8 mb-1">{{ Auth::user()->email; }}</span>
                     <!--end::Description-->
                 </div>
                 <!--end::Info-->
                 <!--begin::User menu-->
                 <div class="me-n2">
                 </div>
                 <!--end::User menu-->
             </div>
             <!--end::Section-->
         </div>
         <!--end::Wrapper-->
     </div>
     <!--end::User-->
     <!--end::Aside user-->
 </div>
 <!--end::Aside Toolbarl-->
 <!--begin::Aside menu-->
 <div class="aside-menu flex-column-fluid">
     <!--begin::Aside Menu-->
     <div class="hover-scroll-overlay-y px-2 my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true"
         data-kt-scroll-height="auto"
         data-kt-scroll-dependencies="{default: '#kt_aside_toolbar, #kt_aside_footer', lg: '#kt_header, #kt_aside_toolbar, #kt_aside_footer'}"
         data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="5px">
         <!--begin::Menu-->
         <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
             id="#kt_aside_menu" data-kt-menu="true">
             <div class="menu-item">
                 <a class="menu-link {{getActiveClass(['home'])}}" href="{{ route('home') }}">
                     <span class="menu-icon">
                         <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                         <span class="fas fa-home"></span>
                         <!--end::Svg Icon-->
                     </span>
                     <span class="menu-title">Summery</span>
                 </a>
             </div>
             @if(auth::user()->is_admin == 1)
            <div class="menu-item ">
                <a class="menu-link {{getActiveClass(['users'])}}" href="{{ route('users.index') }}">
                    <span class="menu-icon">
                        <span class="fas fa-address-card"></span>
                    </span>
                    <span class="menu-title">Users</span>
                </a>
            </div>
            @endif

            <div class="menu-item {{getActiveClass(['logout'])}}">
                <a class="menu-link" href="{{ route('logout') }}">
                    <span class="menu-icon">
                        <span class="far fa-question-circle"></span>
                    </span>
                    <span class="menu-title">Logout</span>
                </a>
            </div>
         </div>
         <!--end::Menu-->
     </div>
     <!--end::Aside Menu-->
 </div>
