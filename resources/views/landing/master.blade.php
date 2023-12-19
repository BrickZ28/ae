<!--begin::Head-->
@include('landing.partials.header-layout._head')
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" data-bs-spy="scroll" data-bs-target="#kt_landing_menu" class="bg-body position-relative">
<!--begin::Theme mode setup on page load-->
@include('landing.partials.header-layout._head-script')
<!--end::Theme mode setup on page load-->
<!--begin::Main-->
<!--begin::Root-->
<div class="d-flex flex-column flex-root">
    <!--begin::Header Section-->

    @include('landing.partials.header-layout._header')
    <!--end::Header Section-->
    <!--begin::How It Works Section-->
    @include('landing.partials.content._rules')
    <!--end::How It Works Section-->
    <!--begin::Statistics Section-->
    <div class="mt-sm-n10">
        <!--begin::Curve top-->
        <div class="landing-curve landing-dark-color">
            <svg viewBox="15 -1 1470 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M1 48C4.93573 47.6644 8.85984 47.3311 12.7725 47H1489.16C1493.1 47.3311 1497.04 47.6644 1501 48V47H1489.16C914.668 -1.34764 587.282 -1.61174 12.7725 47H1V48Z"
                    fill="currentColor"></path>
            </svg>
        </div>
        <!--end::Curve top-->
        <!--begin::Wrapper-->
        @include('landing.partials.content._general_stats')
        <!--end::Wrapper-->
        <!--begin::Curve bottom-->
        <div class="landing-curve landing-dark-color">
            <svg viewBox="15 12 1470 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M0 11C3.93573 11.3356 7.85984 11.6689 11.7725 12H1488.16C1492.1 11.6689 1496.04 11.3356 1500 11V12H1488.16C913.668 60.3476 586.282 60.6117 11.7725 12H0V11Z"
                    fill="currentColor"></path>
            </svg>
        </div>
        <!--end::Curve bottom-->
    </div>
    <!--end::Statistics Section-->
    <!--begin::Team Section-->
    @include('landing.partials.content._serverstats')
    <!--end::Team Section-->
    <!--begin::Projects Section-->
    @include('landing.partials.content._screenshots')
    <!--end::Projects Section-->
    <!--begin::Pricing Section-->
    <div class="mt-sm-n20">
        <!--begin::Curve top-->
        <div class="landing-curve landing-dark-color">
            <svg viewBox="15 -1 1470 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M1 48C4.93573 47.6644 8.85984 47.3311 12.7725 47H1489.16C1493.1 47.3311 1497.04 47.6644 1501 48V47H1489.16C914.668 -1.34764 587.282 -1.61174 12.7725 47H1V48Z"
                    fill="currentColor"></path>
            </svg>
        </div>
        <!--end::Curve top-->
        <!--begin::Wrapper-->
        @include('landing.partials.content._specials')
        <!--end::Wrapper-->
        <!--begin::Curve bottom-->
        <div class="landing-curve landing-dark-color">
            <svg viewBox="15 12 1470 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M0 11C3.93573 11.3356 7.85984 11.6689 11.7725 12H1488.16C1492.1 11.6689 1496.04 11.3356 1500 11V12H1488.16C913.668 60.3476 586.282 60.6117 11.7725 12H0V11Z"
                    fill="currentColor"></path>
            </svg>
        </div>
        <!--end::Curve bottom-->
    </div>
    <!--end::Pricing Section-->
    <!--begin::Testimonials Section-->
{{--    <div class="mt-20 mb-n20 position-relative z-index-2">--}}
{{--        <!--begin::Container-->--}}
{{--        <div class="container">--}}
{{--            <!--begin::Heading-->--}}
{{--            <div class="text-center mb-17">--}}
{{--                <!--begin::Title-->--}}
{{--                <h3 class="fs-2hx text-gray-900 mb-5" id="clients" data-kt-scroll-offset="{default: 125, lg: 150}">What--}}
{{--                    Our Clients Say</h3>--}}
{{--                <!--end::Title-->--}}
{{--                <!--begin::Description-->--}}
{{--                <div class="fs-5 text-muted fw-bold">Save thousands to millions of bucks by using single tool--}}
{{--                    <br/>for different amazing and great useful admin--}}
{{--                </div>--}}
{{--                <!--end::Description-->--}}
{{--            </div>--}}
{{--            <!--end::Heading-->--}}
{{--            <!--begin::Row-->--}}
{{--            <div class="row g-lg-10 mb-10 mb-lg-20">--}}
{{--                <!--begin::Col-->--}}
{{--                <div class="col-lg-4">--}}
{{--                    <!--begin::Testimonial-->--}}
{{--                    <div--}}
{{--                        class="d-flex flex-column justify-content-between h-lg-100 px-10 px-lg-0 pe-lg-10 mb-15 mb-lg-0">--}}
{{--                        <!--begin::Wrapper-->--}}
{{--                        <div class="mb-7">--}}
{{--                            <!--begin::Rating-->--}}
{{--                            <div class="rating mb-6">--}}
{{--                                <div class="rating-label me-2 checked">--}}
{{--                                    <i class="ki-outline ki-star fs-5"></i>--}}
{{--                                </div>--}}
{{--                                <div class="rating-label me-2 checked">--}}
{{--                                    <i class="ki-outline ki-star fs-5"></i>--}}
{{--                                </div>--}}
{{--                                <div class="rating-label me-2 checked">--}}
{{--                                    <i class="ki-outline ki-star fs-5"></i>--}}
{{--                                </div>--}}
{{--                                <div class="rating-label me-2 checked">--}}
{{--                                    <i class="ki-outline ki-star fs-5"></i>--}}
{{--                                </div>--}}
{{--                                <div class="rating-label me-2 checked">--}}
{{--                                    <i class="ki-outline ki-star fs-5"></i>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <!--end::Rating-->--}}
{{--                            <!--begin::Title-->--}}
{{--                            <div class="fs-2 fw-bold text-gray-900 mb-3">This is by far the cleanest template--}}
{{--                                <br/>and the most well structured--}}
{{--                            </div>--}}
{{--                            <!--end::Title-->--}}
{{--                            <!--begin::Feedback-->--}}
{{--                            <div class="text-gray-500 fw-semibold fs-4">The most well thought out design theme I have--}}
{{--                                ever used. The codes are up to tandard. The css styles are very clean. In fact the--}}
{{--                                cleanest and the most up to standard I have ever seen.--}}
{{--                            </div>--}}
{{--                            <!--end::Feedback-->--}}
{{--                        </div>--}}
{{--                        <!--end::Wrapper-->--}}
{{--                        <!--begin::Author-->--}}
{{--                        <div class="d-flex align-items-center">--}}
{{--                            <!--begin::Avatar-->--}}
{{--                            <div class="symbol symbol-circle symbol-50px me-5">--}}
{{--                                <img src="assets/media/avatars/300-1.jpg" class="" alt=""/>--}}
{{--                            </div>--}}
{{--                            <!--end::Avatar-->--}}
{{--                            <!--begin::Name-->--}}
{{--                            <div class="flex-grow-1">--}}
{{--                                <a href="#" class="text-gray-900 fw-bold text-hover-primary fs-6">Paul Miles</a>--}}
{{--                                <span class="text-muted d-block fw-bold">Development Lead</span>--}}
{{--                            </div>--}}
{{--                            <!--end::Name-->--}}
{{--                        </div>--}}
{{--                        <!--end::Author-->--}}
{{--                    </div>--}}
{{--                    <!--end::Testimonial-->--}}
{{--                </div>--}}
{{--                <!--end::Col-->--}}
{{--                <!--begin::Col-->--}}
{{--                <div class="col-lg-4">--}}
{{--                    <!--begin::Testimonial-->--}}
{{--                    <div--}}
{{--                        class="d-flex flex-column justify-content-between h-lg-100 px-10 px-lg-0 pe-lg-10 mb-15 mb-lg-0">--}}
{{--                        <!--begin::Wrapper-->--}}
{{--                        <div class="mb-7">--}}
{{--                            <!--begin::Rating-->--}}
{{--                            <div class="rating mb-6">--}}
{{--                                <div class="rating-label me-2 checked">--}}
{{--                                    <i class="ki-outline ki-star fs-5"></i>--}}
{{--                                </div>--}}
{{--                                <div class="rating-label me-2 checked">--}}
{{--                                    <i class="ki-outline ki-star fs-5"></i>--}}
{{--                                </div>--}}
{{--                                <div class="rating-label me-2 checked">--}}
{{--                                    <i class="ki-outline ki-star fs-5"></i>--}}
{{--                                </div>--}}
{{--                                <div class="rating-label me-2 checked">--}}
{{--                                    <i class="ki-outline ki-star fs-5"></i>--}}
{{--                                </div>--}}
{{--                                <div class="rating-label me-2 checked">--}}
{{--                                    <i class="ki-outline ki-star fs-5"></i>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <!--end::Rating-->--}}
{{--                            <!--begin::Title-->--}}
{{--                            <div class="fs-2 fw-bold text-gray-900 mb-3">This is by far the cleanest template--}}
{{--                                <br/>and the most well structured--}}
{{--                            </div>--}}
{{--                            <!--end::Title-->--}}
{{--                            <!--begin::Feedback-->--}}
{{--                            <div class="text-gray-500 fw-semibold fs-4">The most well thought out design theme I have--}}
{{--                                ever used. The codes are up to tandard. The css styles are very clean. In fact the--}}
{{--                                cleanest and the most up to standard I have ever seen.--}}
{{--                            </div>--}}
{{--                            <!--end::Feedback-->--}}
{{--                        </div>--}}
{{--                        <!--end::Wrapper-->--}}
{{--                        <!--begin::Author-->--}}
{{--                        <div class="d-flex align-items-center">--}}
{{--                            <!--begin::Avatar-->--}}
{{--                            <div class="symbol symbol-circle symbol-50px me-5">--}}
{{--                                <img src="assets/media/avatars/300-2.jpg" class="" alt=""/>--}}
{{--                            </div>--}}
{{--                            <!--end::Avatar-->--}}
{{--                            <!--begin::Name-->--}}
{{--                            <div class="flex-grow-1">--}}
{{--                                <a href="#" class="text-gray-900 fw-bold text-hover-primary fs-6">Janya Clebert</a>--}}
{{--                                <span class="text-muted d-block fw-bold">Development Lead</span>--}}
{{--                            </div>--}}
{{--                            <!--end::Name-->--}}
{{--                        </div>--}}
{{--                        <!--end::Author-->--}}
{{--                    </div>--}}
{{--                    <!--end::Testimonial-->--}}
{{--                </div>--}}
{{--                <!--end::Col-->--}}
{{--                <!--begin::Col-->--}}
{{--                <div class="col-lg-4">--}}
{{--                    <!--begin::Testimonial-->--}}
{{--                    <div--}}
{{--                        class="d-flex flex-column justify-content-between h-lg-100 px-10 px-lg-0 pe-lg-10 mb-15 mb-lg-0">--}}
{{--                        <!--begin::Wrapper-->--}}
{{--                        <div class="mb-7">--}}
{{--                            <!--begin::Rating-->--}}
{{--                            <div class="rating mb-6">--}}
{{--                                <div class="rating-label me-2 checked">--}}
{{--                                    <i class="ki-outline ki-star fs-5"></i>--}}
{{--                                </div>--}}
{{--                                <div class="rating-label me-2 checked">--}}
{{--                                    <i class="ki-outline ki-star fs-5"></i>--}}
{{--                                </div>--}}
{{--                                <div class="rating-label me-2 checked">--}}
{{--                                    <i class="ki-outline ki-star fs-5"></i>--}}
{{--                                </div>--}}
{{--                                <div class="rating-label me-2 checked">--}}
{{--                                    <i class="ki-outline ki-star fs-5"></i>--}}
{{--                                </div>--}}
{{--                                <div class="rating-label me-2 checked">--}}
{{--                                    <i class="ki-outline ki-star fs-5"></i>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <!--end::Rating-->--}}
{{--                            <!--begin::Title-->--}}
{{--                            <div class="fs-2 fw-bold text-gray-900 mb-3">This is by far the cleanest template--}}
{{--                                <br/>and the most well structured--}}
{{--                            </div>--}}
{{--                            <!--end::Title-->--}}
{{--                            <!--begin::Feedback-->--}}
{{--                            <div class="text-gray-500 fw-semibold fs-4">The most well thought out design theme I have--}}
{{--                                ever used. The codes are up to tandard. The css styles are very clean. In fact the--}}
{{--                                cleanest and the most up to standard I have ever seen.--}}
{{--                            </div>--}}
{{--                            <!--end::Feedback-->--}}
{{--                        </div>--}}
{{--                        <!--end::Wrapper-->--}}
{{--                        <!--begin::Author-->--}}
{{--                        <div class="d-flex align-items-center">--}}
{{--                            <!--begin::Avatar-->--}}
{{--                            <div class="symbol symbol-circle symbol-50px me-5">--}}
{{--                                <img src="assets/media/avatars/300-16.jpg" class="" alt=""/>--}}
{{--                            </div>--}}
{{--                            <!--end::Avatar-->--}}
{{--                            <!--begin::Name-->--}}
{{--                            <div class="flex-grow-1">--}}
{{--                                <a href="#" class="text-gray-900 fw-bold text-hover-primary fs-6">Steave Brown</a>--}}
{{--                                <span class="text-muted d-block fw-bold">Development Lead</span>--}}
{{--                            </div>--}}
{{--                            <!--end::Name-->--}}
{{--                        </div>--}}
{{--                        <!--end::Author-->--}}
{{--                    </div>--}}
{{--                    <!--end::Testimonial-->--}}
{{--                </div>--}}
{{--                <!--end::Col-->--}}
{{--            </div>--}}
{{--            <!--end::Row-->--}}
{{--            <!--begin::Highlight-->--}}
{{--            --}}{{--            <div class="d-flex flex-stack flex-wrap flex-md-nowrap card-rounded shadow p-8 p-lg-12 mb-n5 mb-lg-n13"--}}
{{--            --}}{{--                 style="background: linear-gradient(90deg, #20AA3E 0%, #03A588 100%);">--}}
{{--            --}}{{--                <!--begin::Content-->--}}
{{--            --}}{{--                <div class="my-2 me-5">--}}
{{--            --}}{{--                    <!--begin::Title-->--}}
{{--            --}}{{--                    <div class="fs-1 fs-lg-2qx fw-bold text-white mb-2">Start With Metronic Today,--}}
{{--            --}}{{--                        <span class="fw-normal">Speed Up Development!</span></div>--}}
{{--            --}}{{--                    <!--end::Title-->--}}
{{--            --}}{{--                    <!--begin::Description-->--}}
{{--            --}}{{--                    <div class="fs-6 fs-lg-5 text-white fw-semibold opacity-75">Join over 100,000 Professionals--}}
{{--            --}}{{--                        Community to Stay Ahead--}}
{{--            --}}{{--                    </div>--}}
{{--            --}}{{--                    <!--end::Description-->--}}
{{--            --}}{{--                </div>--}}
{{--            --}}{{--                <!--end::Content-->--}}
{{--            --}}{{--                <!--begin::Link-->--}}
{{--            --}}{{--                <a href="https://1.envato.market/EA4JP"--}}
{{--            --}}{{--                   class="btn btn-lg btn-outline border-2 btn-outline-white flex-shrink-0 my-2">Purchase on--}}
{{--            --}}{{--                    Themeforest</a>--}}
{{--            --}}{{--                <!--end::Link-->--}}
{{--            --}}{{--            </div>--}}
{{--            <!--end::Highlight-->--}}
{{--        </div>--}}
{{--        <!--end::Container-->--}}
{{--    </div>--}}
    <!--end::Testimonials Section-->
    <!--begin::Footer Section-->
    @include('landing.partials._footer')
    <!--end::Footer Section-->
    <!--begin::Scrolltop-->
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <i class="ki-outline ki-arrow-up"></i>
    </div>
    <!--end::Scrolltop-->
</div>
<!--end::Root-->
<!--end::Main-->
<!--begin::Scrolltop-->
<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
    <i class="ki-outline ki-arrow-up"></i>
</div>
<!--end::Scrolltop-->
<!--begin::Javascript-->
<script>var hostUrl = "assets/";</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="assets/plugins/global/plugins.bundle.js"></script>
<script src="assets/js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Vendors Javascript(used for this page only)-->
<script src="assets/plugins/custom/fslightbox/fslightbox.bundle.js"></script>
<script src="assets/plugins/custom/typedjs/typedjs.bundle.js"></script>
<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used for this page only)-->
<script src="assets/js/custom/landing.js"></script>
<script src="assets/js/custom/pages/pricing/general.js"></script>
<!--end::Custom Javascript-->
<!--end::Javascript-->
</body>
<!--end::Body-->
</html>
