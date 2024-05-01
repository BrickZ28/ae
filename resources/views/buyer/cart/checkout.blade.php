<x-dashboard.layout>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Form-->
            <form id="kt_ecommerce_edit_order_form"
                  class="form d-flex flex-column flex-lg-row"
                  data-kt-redirect="apps/ecommerce/sales/listing.html"
                  action="{{route('process-payment')}}" method="post">

                <!--begin::Aside column-->

                <!--end::Aside column-->
                <!--begin::Main column-->
                <div class="d-flex flex-column flex-lg-row-fluid gap-7 gap-lg-10">
                    <!--begin::Order details-->
                    <div class="card card-flush py-4">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Review Order</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <div class="d-flex flex-column gap-10">
                                <!--begin::Input group-->

                                <!--end::Input group-->
                                <!--begin::Separator-->
                                <div class="separator"></div>
                                <!--end::Separator-->
                                <!--begin::Search products-->

                                <!--end::Search products-->
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5"
                                       id="kt_ecommerce_edit_order_product_table">
                                    <thead>
                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">

                                        <th class="min-w-200px">Product</th>
                                        <th class="min-w-100px text-end pe-5">Qty</th>
                                    </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                    @foreach($cart->items as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <a href="apps/ecommerce/catalog/edit-product.html"
                                                       class="symbol symbol-50px">
                                                        <span class="symbol-label"
                                                              style="background-image:url({{$item->image}});"></span>
                                                    </a>
                                                    <div class="ms-5">
                                                        <a href="apps/ecommerce/catalog/edit-product.html"
                                                           class="text-gray-800 text-hover-primary fs-5 fw-bold">{{$item->name}}</a>
                                                        <div class="fw-semibold fs-7">Price:
                                                            @if($item->currency_type === 'USD')
                                                                ${{ $item->price }}
                                                            @else
                                                                {{ $item->price }} AEC
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-end pe-5" data-order="39">
                                                <span class="fw-bold ms-3">{{$item->pivot->quantity}}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Card header-->
                    </div>
                    <!--end::Order details-->
                    <!--begin::Order details-->
                    <div class="card card-flush py-4">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Checkout</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Billing address-->
                            <!-- Order Totals Section -->
                            <div class="order-totals">
                                <h2>Order Totals</h2>
                                <div class="total">
                                    <h3>Total (USD):</h3>
                                    <p id="usd-total" style="font-size: 2em; color: green; font-weight: bold;">
                                        ${{$totalUSD}}</p>
                                </div>
                                <div class="total">
                                    <h3>Total (AEC):</h3>
                                    <p id="aec-total"
                                       style="font-size: 2em; color: green; font-weight: bold;">{{$totalAEC}} </p>
                                </div>
                            </div>
                            <!--end::Billing address-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Order details-->
                    <div class="d-flex justify-content-end">
                        <!--begin::Button-->
                        <a href="{{route('cancel-checkout')}}" id="kt_ecommerce_edit_order_cancel"
                           class="btn btn-light me-5">Cancel</a>
                        <!--end::Button-->
                        <!--begin::Button-->
                        <form action="{{route('process-payment')}}" method="post">
                            @csrf
                            <button type="submit" id="kt_ecommerce_edit_order_submit" class="btn btn-primary">
                                <span class="indicator-label">Pay</span>
                                <span class="indicator-progress">Please wait...
													<span
                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </form>
                        <!--end::Button-->
                    </div>
                </div>
                <!--end::Main column-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
</x-dashboard.layout>
