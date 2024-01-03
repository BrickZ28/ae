<x-dashboard.layout>
    <x-datatable_shell breadcrumb-title="Users" breadcrumb-parent="user management" breadcrumb-child="users" :$filters>

        @foreach($rules as $rule)

            <tr>
                <td>{{$rule->id}}</td>
                <td class="d-flex align-items-center">
                    {{$rule->priority}}
                </td>
                <td>{{$rule->rule}}</td>
                <td>
                    <x-display-date-formatted
                        :date="$rule->updated_at" format="D M j, Y @ g:i:sa" />
                </td>
                <td><x-display-date-formatted
                        :date="$rule->created_at" format="D M j, Y @ g:i:sa" /></td>
                <td>{{$rule->user->username}}</td>
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
                            <a href="apps/user-management/users/view.html" class="menu-link px-3">Edit</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-kt-users-table-filter="delete_row">Delete</a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu-->
                </td>
            </tr>
        @endforeach

    </x-datatable_shell>

</x-dashboard.layout>
