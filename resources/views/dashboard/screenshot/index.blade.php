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
                <td>
                    <form id="approveForm" action="{{ route('screenshots.approve', $screenshot->id) }}" method="POST" >
                        @method('PATCH')
                        @csrf
                            <button type="submit" class="btn btn-success">Approve</button>
                    </form>
                </td>
                <td>
                    <form id="denyForm" action="{{ route('screenshots.destroy', $screenshot->id) }}" method="POST">
                        @method('DELETE')
                        @csrf
                            <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
                <td><x-display-date-formatted
                        :date="$screenshot->created_at" format="D M j, Y @ g:i:sa" /></td>
            </tr>
        @endforeach


    </x-datatable_shell>
    <script>
        document.getElementById('approveForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the form from submitting immediately

            // Use SweetAlert to show a confirmation dialog
            Swal.fire({
                title: 'Confirm?',
                text: "This will allow the image to be displayed on the website. Are you sure you want to approve " +
                    "this image?",
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
    <script>
        document.getElementById('denyForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the form from submitting immediately

            // Use SweetAlert to show a confirmation dialog
            Swal.fire({
                title: 'Confirm?',
                text: "This will delete the image from the website. Are you sure you want to delete " +
                    "this image?",
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
