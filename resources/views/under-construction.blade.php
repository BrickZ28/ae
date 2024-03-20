

<!DOCTYPE html>

<html lang="en">
<!--begin::Head-->
@include('landing.partials.header-layout._head')
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
<!--begin::Theme mode setup on page load-->
<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
<!--end::Theme mode setup on page load-->
<!--begin::Root-->
<div class="d-flex flex-column flex-root" id="kt_app_root">
    <!--begin::Page bg image-->
    <style>body { background-image: url('assets/media/auth/bg9.jpg'); } [data-bs-theme="dark"] body { background-image: url('assets/media/auth/bg9-dark.jpg'); }</style>
    <!--end::Page bg image-->
    <!--begin::Authentication - Signup Welcome Message -->
    <div class="d-flex flex-column flex-center flex-column-fluid">
        <!--begin::Content-->
        <div class="d-flex flex-column flex-center text-center p-10">
            <!--begin::Wrapper-->
            <div class="card card-flush w-lg-650px py-5">
                <div class="card-body py-15 py-lg-20">
                    <!--begin::Logo-->
                    <div class="mb-13">
                        <a href="index.html" class="">
                            <img alt="Logo" src="{{asset('assets/media/logos/aegbanner.png')}}" class="h-150px" />
                        </a>
                    </div>
                    <!--end::Logo-->
                    <!--begin::Title-->
                    <h1 class="fw-bolder text-gray-900 mb-7">We're Launching Soon</h1>
                    <!--end::Title-->
                    <!--begin::Counter-->
                    <!--(uncomment to display coming soon counter)
<div class="d-flex flex-center pb-10 pt-lg-5 pb-lg-12">
<div class="w-65px rounded-3 bg-body shadow-sm py-4 px-5 mx-3">
    <div class="fs-2 fw-bold text-gray-800" id="kt_coming_soon_counter_days"></div>
    <div class="fs-7 fw-semibold text-muted">days</div>
</div>

<div class="w-65px rounded-3 bg-body shadow-sm py-4 px-5 mx-3">
    <div class="fs-2 fw-bold text-gray-800" id="kt_coming_soon_counter_hours"></div>
    <div class="fs-7 text-muted">hrs</div>
</div>

<div class="w-65px rounded-3 bg-body shadow-sm py-4 px-5 mx-3">
    <div class="fs-2 fw-bold text-gray-800" id="kt_coming_soon_counter_minutes"></div>
    <div class="fs-7 text-muted">min</div>
</div>

<div class="w-65px rounded-3 bg-body shadow-sm py-4 px-5 mx-3">
    <div class="fs-2 fw-bold text-gray-800" id="kt_coming_soon_counter_seconds"></div>
    <div class="fs-7 text-muted">sec</div>
</div>
</div>
-->
                    <!--end::Counter-->
                    <!--begin::Text-->
                    <div class="fw-semibold fs-6 text-gray-500 mb-7">Our main site will be back up and running
                        very shortly, with new and exciting features!!!</div>
                    <!--end::Text-->

                    <!--begin::Illustration-->
                    <div class="mb-n5">
                        <img src="assets/media/auth/chart-graph.png" class="mw-100 mh-300px theme-light-show" alt="" />
                        <img src="assets/media/auth/chart-graph-dark.png" class="mw-100 mh-300px theme-dark-show" alt="" />
                    </div>
                    <!--end::Illustration-->
                </div>
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Authentication - Signup Welcome Message-->
</div>
<!--end::Root-->
<!--begin::Javascript-->
<script>var hostUrl = "assets/";</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Custom Javascript(used for this page only)-->
<script src="{{asset('assets/js/custom/authentication/sign-up/coming-soon.js')}}"></script>
<!--end::Custom Javascript-->
<!--end::Javascript-->
</body>
<!--end::Body-->
</html>
