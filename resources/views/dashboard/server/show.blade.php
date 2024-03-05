<x-dashboard.layout>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Pricing card-->
            <div class="card" id="kt_pricing">
                <!--begin::Card body-->
                <div class="card-body p-lg-17">
                    <!--begin::Plans-->
                    <div class="d-flex flex-column">
                        <!--begin::Heading-->
                        <div class="mb-13 text-center">
                            <h1 class="fs-2hx fw-bold mb-5">{{$settings['SessionName']}}</h1>
                            <div class="text-gray-600 fw-semibold fs-5">Current Status
                                <h1  class="fw-bold {{ $api_server['gameserver']['status'] == 'started' ?
                                'text-bg-success' :
                                'text-bg-danger' }}">
                                    {{strtoupper($api_server['gameserver']['status'])}}</h1></div>
                        </div>
                        <!--end::Heading-->
{{dd($api_server)}}

                        <!--begin::Row-->
                        <div class="row g-10 justify-content-center">
                            <!--begin::Col-->
                            <div class="col-xl-6 align-self-center">
                                <div class="d-flex h-100 align-items-center justify-content-center">
                                    <!--begin::Option-->
                                    <div class="w-100 d-flex flex-column flex-center rounded-3 bg-light bg-opacity-75 py-15 px-10 text-center">
                                        <!--begin::Heading-->
                                        <div class="mb-7">
                                            <!--begin::Title-->
                                            <h1 class="text-gray-900 mb-5
                                            fw-bolder">{{$api_server['gameserver']['game_human']}}</h1>
                                            <!--end::Title-->
                                            <!--begin::Description-->
                                            <div class="text-gray-600 fw-semibold mb-5">{{$settings['MaxPlayers']}}
                                                slots</div>
                                            <!--end::Description-->
                                            <!--begin::Price-->
                                            <div>

                                                <span class="fs-3x fw-bold
                                                text-primary"></span>
                                                <span class="fs-7 fw-semibold
                                                opacity-50">$api_server['gameserver']['query']['player_current']</span>
                            <span data-kt-element="period">players online</span>
                        </span>
                                            </div>
                                            <!--end::Price-->
                                        </div>
                                        <!--end::Heading-->
                                        <!--begin::Features-->
                                        <div class="w-100 mb-10 text-center">
                                            <!--begin::Item-->
                                            <x-dashboard-product-card-items label="Taming multiplier"
                                                                            :setting="$settings['TamingSpeedMultiplier']"/>
                                            <x-dashboard-product-card-items label="Harvest multiplier"
                                                                            :setting="$settings['HarvestAmountMultiplier']"/>
                                            <x-dashboard-product-card-items label="XP multiplier"
                                                                            :setting="$settings['XPMultiplier']"/>
                                            <x-dashboard-product-card-items label="Mating multiplier"
                                                                            :setting="$settings['MatingIntervalMultiplier']"/>
                                            <x-dashboard-product-card-items label="Hatch speed multiplier"
                                                                            :setting="$settings['EggHatchSpeedMultiplier']"/>
                                            <x-dashboard-product-card-items label="Baby cuddle multiplier"
                                                                            :setting="$settings['BabyCuddleIntervalMultiplier']"/>
                                            <x-dashboard-product-card-items label="Baby imprint multiplier"
                                                                            :setting="$settings['BabyImprintAmountMultiplier']"/>

                                            <!--end::Item-->

                                        </div>
                                        <!--end::Features-->

                                    </div>
                                    <!--end::Option-->
                                </div>
                            </div>
                            <!--end::Col-->
                        </div>

                        <!--end::Row-->
                    </div>
                    <!--end::Plans-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Pricing card-->
        </div>
        <!--end::Content container-->
    </div>

</x-dashboard.layout>
