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
                    <a href="#" class="btn btn-primary er fs-6 px-8 py-4" data-bs-toggle="modal"
                       data-bs-target="#kt_modal_select_users">Select Game and Style</a>
                    <!--end::Action-->
                </div>
                <!--end::Heading-->
                <!--begin::Illustration-->
                <div class="text-center pb-15 px-5">
                    <img src="{{asset('assets/media/illustrations/sketchy-1/20.png')}}" alt="" class="mw-100 h-200px h-sm-325px" />
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
                    <div class="modal fade" id="kt_modal_select_users" tabindex="-1" >
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

                                                    <!--begin::Details-->
                                                    <div>
                                                        <!--begin::Name-->
                                                        <div class="d-flex align-items-center">
                                                            Ark Survival Ascended
                                                            <!--begin::Label-->
                                                            <span class="badge badge-light-success d-flex align-items-center fs-8 fw-semibold">
												<i class="ki-duotone ki-star fs-8 text-success me-1"></i>PVE</span>
                                                            <!--end::Label-->
                                                        </div>
                                                        <!--end::Name-->
                                                        <!--begin::Desc-->
                                                        <span class="text-muted fw-semibold mb-3">ASA</span>
                                                        <!--end::Desc-->
                                                    </div>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Info-->

                                            </div>
                                            <!--end::Info-->
                                            <!--begin::Wrapper-->
                                            <div class="p-0">
                                                <!--begin::Section-->
                                                <div class="d-flex flex-column">
                                                    <!--begin::Text-->
                                                    <p class="text-gray-700 fw-semibold fs-6 mb-4">Kit includes LvL 200
                                                        Petra, and <button class="btn btn-link btn-color-success btn-active-color-primary me-5 mb-2 " type="button"
                                                                           data-bs-toggle="modal"
                                                                            data-bs-target="#imageModal"
                                                                           onclick="document.getElementById('modalImage').src='https://aeg-development.nyc3.cdn.digitaloceanspaces.com/images/kits/ArkAscended_startkit.png'">theses pictured items</button> </p>
                                                    <!--end::Text-->
                                                    <!--begin::Tags-->
                                                    <div class="d-flex text-gray-700 fw-semibold fs-7">
                                                        <!--begin::Tag-->
                                                        <span class="border border-2 rounded me-3 p-1 px-2">Metal Armor
                                                        </span>
                                                        <!--end::Tag-->
                                                        <!--begin::Tag-->
                                                        <span class="border border-2 rounded me-3 p-1 px-2">Metal
                                                            Craft gear
                                                        </span>
                                                        <!--end::Tag-->
                                                        <!--begin::Tag-->
                                                        <span class="border border-2 rounded me-3 p-1
                                                        px-2">Saddle</span>
                                                        <!--end::Tag-->
                                                        <!--begin::Tag-->
                                                        <span class="border border-2 rounded me-3 p-1
                                                        px-2">Spyglass</span>
                                                        <!--begin::Tag-->
                                                        <span class="border border-2 rounded me-3 p-1
                                                        px-2">Sword</span>
                                                        <!--end::Tag-->
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
                                                        <div class="d-flex flex-column mw-250px">
                                                            <ul>
                                                                <li>Self claimed</li>
                                                                <li>Limit one per person</li>
                                                                <li>Further info in discord message</li>
                                                            </ul>
                                                        </div>
                                                        <!--end::Progress-->
                                                        <!--begin::Button-->
                                                        <form action="{{route('register.process')}}" method="GET">
                                                            @csrf
                                                            <input type="hidden" name="game" value="asapve">
                                                            <button type="submit" class="btn btn-sm
                                                            btn-success">Select</button>
                                                        </form>
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

                                                    <!--begin::Details-->
                                                    <div>
                                                        <!--begin::Name-->
                                                        <div class="d-flex align-items-center">
                                                            Ark Survival Ascended
                                                            <!--begin::Label-->
                                                            <span class="badge badge-light-danger d-flex
                                                            align-items-center fs-8 fw-semibold">
												<i class="ki-duotone ki-star fs-8 text-success me-1"></i>PVP</span>
                                                            <!--end::Label-->
                                                        </div>
                                                        <!--end::Name-->
                                                        <!--begin::Desc-->
                                                        <span class="text-muted fw-semibold mb-3">ASA</span>
                                                        <!--end::Desc-->
                                                    </div>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Info-->

                                            </div>
                                            <!--end::Info-->
                                            <!--begin::Wrapper-->
                                            <div class="p-0">
                                                <!--begin::Section-->
                                                <div class="d-flex flex-column">
                                                    <!--begin::Text-->
                                                    <p class="text-gray-700 fw-semibold fs-6 mb-4">Kit includes LvL 150
                                                        Petra, and <button class="btn btn-link btn-color-danger
                                                        btn-active-color-primary me-5 mb-2 " type="button"
                                                                           data-bs-toggle="modal"
                                                                            data-bs-target="#imageModal"
                                                                           onclick="document.getElementById('modalImage').src='https://aeg-development.nyc3.cdn.digitaloceanspaces.com/images/kits/ArkAscended_startkit.png'">theses pictured items</button> </p>
                                                    <!--end::Text-->
                                                    <!--begin::Tags-->
                                                    <div class="d-flex text-gray-700 fw-semibold fs-7">
                                                        <!--begin::Tag-->
                                                        <span class="border border-2 rounded me-3 p-1 px-2">Metal Armor
                                                        </span>
                                                        <!--end::Tag-->
                                                        <!--begin::Tag-->
                                                        <span class="border border-2 rounded me-3 p-1 px-2">Metal
                                                            Craft gear
                                                        </span>
                                                        <!--end::Tag-->
                                                        <!--begin::Tag-->
                                                        <span class="border border-2 rounded me-3 p-1
                                                        px-2">Saddle</span>
                                                        <!--end::Tag-->
                                                        <!--begin::Tag-->
                                                        <span class="border border-2 rounded me-3 p-1
                                                        px-2">Spyglass</span>
                                                        <!--begin::Tag-->
                                                        <span class="border border-2 rounded me-3 p-1
                                                        px-2">Sword</span>
                                                        <!--end::Tag-->
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
                                                        <div class="d-flex flex-column mw-250px">
                                                            <ul>
                                                                <li>Self claimed</li>
                                                                <li>Limit one per person</li>
                                                                <li>Further info in discord message</li>
                                                            </ul>
                                                        </div>
                                                        <!--end::Progress-->
                                                        <!--begin::Button-->

                                                        <form action="{{route('register.process')}}" method="GET">
                                                            @csrf
                                                            <input type="hidden" name="game" value="asapvp">
                                                            <button type="submit" class="btn btn-sm
                                                            btn-danger">Select</button>
                                                        </form>
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

                                                    <!--begin::Details-->
                                                    <div>
                                                        <!--begin::Name-->
                                                        <div class="d-flex align-items-center">
                                                            Ark Survival Evolved
                                                            <!--begin::Label-->
                                                            <span class="badge badge-light-success d-flex align-items-center fs-8 fw-semibold">
												<i class="ki-duotone ki-star fs-8 text-success me-1"></i>PVE</span>
                                                            <!--end::Label-->
                                                        </div>
                                                        <!--end::Name-->
                                                        <!--begin::Desc-->
                                                        <span class="text-muted fw-semibold mb-3">ASE</span>
                                                        <!--end::Desc-->
                                                    </div>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Info-->

                                            </div>
                                            <!--end::Info-->
                                            <!--begin::Wrapper-->
                                            <div class="p-0">
                                                <!--begin::Section-->
                                                <div class="d-flex flex-column">
                                                    <!--begin::Text-->
                                                    <p class="text-gray-700 fw-semibold fs-6 mb-4">Kit includes LvL 200
                                                        Petra, and <button class="btn btn-link btn-color-success btn-active-color-primary me-5 mb-2 " type="button"
                                                                           data-bs-toggle="modal"
                                                                            data-bs-target="#imageModal"
                                                                           onclick="document.getElementById('modalImage').src='https://aeg-development.nyc3.cdn.digitaloceanspaces.com/images/kits/ArkAscended_startkit.png'">theses pictured items</button> </p>
                                                    <!--end::Text-->
                                                    <!--begin::Tags-->
                                                    <div class="d-flex text-gray-700 fw-semibold fs-7">
                                                        <!--begin::Tag-->
                                                        <span class="border border-2 rounded me-3 p-1 px-2">Metal Armor
                                                        </span>
                                                        <!--end::Tag-->
                                                        <!--begin::Tag-->
                                                        <span class="border border-2 rounded me-3 p-1 px-2">Metal
                                                            Craft gear
                                                        </span>
                                                        <!--end::Tag-->
                                                        <!--begin::Tag-->
                                                        <span class="border border-2 rounded me-3 p-1
                                                        px-2">Saddle</span>
                                                        <!--end::Tag-->
                                                        <!--begin::Tag-->
                                                        <span class="border border-2 rounded me-3 p-1
                                                        px-2">Spyglass</span>
                                                        <!--begin::Tag-->
                                                        <span class="border border-2 rounded me-3 p-1
                                                        px-2">Sword</span>
                                                        <!--end::Tag-->
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
                                                        <div class="d-flex flex-column mw-250px">
                                                            <ul>
                                                                <li>Self claimed</li>
                                                                <li>Limit one per person</li>
                                                                <li>Further info in discord message</li>
                                                            </ul>
                                                        </div>
                                                        <!--end::Progress-->
                                                        <!--begin::Button-->
                                                        <form action="{{route('register.process')}}" method="GET">
                                                            @csrf
                                                            <input type="hidden" name="game" value="asepve">
                                                            <button type="submit" class="btn btn-sm
                                                            btn-success">Select</button>
                                                        </form>
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

                                                    <!--begin::Details-->
                                                    <div>
                                                        <!--begin::Name-->
                                                        <div class="d-flex align-items-center">
                                                            Ark Survival Evolved
                                                            <!--begin::Label-->
                                                            <span class="badge badge-light-danger d-flex
                                                            align-items-center fs-8 fw-semibold">
												<i class="ki-duotone ki-star fs-8 text-danger me-1"></i>PVE</span>
                                                            <!--end::Label-->
                                                        </div>
                                                        <!--end::Name-->
                                                        <!--begin::Desc-->
                                                        <span class="text-muted fw-semibold mb-3">ASE</span>
                                                        <!--end::Desc-->
                                                    </div>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Info-->

                                            </div>
                                            <!--end::Info-->
                                            <!--begin::Wrapper-->
                                            <div class="p-0">
                                                <!--begin::Section-->
                                                <div class="d-flex flex-column">
                                                    <!--begin::Text-->
                                                    <p class="text-gray-700 fw-semibold fs-6 mb-4">Kit includes LvL 200
                                                        Petra, and <button class="btn btn-link btn-color-danger
                                                        btn-active-color-primary me-5 mb-2 " type="button"
                                                                           data-bs-toggle="modal"
                                                                            data-bs-target="#imageModal"
                                                                           onclick="document.getElementById('modalImage').src='https://aeg-development.nyc3.cdn.digitaloceanspaces.com/images/kits/ArkAscended_startkit.png'">theses pictured items</button> </p>
                                                    <!--end::Text-->
                                                    <!--begin::Tags-->
                                                    <div class="d-flex text-gray-700 fw-semibold fs-7">
                                                        <!--begin::Tag-->
                                                        <span class="border border-2 rounded me-3 p-1 px-2">Metal Armor
                                                        </span>
                                                        <!--end::Tag-->
                                                        <!--begin::Tag-->
                                                        <span class="border border-2 rounded me-3 p-1 px-2">Metal
                                                            Craft gear
                                                        </span>
                                                        <!--end::Tag-->
                                                        <!--begin::Tag-->
                                                        <span class="border border-2 rounded me-3 p-1
                                                        px-2">Saddle</span>
                                                        <!--end::Tag-->
                                                        <!--begin::Tag-->
                                                        <span class="border border-2 rounded me-3 p-1
                                                        px-2">Spyglass</span>
                                                        <!--begin::Tag-->
                                                        <span class="border border-2 rounded me-3 p-1
                                                        px-2">Sword</span>
                                                        <!--end::Tag-->
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
                                                        <div class="d-flex flex-column mw-250px">
                                                            <ul>
                                                                <li>Self claimed</li>
                                                                <li>Limit one per person</li>
                                                                <li>Further info in discord message</li>
                                                            </ul>
                                                        </div>
                                                        <!--end::Progress-->
                                                        <!--begin::Button-->
                                                        <form action="{{route('register.process')}}" method="GET">
                                                            @csrf
                                                            <input type="hidden" name="game" value="asepvp">
                                                            <button type="submit" class="btn btn-sm
                                                            btn-danger">Select</button>
                                                        </form>
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
                    <div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <img id="modalImage" src="" class="img-fluid" alt="" />
            </div>
        </div>
    </div>
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
<script>
   $('#imageModal').on('hidden.bs.modal', function (event) {
    $('#kt_modal_select_users').modal('show');
});
</script>
</body>
</html>
