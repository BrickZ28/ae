<x-dashboard.layout>
    <x-datatable_shell breadcrumb-title="Gates" breadcrumb-parent="gate management" breadcrumb-child="gates"
                       :$filters>


        @foreach($orders as $order)
            <tr>
                <td>{{$order->id}}</td>
                <td>{{$order->user->userProfile->global_name}}</td>
                <td><span class="badge py-3 px-4 fs-7 badge-light-{{ $order->status->color }}">
                {{ $order->status->name ?? 'Unknown' }}
            </span></td>
                <td>{{$order->processedBy->username ?? ''}}</td>
                <td>
                    <x-display-date-formatted
                        :date="$order->created_at" format="D M j, Y @ g:i:sa"/>
                </td>
                <td>
                    <x-display-date-formatted
                        :date="$order->updated_at" format="D M j, Y @ g:i:sa"/>
                </td>

                <td class="text-end">
                    <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm"
                       data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                        <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                    <!--begin::Menu-->
                    <div
                        class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                        data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="{{route('orders.edit', $order->id)}}" class="menu-link px-3">Edit</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="{{route('orders.show', $order->id)}}" class="menu-link px-3">View
                                Order</a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu-->
                </td>


            </tr>
        @endforeach

    </x-datatable_shell>

</x-dashboard.layout>
