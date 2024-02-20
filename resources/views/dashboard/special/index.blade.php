<x-dashboard.layout>
    <x-datatable_shell breadcrumb-title="Specials" breadcrumb-parent="special management" breadcrumb-child="specials"
                       :$filters>

        @foreach($specials as $special)

            <tr>
                <td>{{ ucfirst($special->title) }}</td>
                <td>
                    <x-display-date-formatted :date="$special->start_date" format="D M j, Y @ g:i:sa" />
                </td>
                <td>
                    <x-display-date-formatted :date="$special->end_date" format="D M j, Y @ g:i:sa" />
                </td>
                <td>{{ $special->active ? 'Yes' : 'No' }}</td>
                <td>{{ $special->discount }}</td>
                <td>{{ $special->usage_limit }}</td>
                <td class="text-end">
                    <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm"
                       data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                        <i class="ki-duotone ki-down fs-5 ms-1"></i>
                    </a>
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                         data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="{{ route('specials.edit', $special->id) }}" class="menu-link px-3">Edit</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="{{ route('specials.show', $special->id) }}" class="menu-link px-3">View</a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                </td>
            </tr>

            </tr>
        @endforeach

    </x-datatable_shell>

</x-dashboard.layout>
