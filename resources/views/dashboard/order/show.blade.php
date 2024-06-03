@php use Carbon\Carbon; @endphp
<x-dashboard.layout>

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Order details page-->
            <div class="d-flex flex-column gap-7 gap-lg-10">
                <div class="d-flex flex-wrap flex-stack gap-5 gap-lg-10">
                    <!--begin:::Tabs-->
                    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-lg-n2 me-auto">
                        <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                               href="#kt_ecommerce_sales_order_summary">Order Summary</a>
                        </li>
                        <!--end:::Tab item-->
                        <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                               href="#kt_ecommerce_sales_order_history">Order History</a>
                        </li>
                        <!--end:::Tab item-->
                    </ul>
                    <!--end:::Tabs-->
                    @checkRole(['Owner', 'In the Shadows'])
                        @if(!$order->processed)
                            <a href="{{route('orders.edit', $order->id)}}" class="btn btn-success btn-sm me-lg-n7">Edit
                                Order</a>
                        @endif
                    @endcheckRole
                    <!--begin::Button-->
                    @if (Carbon::now()->subHours(24)->greaterThanOrEqualTo($order->updated_at) && $order->processedBy === null)
                        <a href="{{route('orders.inquiry', $order->id)}}"
                           class="btn btn-info btn-sm me-lg-n7">Inquire</a>

                        {{--                        TODO make this only show to auth user --}}

                        <!--end::Button-->
                        <!--begin::Button-->
                        <form id="canxForm" action="{{ route('orders.cancel.aec', $order->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm">Cancel Order</button>

                    @endif
                    {{--                        <!--end::Button--> //TODO make this a cancel button, only shows after 24 hours and if not--}}
                    {{--                        processed.  Will send message on discord and only for AEC orders--}}
                </div>
                <!--begin::Order summary-->
                <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
                    <!--begin::Order details-->
                    <div class="card card-flush py-4 flex-row-fluid">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Order Details (#{{$order->id}})</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-300px">
                                    <tbody class="fw-semibold text-gray-600">
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-calendar fs-2 me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>Date Added
                                            </div>
                                        </td>
                                        <td class="fw-bold text-end">
                                            <x-display-date-formatted
                                                :date="$order->created_at" format="D M j, Y @ g:i:sa"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-wallet fs-2 me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                </i>User
                                            </div>
                                        </td>
                                        <td class="fw-bold text-end">{{$order->user->userProfile->global_name}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-truck fs-2 me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                    <span class="path5"></span>
                                                </i>Status
                                            </div>
                                        </td>
                                        <td class="fw-bold text-end">{{$order->status->name ?? 'Pending'}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Order details-->
                    <!--begin::Customer details-->
                    <div class="card card-flush py-4 flex-row-fluid">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Items (USD)</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-300px">
                                    <tbody class="fw-semibold text-gray-600">
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-profile-circle fs-2 me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>Amount
                                            </div>
                                        </td>
                                        <td class="fw-bold text-end">
                                            <div class="d-flex align-items-center justify-content-end">
                                                <!--begin:: Avatar -->
                                                <div class="symbol symbol-circle symbol-25px overflow-hidden me-3">
                                                    <a href="apps/ecommerce/customers/details.html">
                                                        <div class="symbol-label">
                                                            <img src="assets/media/avatars/300-23.jpg" alt="Dan Wilson"
                                                                 class="w-100"/>
                                                        </div>
                                                    </a>
                                                </div>
                                                <!--end::Avatar-->
                                                <!--begin::Name-->
                                                <a href="apps/ecommerce/customers/details.html"
                                                   class="text-gray-600
                                                   text-hover-primary">{{$orderContents['totalUSD'] ?? '' }}</a>
                                                <!--end::Name-->
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-sms fs-2 me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>Number of Items
                                            </div>
                                        </td>
                                        <td class="fw-bold text-end">
                                            <a href="apps/user-management/users/view.html"
                                               class="text-gray-600 text-hover-primary">{{count($usdItems)}}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-phone fs-2 me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>Last Updated
                                            </div>
                                        </td>
                                        <td class="fw-bold text-end">
                                            <x-display-date-formatted
                                                :date="$order->updated_at" format="D M j, Y @ g:i:sa"/>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Customer details-->
                    <!--begin::Documents-->
                    <div class="card card-flush py-4 flex-row-fluid">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Items (AE Credits)</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-300px">
                                    <tbody class="fw-semibold text-gray-600">
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-devices fs-2 me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                    <span class="path5"></span>
                                                </i>Amount
                                            </div>
                                        </td>
                                        <td class="fw-bold text-end">
                                            <a href="apps/invoices/view/invoice-3.html"
                                               class="text-gray-600
                                               text-hover-primary">{{$orderContents['totalAEC'] ?? ''}}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-truck fs-2 me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                    <span class="path5"></span>
                                                </i>Number of items
                                                <span class="ms-1" data-bs-toggle="tooltip"
                                                      title="View the shipping manifest generated by this order.">
																			<i class="ki-duotone ki-information-5 text-gray-500 fs-6">
																				<span class="path1"></span>
																				<span class="path2"></span>
																				<span class="path3"></span>
																			</i>
																		</span></div>
                                        </td>
                                        <td class="fw-bold text-end">
                                            <a href="#"
                                               class="text-gray-600 text-hover-primary">{{count($usdItems)}}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-discount fs-2 me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>Last Updated
                                                <span class="ms-1" data-bs-toggle="tooltip"
                                                      title="Reward value earned by customer when purchasing this order">
																			<i class="ki-duotone ki-information-5 text-gray-500 fs-6">
																				<span class="path1"></span>
																				<span class="path2"></span>
																				<span class="path3"></span>
																			</i>
																		</span></div>
                                        </td>
                                        <td class="fw-bold text-end">
                                            <x-display-date-formatted
                                                :date="$order->updated_at" format="D M j, Y @ g:i:sa"/>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Documents-->
                </div>
                <!--end::Order summary-->
                <!--begin::Tab content-->
                <div class="tab-content">
                    <!--begin::Tab pane-->
                    <div class="tab-pane fade show active" id="kt_ecommerce_sales_order_summary" role="tab-panel">
                        <!--begin::Orders-->
                        <div class="d-flex flex-column gap-7 gap-lg-10">
                            <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">

                                <!--begin::Product List-->
                                <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                                    <!--begin::Card header-->
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>Order #{{$order->id}}</h2>
                                        </div>
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <div class="table-responsive">
                                            <!--begin::Table-->
                                            <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                                <thead>
                                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                                    <th class="min-w-175px">Item</th>
                                                    <th class="min-w-100px text-end">Currency Type</th>
                                                    <th class="min-w-70px text-end">Qty</th>
                                                    <th class="min-w-100px text-end">Unit Price</th>
                                                    <th class="min-w-100px text-end">Total</th>
                                                </tr>
                                                </thead>
                                                <tbody class="fw-semibold text-gray-600">
                                                @foreach($orderContents['items'] as $item)

                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Thumbnail-->
                                                                <a href="apps/ecommerce/catalog/edit-product.html"
                                                                   class="symbol symbol-50px">
                                                            <span class="symbol-label"
                                                                  style="background-image:url({{$item['image']}});
                                                                  "></span>
                                                                </a>
                                                                <!--end::Thumbnail-->
                                                                <!--begin::Title-->
                                                                <div class="ms-5">
                                                                    <a href="apps/ecommerce/catalog/edit-product.html"
                                                                       class="fw-bold text-gray-600
                                                                   text-hover-primary">{{$item['name']}}</a>
                                                                    <div class="fs-7 text-muted">Expected Completion
                                                                        Date:

                                                                        <x-display-date-formatted
                                                                            :date="Carbon::parse($item['updated_at'])->addDay()"
                                                                            format="D M j, Y"/>
                                                                    </div>
                                                                </div>
                                                                <!--end::Title-->
                                                            </div>
                                                        </td>
                                                        <td class="text-end">{{$item['currency_type']}}</td>
                                                        <td class="text-end">{{$item['pivot']['quantity']}}</td>
                                                        <td class="text-end">
                                                            @if($item['currency_type'] === 'USD')
                                                                ${{ $item['price'] }}
                                                            @else
                                                                {{ $item['price']  }} AEC
                                                        @endif
                                                        <td class="text-end">
                                                            @if($item['currency_type'] === 'USD')
                                                                ${{ $item['price'] * $item['pivot']['quantity'] }}
                                                            @else
                                                                {{ $item['price'] * $item['pivot']['quantity'] }} AEC
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                @if (count($usdItems) > 0)
                                                    <tr>
                                                        <td colspan="4" class="fs-3 text-gray-900 text-end">USD Total
                                                        </td>
                                                        <td class="text-gray-900 fs-3 fw-bolder
                                                    text-end">${{$orderContents['totalUSD'] ?? ''}}
                                                        </td>
                                                    </tr>
                                                @endif

                                                @if (count($aecItems) > 0)
                                                    <tr>
                                                        <td colspan="4" class="fs-3 text-gray-900 text-end">AEC Total
                                                        </td>
                                                        <td class="text-gray-900 fs-3 fw-bolder
                                                        text-end">{{$orderContents['totalAEC'] ?? ''}} AE Credits
                                                        </td>
                                                    </tr>

                                                @endif
                                                </tbody>
                                            </table>
                                            <!--end::Table-->
                                        </div>
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Product List-->
                            </div>
                            <!--end::Orders-->
                        </div>
                        <!--end::Tab pane-->
                        <!--begin::Tab pane-->
                        <div class="tab-pane fade" id="kt_ecommerce_sales_order_history" role="tab-panel">
                            <!--begin::Orders-->
                            <div class="d-flex flex-column gap-7 gap-lg-10">
                                <!--begin::Order history-->
                                <div class="card card-flush py-4 flex-row-fluid">
                                    <!--begin::Card header-->
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>Order History</h2>
                                        </div>
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <div class="table-responsive">
                                            <!--begin::Table-->
                                            <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                                <thead>
                                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                                    <th class="min-w-100px">Date Added</th>
                                                    <th class="min-w-175px">Comment</th>
                                                    <th class="min-w-70px">Order Status</th>
                                                    <th class="min-w-100px">Customer Notifed</th>
                                                </tr>
                                                </thead>
                                                <tbody class="fw-semibold text-gray-600">
                                                <tr>
                                                    <td>12/01/2024</td>
                                                    <td>Order completed</td>
                                                    <td>
                                                        <!--begin::Badges-->
                                                        <div class="badge badge-light-success">Completed</div>
                                                        <!--end::Badges-->
                                                    </td>
                                                    <td>No</td>
                                                </tr>
                                                <tr>
                                                    <td>11/01/2024</td>
                                                    <td>Order received by customer</td>
                                                    <td>
                                                        <!--begin::Badges-->
                                                        <div class="badge badge-light-success">Delivered</div>
                                                        <!--end::Badges-->
                                                    </td>
                                                    <td>Yes</td>
                                                </tr>
                                                <tr>
                                                    <td>10/01/2024</td>
                                                    <td>Order shipped from warehouse</td>
                                                    <td>
                                                        <!--begin::Badges-->
                                                        <div class="badge badge-light-primary">Delivering</div>
                                                        <!--end::Badges-->
                                                    </td>
                                                    <td>Yes</td>
                                                </tr>
                                                <tr>
                                                    <td>09/01/2024</td>
                                                    <td>Payment received</td>
                                                    <td>
                                                        <!--begin::Badges-->
                                                        <div class="badge badge-light-primary">Processing</div>
                                                        <!--end::Badges-->
                                                    </td>
                                                    <td>No</td>
                                                </tr>
                                                <tr>
                                                    <td>08/01/2024</td>
                                                    <td>Pending payment</td>
                                                    <td>
                                                        <!--begin::Badges-->
                                                        <div class="badge badge-light-warning">Pending</div>
                                                        <!--end::Badges-->
                                                    </td>
                                                    <td>No</td>
                                                </tr>
                                                <tr>
                                                    <td>07/01/2024</td>
                                                    <td>Payment method updated</td>
                                                    <td>
                                                        <!--begin::Badges-->
                                                        <div class="badge badge-light-warning">Pending</div>
                                                        <!--end::Badges-->
                                                    </td>
                                                    <td>No</td>
                                                </tr>
                                                <tr>
                                                    <td>06/01/2024</td>
                                                    <td>Payment method expired</td>
                                                    <td>
                                                        <!--begin::Badges-->
                                                        <div class="badge badge-light-danger">Failed</div>
                                                        <!--end::Badges-->
                                                    </td>
                                                    <td>Yes</td>
                                                </tr>
                                                <tr>
                                                    <td>05/01/2024</td>
                                                    <td>Pending payment</td>
                                                    <td>
                                                        <!--begin::Badges-->
                                                        <div class="badge badge-light-warning">Pending</div>
                                                        <!--end::Badges-->
                                                    </td>
                                                    <td>No</td>
                                                </tr>
                                                <tr>
                                                    <td>04/01/2024</td>
                                                    <td>Order received</td>
                                                    <td>
                                                        <!--begin::Badges-->
                                                        <div class="badge badge-light-warning">Pending</div>
                                                        <!--end::Badges-->
                                                    </td>
                                                    <td>Yes</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <!--end::Table-->
                                        </div>
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Order history-->
                                <!--begin::Order data-->
                                <div class="card card-flush py-4 flex-row-fluid">
                                    <!--begin::Card header-->
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>Order Data</h2>
                                        </div>
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <div class="table-responsive">
                                            <!--begin::Table-->
                                            <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5">
                                                <tbody class="fw-semibold text-gray-600">
                                                <tr>
                                                    <td class="text-muted">IP Address</td>
                                                    <td class="fw-bold text-end">172.68.221.26</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">Forwarded IP</td>
                                                    <td class="fw-bold text-end">89.201.163.49</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">User Agent</td>
                                                    <td class="fw-bold text-end">Mozilla/5.0 (Windows NT 10.0; Win64;
                                                        x64)
                                                        AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110
                                                        Safari/537.36
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">Accept Language</td>
                                                    <td class="fw-bold text-end">en-GB,en-US;q=0.9,en;q=0.8</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <!--end::Table-->
                                        </div>
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Order data-->
                            </div>
                            <!--end::Orders-->
                        </div>
                        <!--end::Tab pane-->
                    </div>
                    <!--end::Tab content-->
                </div>
                <!--end::Order details page-->
            </div>
            <!--end::Content container-->
        </div>

    </div>
    <script>
        document.getElementById('canxForm').addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent the form from submitting immediately

            // Use SweetAlert to show a confirmation dialog
            Swal.fire({
                title: 'Confirm?',
                text: "This will cancel only those items that were paid with AE credits. For stripe payments please " +
                    "visit stripe.com and refund the payment there.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, do it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // User clicked 'Yes', submit the form
                    event.target.submit();
                }
            });
        });
    </script>
</x-dashboard.layout>
