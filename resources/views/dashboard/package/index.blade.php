<x-dashboard.layout>
    <x-datatable_shell breadcrumb-title="Packages" breadcrumb-parent="package management" breadcrumb-child="users"
                       :$filters>

        @foreach($packages as $package)

            <tr>
                <td>{{$package->name}}</td>
                <td>{{$package->price}} {{$package->currency_type}}</td>
                <td>{{$package->active ? 'Yes': 'No'}}</td>
                <td><x-display-date-formatted
                        :date="$package->updated_at" format="D M j, Y @ g:i:sa" /></td>
                <td>
                    <x-dashboard-draggable-modal buttonText="View Package"
                                                 :title="$package->name . ' image'"
                                                 :id="$package->id">
                        <img src="{{ $package->image}}" alt="Name Not Found"
                             class="w-100"/>
                        <p class="mt-3">
                        Details:
                        <ul>
                            <li>Price: {{$package->price}} {{$package->currency_type}}</li>
                            <li>Active: {{$package->active ? 'Yes': 'No'}}</li>
                            <li>Updated At: <x-display-date-formatted
                                    :date="$package->updated_at" format="D M j, Y @ g:i:sa" /></li>
                        </ul>
                        Items in Package:
                        <ul>
                            @foreach($package->items as $item)
                                <li>{{$item->name}}</li>
                            @endforeach
                        </ul>
                        </p>
                    </x-dashboard-draggable-modal>
                </td>
                <td>
                    <form action="{{ route('packages.edit', $package->id) }}" method="get">
                        @csrf
                        <button type="submit" class="btn btn-info">Edit</button>
                    </form>
                </td>
                <td>
                    <form id="denyForm" action="{{ route('packages.destroy', $package->id) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>

            </tr>
        @endforeach

    </x-datatable_shell>
    <script>
        document.getElementById('denyForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the form from submitting immediately

            // Use SweetAlert to show a confirmation dialog
            Swal.fire({
                title: 'Confirm?',
                text: "This will delete the item from the website and can break stuff?",
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
