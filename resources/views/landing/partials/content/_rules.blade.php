<div class="mb-n10 mb-lg-n20 z-index-2">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Heading-->
        <div class="text-center mb-17">
            <!--begin::Title-->
            <h3 class="fs-2hx text-gray-900 mb-5" id="how-it-works" data-kt-scroll-offset="{default: 100, lg: 150}">
                Server Rules</h3>
            <!--end::Title-->
            <!--begin::Text-->
            <div class="fs-5 text-muted fw-bold">These rules are expected to be followed so that everyone can enjoy
                our servers.  Thank you.
            </div>
            <!--end::Text-->
        </div>
        <!--end::Heading-->
        <!--begin::Row-->
        <div class="row w-100 gy-10 mb-md-20">
            <!--begin::Col-->
            <div class="col-md-4 px-5">
                <!--begin::Story-->

                @foreach($rules as $rule)
                    <div class="text-center mb-10 mb-md-0">
                        <!--begin::Illustration-->
                        <img src="assets/media/illustrations/dozzy-1/2.png" class="mh-125px mb-9" alt=""/>
                        <!--end::Illustration-->
                        <!--begin::Heading-->
                        <div class="d-flex flex-center mb-5">
                            <!--begin::Badge-->
                            <span class="badge badge-circle badge-light-success fw-bold p-5 me-3
                            fs-3">{{$loop->count}}</span>
                            <!--end::Badge-->
                            <!--begin::Title-->
                            <div class="fs-5 fs-lg-3 fw-bold text-gray-900">{{$rule->rule}}</div>
                            <!--end::Title-->
                        </div>
                        <!--end::Heading-->
                        <!--begin::Description-->
                        <div class="fw-semibold fs-6 fs-lg-4 text-muted">updated <x-display-date-formatted
                                :date="$rule->updated_at" format="D M j, Y @ g:i:sa" />
                        </div>
                        <!--end::Description-->
                    </div>
                @endforeach

                <!--end::Story-->
            </div>
            <!--end::Col-->

        </div>
        <!--end::Row-->
        <!--begin::Product slider-->
        <div class="tns tns-default">
            <!--begin::Slider-->
            <div data-tns="true" data-tns-loop="true" data-tns-swipe-angle="false" data-tns-speed="2000"
                 data-tns-autoplay="true" data-tns-autoplay-timeout="18000" data-tns-controls="true"
                 data-tns-nav="false" data-tns-items="1" data-tns-center="false" data-tns-dots="false"
                 data-tns-prev-button="#kt_team_slider_prev1" data-tns-next-button="#kt_team_slider_next1">
                <!--begin::Item-->
                <div class="text-center px-5 pt-5 pt-lg-10 px-lg-10">
                    <img src="assets/media/preview/demos/demo1/light-ltr.png"
                         class="card-rounded shadow mh-lg-650px mw-100" alt=""/>
                </div>
                <!--end::Item-->
                <!--begin::Item-->
                <div class="text-center px-5 pt-5 pt-lg-10 px-lg-10">
                    <img src="assets/media/preview/demos/demo2/light-ltr.png"
                         class="card-rounded shadow mh-lg-650px mw-100" alt=""/>
                </div>
                <!--end::Item-->
                <!--begin::Item-->
                <div class="text-center px-5 pt-5 pt-lg-10 px-lg-10">
                    <img src="assets/media/preview/demos/demo4/light-ltr.png"
                         class="card-rounded shadow mh-lg-650px mw-100" alt=""/>
                </div>
                <!--end::Item-->
                <!--begin::Item-->
                <div class="text-center px-5 pt-5 pt-lg-10 px-lg-10">
                    <img src="assets/media/preview/demos/demo5/light-ltr.png"
                         class="card-rounded shadow mh-lg-650px mw-100" alt=""/>
                </div>
                <!--end::Item-->
            </div>
            <!--end::Slider-->
            <!--begin::Slider button-->
{{--            <button class="btn btn-icon btn-active-color-primary" id="kt_team_slider_prev1">--}}
{{--                <i class="ki-outline ki-left fs-2x"></i>--}}
{{--            </button>--}}
{{--            <!--end::Slider button-->--}}
{{--            <!--begin::Slider button-->--}}
{{--            <button class="btn btn-icon btn-active-color-primary" id="kt_team_slider_next1">--}}
{{--                <i class="ki-outline ki-right fs-2x"></i>--}}
{{--            </button>--}}
            <!--end::Slider button-->
        </div>
        <!--end::Product slider-->
    </div>
    <!--end::Container-->
</div>
