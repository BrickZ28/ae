<div class="py-10 py-lg-20">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Heading-->
        <div class="text-center mb-12">
            <!--begin::Title-->
            <h3 class="fs-2hx text-gray-900 mb-5" id="team" data-kt-scroll-offset="{default: 100, lg: 150}">Server
                Stats</h3>
            <!--end::Title-->
            <!--begin::Sub-title-->
            <div class="fs-5 text-muted fw-bold">It’s no doubt that when a development takes longer to complete,
                additional costs to
                <br/>integrate and test each extra feature creeps up and haunts most of us.
            </div>
            <!--end::Sub-title=-->
        </div>
        <!--end::Heading-->
        <!--begin::Slider-->
        <div class="tns tns-default" style="direction: ltr">
            <!--begin::Wrapper-->
            <div data-tns="true" data-tns-loop="true" data-tns-swipe-angle="false" data-tns-speed="2000"
                 data-tns-autoplay="true" data-tns-autoplay-timeout="18000" data-tns-controls="true"
                 data-tns-nav="false" data-tns-items="1" data-tns-center="false" data-tns-dots="false"
                 data-tns-prev-button="#kt_team_slider_prev" data-tns-next-button="#kt_team_slider_next"
                 data-tns-responsive="{1200: {items: 3}, 992: {items: 2}}">
                <!--begin::Item-->


                @foreach($specials as $special)
                    <div class="text-center">
                        <!--begin::Photo-->
                        <div class="octagon mx-auto mb-5">
                            <img src="{{ getRandomImage() }}" alt="Special Image" class="w-200px h-200px">
                        </div>
                        <!--end::Photo-->

                        <!--begin::Person-->
                        <div class="mb-0">
                            <!--begin::Name-->
                            <a href="#" class="text-gray-900 fw-bold text-hover-primary fs-3">{{ $special->title }}</a>
                            <!--end::Name-->

                            <!--begin::Position-->
                            <div class="text-muted fs-6 fw-semibold mt-1">{{ $special->description }}</div>
                            <!--begin::Position-->
                        </div>
                        <!--end::Person-->
                    </div>
                @endforeach

                <!--end::Item-->

            </div>
            <!--end::Wrapper-->
            <!--begin::Button-->
            <button class="btn btn-icon btn-active-color-primary" id="kt_team_slider_prev">
                <i class="ki-outline ki-left fs-2x"></i>
            </button>
            <!--end::Button-->
            <!--begin::Button-->
            <button class="btn btn-icon btn-active-color-primary" id="kt_team_slider_next">
                <i class="ki-outline ki-right fs-2x"></i>
            </button>
            <!--end::Button-->
        </div>
        <!--end::Slider-->
    </div>
    <!--end::Container-->
</div>
