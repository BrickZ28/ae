<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('dashboard.partials._head')
</head>

<body id="kt_app_body" class="app-default"
      data-kt-app-layout="dark-sidebar"
      data-kt-app-header-fixed="true"
      data-kt-app-sidebar-enabled="true"
      data-kt-app-sidebar-fixed="true"
      data-kt-app-sidebar-hoverable="true"
      data-kt-app-sidebar-push-header="true"
      data-kt-app-sidebar-push-toolbar="true"
      data-kt-app-sidebar-push-footer="true"
      data-kt-app-toolbar-enabled="true">

<!-- Theme mode setup on page load -->
<script>
    var defaultThemeMode = "light";
    var themeMode;
    if (document.documentElement) {
        themeMode = document.documentElement.getAttribute("data-bs-theme-mode") ?? localStorage.getItem("data-bs-theme") ?? defaultThemeMode;
        if (themeMode === "system") {
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
        }
        document.documentElement.setAttribute("data-bs-theme", themeMode);
    }
</script>

<!-- App Content -->
<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
    <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
        @include('dashboard.partials._header')
        <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
            @include('dashboard.partials._sidebar')
            <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                <div class="d-flex flex-column flex-column-fluid">
                    {{$slot}} <!-- Main Content -->
                </div>
                @include('dashboard.partials._footer')
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
