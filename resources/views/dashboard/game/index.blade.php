<x-dashboard.layout>
    <x-datatable_shell breadcrumb-title="Users" breadcrumb-parent="user management" breadcrumb-child="users" :$filters>

        @foreach($games as $game)

            <tr>
                <td>{{$game->id}}</td>
                <td>{{$game->api_name}}</td>
                <td>{{$game->display_name}}</td>

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
                            <a href="{{route('games.edit', $game->id)}}" class="menu-link px-3">Edit</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="{{route('games.show', $game->id)}}" class="menu-link px-3">View</a>
                        </div>
                        <!--end::Menu item-->
                    </div>













                    <!--end::Menu-->
                </td>
            </tr>
        @endforeach

    </x-datatable_shell>

</x-dashboard.layout>
