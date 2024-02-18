<div class="pb-15 pt-18 landing-dark-bg">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Heading-->
        <div class="text-center mt-15 mb-18" id="achievements" data-kt-scroll-offset="{default: 100, lg: 150}">
            <!--begin::Title-->
            <h3 class="fs-2hx text-white fw-bold mb-5">Join and enjoy our server. </h3>
            <!--end::Title-->
            <!--begin::Description-->
            <div class="fs-5 text-gray-700 fw-bold">AfterEarth Gaming is a well established active gaming
                community
                <br/>see our statistics below
            </div>
            <!--end::Description-->
        </div>
        <!--end::Heading-->
        <!--begin::Statistics-->
        <div class="d-flex flex-center">
            <!--begin::Items-->
            <div class="d-flex flex-wrap flex-center justify-content-lg-between mb-15 mx-auto w-xl-900px">
                <!--begin::Item-->
                <div
                    class="d-flex flex-column flex-center h-200px w-200px h-lg-250px w-lg-250px m-3 bgi-no-repeat bgi-position-center bgi-size-contain"
                    style="background-image: url('assets/media/svg/misc/octagon.svg')">
                    <!--begin::Symbol-->
                    <i class="ki-outline ki-user fs-2tx text-white mb-3"></i>
                    <!--end::Symbol-->
                    <!--begin::Info-->
                    <div class="mb-0">
                        <!--begin::Value-->

                        <div class="fs-lg-2hx fs-2x fw-bold text-white d-flex flex-center">
                            <div class="min-w-70px" data-kt-countup="true"
                                 data-kt-countup-value={{$users->count()}}
                                         data-kt-countup-suffix="+">0
                            </div>
                        </div>
                        <!--end::Value-->
                        <!--begin::Label-->
                        <span class="text-gray-600 fw-semibold fs-5 lh-0">Registered Users</span>
                        <!--end::Label-->
                    </div>
                    <!--end::Info-->
                </div>
                <!--end::Item-->
                <!--begin::Item-->
                <div
                    class="d-flex flex-column flex-center h-200px w-200px h-lg-250px w-lg-250px m-3 bgi-no-repeat bgi-position-center bgi-size-contain"
                    style="background-image: url('assets/media/svg/misc/octagon.svg')">
                    <!--begin::Symbol-->
                    <i class="ki-outline ki-cloud fs-2tx text-white mb-3"></i>
                    <!--end::Symbol-->
                    <!--begin::Info-->
                    <div class="mb-0">
                        <!--begin::Value-->
                        <div class="fs-lg-2hx fs-2x fw-bold text-white d-flex flex-center">
                            <div class="min-w-70px" data-kt-countup="true" data-kt-countup-value="{{count($servers['data']['services'])}}"
                                 data-kt-countup-suffix=" active">0
                            </div>
                        </div>
                        <!--end::Value-->
                        <!--begin::Label-->
                        <span class="text-gray-600 fw-semibold fs-5 lh-0">Cluster Servers</span>
                        <!--end::Label-->
                    </div>
                    <!--end::Info-->
                </div>
                <!--end::Item-->
                <!--begin::Item-->
                <div
                    class="d-flex flex-column flex-center h-200px w-200px h-lg-250px w-lg-250px m-3 bgi-no-repeat bgi-position-center bgi-size-contain"
                    style="background-image: url('assets/media/svg/misc/octagon.svg')">
                    <!--begin::Symbol-->
                    <i class="ki-outline ki-ghost fs-2tx text-white mb-3"></i>
                    <!--end::Symbol-->
                    <!--begin::Info-->
                    <div class="mb-0">
                        <!--begin::Value-->
                        <div class="fs-lg-2hx fs-2x fw-bold text-white d-flex flex-center">
                            <div class="min-w-70px" data-kt-countup="true" data-kt-countup-value="{{$online_players}}"
                                 data-kt-countup-suffix=" players">0
                            </div>
                        </div>
                        <!--end::Value-->
                        <!--begin::Label-->
                        <span class="text-gray-600 fw-semibold fs-5 lh-0">Online </span>
                        <!--end::Label-->
                    </div>
                    <!--end::Info-->
                </div>
                <!--end::Item-->
            </div>
            <!--end::Items-->
        </div>
        <!--end::Statistics-->
        <!--begin::Testimonial-->
        <div class="fs-2 fw-semibold text-muted text-center mb-3">
            <span class="fs-1 lh-1 text-gray-700">Come join and play on one of our multiple servers today
            </span></div>
        <!--end::Testimonial-->
        <!--begin::Author-->
        <div class="fs-2 fw-semibold text-muted text-center">

            <span class="fs-4 fw-bold text-gray-600">You're bound to find everything you need</span>
        </div>
        <!--end::Author-->
    </div>
    <!--end::Container-->
</div>
