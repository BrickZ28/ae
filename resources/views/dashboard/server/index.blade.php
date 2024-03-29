<x-dashboard.layout>
    <x-datatable_shell breadcrumb-title="Servers" breadcrumb-parent="server management" breadcrumb-child="servers"
                       :$filters>

        @foreach($servers as $server)

            <tr>
                <td>{{$server->display_name}}</td>
                <td>
                    {{$server->playstyle->name}}
                </td>
                <td>{{$server->slots}}</td>

                <td>{{$server->game->display_name}}</td>
                <td>{{$server->status}}</td>
                <td>{{$server->name}}</td>
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
                            <a href="{{route('servers.show', $server->id)}}" class="menu-link px-3">View</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="{{route('servers.edit', $server->id)}}" class="menu-link px-3">Edit</a>
                        </div>
                        <div class="menu-item px-3">
                            <form id="denyForm{{$server->id}}" action="{{ route('servers.destroy', $server->id) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>

                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu-->
                </td>
            </tr>
        @endforeach
            <script>
                @foreach($servers as $server)
                document.getElementById('denyForm{{$server->id}}').addEventListener('submit', function(event) {
                    event.preventDefault(); // Prevent the form from submitting immediately

                    // Use SweetAlert to show a confirmation dialog
                    Swal.fire({
                        title: 'Confirm?',
                        text: "This will delete the server from the website",
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
                @endforeach
            </script>
    </x-datatable_shell>



</x-dashboard.layout>
