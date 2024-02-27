@php use App\Models\Screenshot; @endphp
<x-dashboard.layout>
    <x-datatable_shell breadcrumb-title="Images" breadcrumb-parent="pending" breadcrumb-child="view"
                       :$filters>

        @foreach($pending_screenshots as $screenshot)


            <tr>
                <td>{{$screenshot->title}}</td>
                <td class="d-flex align-items-center">
                    <!--begin:: Avatar -->
                    <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                        <a class href="{{route('screenshots.show', $screenshot->id)}}">
                            <div class="symbol-label">
                                <img src="{{ $screenshot->path}}" alt="Name Not Found"
                                     class="w-100"/>
                            </div>
                        </a>
                    </div>
                </td>

                <td>{{$screenshot->uploader->userProfile?->global_name}}</td>
                <td>
                    <x-dashboard-draggable-modal buttonText="View Image"
                                                 :title="$screenshot->uploader->userProfile?->global_name . ' image'"
                                                 :id="$screenshot->id">
                        <img src="{{ $screenshot->path}}" alt="Name Not Found"
                             class="w-100"/>
                    </x-dashboard-draggable-modal>
                </td>
                <td >
                    <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm"
                       data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                        <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                    <!--begin::Menu-->
                    <div
                        class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                        data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="{{route('users.edit', $user->id)}}" class="menu-link px-3">Approve</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="{{route('profiles.show', $user->id)}}" class="menu-link px-3" >Delete
                                Profile</a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu-->
                </td>
            </tr>
        @endforeach

    </x-datatable_shell>

</x-dashboard.layout>
