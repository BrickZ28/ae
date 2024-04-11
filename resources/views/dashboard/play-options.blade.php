<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('dashboard.partials._head')
</head>

<body id="kt_app_body" class="app-default">
<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card body-->
            <div class="card-body">
                <!--begin::Heading-->
                <div class="card-px text-center pt-15 pb-15">
                    <!--begin::Title-->
                    <h2 class="fs-2x fw-bold mb-0">Selection Required</h2>
                    <!--end::Title-->
                    <!--begin::Description-->
                    <p class="text-gray-500 fs-4 fw-semibold py-7">Click on the below button
                        <br />To select your game and play style
                        <br />This will allow us to properly assign your role and start kit
                    </p>
                    <!--end::Description-->
                    <!--begin::Action-->
                    <a href="#" class="btn btn-primary er fs-6 px-8 py-4" data-bs-toggle="modal" data-bs-target="#kt_modal_select_users">Select Users</a>
                    <!--end::Action-->
                </div>
                <!--end::Heading-->
                <!--begin::Illustration-->
                <div class="text-center pb-15 px-5">
                    <img src="assets/media/illustrations/sketchy-1/20.png" alt="" class="mw-100 h-200px h-sm-325px" />
                </div>
                <!--end::Illustration-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Content container-->
</div>
<!-- App Content -->
<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
    <div class="app-page flex-column flex-row-fluid" id="kt_app_page">
        <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
            <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                <div class="d-flex flex-column flex-column-fluid">
                    <div class="modal fade" id="kt_modal_select_users" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog mw-700px">
                            <!--begin::Modal content-->
                            <div class="modal-content">
                                <!--begin::Modal header-->
                                <div class="modal-header pb-0 border-0 d-flex justify-content-end">
                                    <!--begin::Close-->
                                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                        <i class="ki-duotone ki-cross fs-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </div>
                                    <!--end::Close-->
                                </div>
                                <!--end::Modal header-->
                                <!--begin::Modal body-->
                                <div class="modal-body scroll-y mx-5 mx-xl-10 pt-0 pb-15">
                                    <!--begin::Heading-->
                                    <div class="text-center mb-13">
                                        <!--begin::Title-->
                                        <h1 class="d-flex justify-content-center align-items-center mb-3">Select Game
                                            and Kit Preference</h1>
                                        <!--end::Title-->
                                        <!--begin::Description-->
                                        <div class="text-muted fw-semibold fs-5">You can get kits and roles for other
                                            games and styles from your dashboard after registration.</div>
                                        <!--end::Description-->
                                    </div>
                                    <!--end::Heading-->
                                    <!--begin::Users-->
                                    <div class="mh-475px scroll-y me-n7 pe-7">
                                        <!--begin::User-->
                                        <div class="border border-hover-primary p-7 rounded mb-7">
                                            <!--begin::Info-->
                                            <div class="d-flex flex-stack pb-3">
                                                <!--begin::Info-->
                                                <div class="d-flex">
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-circle symbol-45px">
                                                        <img src="assets/media/avatars/300-20.jpg" alt="" />
                                                    </div>
                                                    <!--end::Avatar-->
                                                    <!--begin::Details-->
                                                    <div class="ms-5">
                                                        <!--begin::Name-->
                                                        <div class="d-flex align-items-center">
                                                            <a href="pages/user-profile/overview.html" class="text-gray-900 fw-bold text-hover-primary fs-5 me-4">Emma Smith</a>
                                                            <!--begin::Label-->
                                                            <span class="badge badge-light-success d-flex align-items-center fs-8 fw-semibold">
												<i class="ki-duotone ki-star fs-8 text-success me-1"></i>Author</span>
                                                            <!--end::Label-->
                                                        </div>
                                                        <!--end::Name-->
                                                        <!--begin::Desc-->
                                                        <span class="text-muted fw-semibold mb-3">Art Director</span>
                                                        <!--end::Desc-->
                                                    </div>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Info-->
                                                <!--begin::Stats-->
                                                <div clas="d-flex">
                                                    <!--begin::Price-->
                                                    <div class="text-end pb-3">
                                                        <span class="text-gray-900 fw-bold fs-5">$75.60</span>
                                                        <span class="text-muted fs-7">/hr</span>
                                                    </div>
                                                    <!--end::Price-->
                                                </div>
                                                <!--end::Stats-->
                                            </div>
                                            <!--end::Info-->
                                            <!--begin::Wrapper-->
                                            <div class="p-0">
                                                <!--begin::Section-->
                                                <div class="d-flex flex-column">
                                                    <!--begin::Text-->
                                                    <p class="text-gray-700 fw-semibold fs-6 mb-4">First, a disclaimer - the entire process writing a blog post often takes more.</p>
                                                    <!--end::Text-->
                                                    <!--begin::Tags-->
                                                    <div class="d-flex text-gray-700 fw-semibold fs-7">
                                                        <!--begin::Tag-->
                                                        <span class="border border-2 rounded me-3 p-1 px-2">Art Director</span>
                                                        <!--end::Tag-->
                                                        <!--begin::Tag-->
                                                        <span class="border border-2 rounded me-3 p-1 px-2">UX</span>
                                                        <!--end::Tag-->
                                                        <!--begin::Tag-->
                                                        <span class="border border-2 rounded me-3 p-1 px-2">Laravel</span>
                                                        <!--end::Tag-->
                                                    </div>
                                                    <!--end::Tags-->
                                                </div>
                                                <!--end::Section-->
                                                <!--begin::Footer-->
                                                <div class="d-flex flex-column">
                                                    <!--begin::Separator-->
                                                    <div class="separator separator-dashed border-muted my-5"></div>
                                                    <!--end::Separator-->
                                                    <!--begin::Action-->
                                                    <div class="d-flex flex-stack">
                                                        <!--begin::Progress-->
                                                        <div class="d-flex flex-column mw-200px">
                                                            <div class="d-flex align-items-center mb-2">
                                                                <span class="text-gray-700 fs-6 fw-semibold me-2">90%</span>
                                                                <span class="text-muted fs-8">Job Success</span>
                                                            </div>
                                                            <div class="progress h-6px w-200px">
                                                                <div class="progress-bar bg-primary" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                        <!--end::Progress-->
                                                        <!--begin::Button-->
                                                        <a href="#" class="btn btn-sm btn-primary">Select</a>
                                                        <!--end::Button-->
                                                    </div>
                                                    <!--end::Action-->
                                                </div>
                                                <!--end::Footer-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </div>
                                        <!--end::User-->
                                        <!--begin::User-->
                                        <div class="border border-hover-primary p-7 rounded mb-7">
                                            <!--begin::Info-->
                                            <div class="d-flex flex-stack pb-3">
                                                <!--begin::Info-->
                                                <div class="d-flex">
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-circle symbol-45px">
                                                        <img src="assets/media/avatars/300-11.jpg" alt="" />
                                                    </div>
                                                    <!--end::Avatar-->
                                                    <!--begin::Details-->
                                                    <div class="ms-5">
                                                        <!--begin::Name-->
                                                        <div class="d-flex align-items-center">
                                                            <a href="pages/user-profile/overview.html" class="text-gray-900 fw-bold text-hover-primary fs-5 me-4">Sean Bean</a>
                                                            <!--begin::Label-->
                                                            <span class="badge badge-light-success d-flex align-items-center fs-8 fw-semibold">
												<i class="ki-duotone ki-star fs-8 text-success me-1"></i>Author</span>
                                                            <!--end::Label-->
                                                        </div>
                                                        <!--end::Name-->
                                                        <!--begin::Desc-->
                                                        <span class="text-muted fw-semibold mb-3">Project Manager</span>
                                                        <!--end::Desc-->
                                                    </div>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Info-->
                                                <!--begin::Stats-->
                                                <div clas="d-flex">
                                                    <!--begin::Price-->
                                                    <div class="text-end pb-3">
                                                        <span class="text-gray-900 fw-bold fs-5">$65.45</span>
                                                        <span class="text-muted fs-7">/hr</span>
                                                    </div>
                                                    <!--end::Price-->
                                                </div>
                                                <!--end::Stats-->
                                            </div>
                                            <!--end::Info-->
                                            <!--begin::Wrapper-->
                                            <div class="p-0">
                                                <!--begin::Section-->
                                                <div class="d-flex flex-column">
                                                    <!--begin::Text-->
                                                    <p class="text-gray-700 fw-semibold fs-6 mb-4">Outlines keep you honest. They stop you from indulging.</p>
                                                    <!--end::Text-->
                                                    <!--begin::Tags-->
                                                    <div class="d-flex text-gray-700 fw-semibold fs-7">
                                                        <!--begin::Tag-->
                                                        <span class="border border-2 rounded me-3 p-1 px-2">HTML</span>
                                                        <!--end::Tag-->
                                                        <!--begin::Tag-->
                                                        <span class="border border-2 rounded me-3 p-1 px-2">Javascript</span>
                                                        <!--end::Tag-->
                                                        <!--begin::Tag-->
                                                        <span class="border border-2 rounded me-3 p-1 px-2">Python</span>
                                                        <!--end::Tag-->
                                                    </div>
                                                    <!--end::Tags-->
                                                </div>
                                                <!--end::Section-->
                                                <!--begin::Footer-->
                                                <div class="d-flex flex-column">
                                                    <!--begin::Separator-->
                                                    <div class="separator separator-dashed border-muted my-5"></div>
                                                    <!--end::Separator-->
                                                    <!--begin::Action-->
                                                    <div class="d-flex flex-stack">
                                                        <!--begin::Progress-->
                                                        <div class="d-flex flex-column mw-200px">
                                                            <div class="d-flex align-items-center mb-2">
                                                                <span class="text-gray-700 fs-6 fw-semibold me-2">58%</span>
                                                                <span class="text-muted fs-8">Job Success</span>
                                                            </div>
                                                            <div class="progress h-6px w-200px">
                                                                <div class="progress-bar bg-success" role="progressbar" style="width: 58%" aria-valuenow="58" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                        <!--end::Progress-->
                                                        <!--begin::Button-->
                                                        <a href="#" class="btn btn-sm btn-primary">Select</a>
                                                        <!--end::Button-->
                                                    </div>
                                                    <!--end::Action-->
                                                </div>
                                                <!--end::Footer-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </div>
                                        <!--end::User-->
                                        <!--begin::User-->
                                        <div class="border border-hover-primary p-7 rounded mb-7">
                                            <!--begin::Info-->
                                            <div class="d-flex flex-stack pb-3">
                                                <!--begin::Info-->
                                                <div class="d-flex">
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-circle symbol-45px">
                                                        <img src="assets/media/avatars/300-2.jpg" alt="" />
                                                    </div>
                                                    <!--end::Avatar-->
                                                    <!--begin::Details-->
                                                    <div class="ms-5">
                                                        <!--begin::Name-->
                                                        <div class="d-flex align-items-center">
                                                            <a href="pages/user-profile/overview.html" class="text-gray-900 fw-bold text-hover-primary fs-5 me-4">Lusy Kunic</a>
                                                            <!--begin::Label-->
                                                            <span class="m-0"></span>
                                                            <!--end::Label-->
                                                        </div>
                                                        <!--end::Name-->
                                                        <!--begin::Desc-->
                                                        <span class="text-muted fw-semibold mb-3">DevOPs</span>
                                                        <!--end::Desc-->
                                                    </div>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Info-->
                                                <!--begin::Stats-->
                                                <div clas="d-flex">
                                                    <!--begin::Price-->
                                                    <div class="text-end pb-3">
                                                        <span class="text-gray-900 fw-bold fs-5">$60,45</span>
                                                        <span class="text-muted fs-7">/hr</span>
                                                    </div>
                                                    <!--end::Price-->
                                                </div>
                                                <!--end::Stats-->
                                            </div>
                                            <!--end::Info-->
                                            <!--begin::Wrapper-->
                                            <div class="p-0">
                                                <!--begin::Section-->
                                                <div class="d-flex flex-column">
                                                    <!--begin::Text-->
                                                    <p class="text-gray-700 fw-semibold fs-6 mb-4">Long before you sit down to put digital pen to paper you need make sure you have to sit down and write.</p>
                                                    <!--end::Text-->
                                                    <!--begin::Tags-->
                                                    <div class="d-flex text-gray-700 fw-semibold fs-7">
                                                        <!--begin::Tag-->
                                                        <span class="border border-2 rounded me-3 p-1 px-2">Figma</span>
                                                        <!--end::Tag-->
                                                        <!--begin::Tag-->
                                                        <span class="border border-2 rounded me-3 p-1 px-2">SASS</span>
                                                        <!--end::Tag-->
                                                        <!--begin::Tag-->
                                                        <span class="border border-2 rounded me-3 p-1 px-2">CSS</span>
                                                        <!--end::Tag-->
                                                    </div>
                                                    <!--end::Tags-->
                                                </div>
                                                <!--end::Section-->
                                                <!--begin::Footer-->
                                                <div class="d-flex flex-column">
                                                    <!--begin::Separator-->
                                                    <div class="separator separator-dashed border-muted my-5"></div>
                                                    <!--end::Separator-->
                                                    <!--begin::Action-->
                                                    <div class="d-flex flex-stack">
                                                        <!--begin::Progress-->
                                                        <div class="d-flex flex-column mw-200px">
                                                            <div class="d-flex align-items-center mb-2">
                                                                <span class="text-gray-700 fs-6 fw-semibold me-2">86%</span>
                                                                <span class="text-muted fs-8">Job Success</span>
                                                            </div>
                                                            <div class="progress h-6px w-200px">
                                                                <div class="progress-bar bg-warning" role="progressbar" style="width: 86%" aria-valuenow="86" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                        <!--end::Progress-->
                                                        <!--begin::Button-->
                                                        <a href="#" class="btn btn-sm btn-primary">Select</a>
                                                        <!--end::Button-->
                                                    </div>
                                                    <!--end::Action-->
                                                </div>
                                                <!--end::Footer-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </div>
                                        <!--end::User-->
                                        <!--begin::User-->
                                        <div class="border border-hover-primary p-7 rounded">
                                            <!--begin::Info-->
                                            <div class="d-flex flex-stack pb-3">
                                                <!--begin::Info-->
                                                <div class="d-flex">
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-circle symbol-45px">
                                                        <img src="assets/media/avatars/300-5.jpg" alt="" />
                                                    </div>
                                                    <!--end::Avatar-->
                                                    <!--begin::Details-->
                                                    <div class="ms-5">
                                                        <!--begin::Name-->
                                                        <div class="d-flex align-items-center">
                                                            <a href="pages/user-profile/overview.html" class="text-gray-900 fw-bold text-hover-primary fs-5 me-4">Mat Dillon</a>
                                                            <!--begin::Label-->
                                                            <span class="m-0"></span>
                                                            <!--end::Label-->
                                                        </div>
                                                        <!--end::Name-->
                                                        <!--begin::Desc-->
                                                        <span class="text-muted fw-semibold mb-3">QA Managers</span>
                                                        <!--end::Desc-->
                                                    </div>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Info-->
                                                <!--begin::Stats-->
                                                <div clas="d-flex">
                                                    <!--begin::Price-->
                                                    <div class="text-end pb-3">
                                                        <span class="text-gray-900 fw-bold fs-5">$70,30</span>
                                                        <span class="text-muted fs-7">/hr</span>
                                                    </div>
                                                    <!--end::Price-->
                                                </div>
                                                <!--end::Stats-->
                                            </div>
                                            <!--end::Info-->
                                            <!--begin::Wrapper-->
                                            <div class="p-0">
                                                <!--begin::Section-->
                                                <div class="d-flex flex-column">
                                                    <!--begin::Text-->
                                                    <p class="text-gray-700 fw-semibold fs-6 mb-4">First, a disclaimer - the entire process writing a blog post often takes more than couple of hours.</p>
                                                    <!--end::Text-->
                                                    <!--begin::Tags-->
                                                    <div class="d-flex text-gray-700 fw-semibold fs-7">
                                                        <!--begin::Tag-->
                                                        <span class="border border-2 rounded me-3 p-1 px-2">Figma</span>
                                                        <!--end::Tag-->
                                                        <!--begin::Tag-->
                                                        <span class="border border-2 rounded me-3 p-1 px-2">SASS</span>
                                                        <!--end::Tag-->
                                                        <!--begin::Tag-->
                                                        <span class="border border-2 rounded me-3 p-1 px-2">CSS</span>
                                                        <!--end::Tag-->
                                                    </div>
                                                    <!--end::Tags-->
                                                </div>
                                                <!--end::Section-->
                                                <!--begin::Footer-->
                                                <div class="d-flex flex-column">
                                                    <!--begin::Separator-->
                                                    <div class="separator separator-dashed border-muted my-5"></div>
                                                    <!--end::Separator-->
                                                    <!--begin::Action-->
                                                    <div class="d-flex flex-stack">
                                                        <!--begin::Progress-->
                                                        <div class="d-flex flex-column mw-200px">
                                                            <div class="d-flex align-items-center mb-2">
                                                                <span class="text-gray-700 fs-6 fw-semibold me-2">70%</span>
                                                                <span class="text-muted fs-8">Job Success</span>
                                                            </div>
                                                            <div class="progress h-6px w-200px">
                                                                <div class="progress-bar bg-danger" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                        <!--end::Progress-->
                                                        <!--begin::Button-->
                                                        <a href="#" class="btn btn-sm btn-primary">Select</a>
                                                        <!--end::Button-->
                                                    </div>
                                                    <!--end::Action-->
                                                </div>
                                                <!--end::Footer-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </div>
                                        <!--end::User-->
                                    </div>
                                    <!--end::Users-->
                                </div>
                                <!--end::Modal Body-->
                            </div>
                            <!--end::Modal content-->
                        </div>
                        <!--end::Modal dialog-->
                    </div>
                    <!-- Main Content -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scrolltop -->
<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true"><i class="ki-duotone ki-arrow-up"></i></div>

<!-- Javascript -->
@include('sweetalert::alert')
@stack('before-scripts')
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
@stack('after-scripts')
@include('dashboard.partials._scripts')

</body>
</html>
