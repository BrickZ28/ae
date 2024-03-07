<x-dashboard.layout>
    <x-datatable_shell breadcrumb-title="Play Styles" breadcrumb-parent="play style management"
                       breadcrumb-child="playstyle"
                       :$filters>

        @foreach($styles as $style)

            <tr>
                <td>{{$style->id}}</td>
                <td>{{$style->name}}</td>
                <td>
                    <x-display-date-formatted
                        :date="$style->created_at" format="D M j, Y @ g:i:sa" />
                </td>
                <td>
                    <x-display-date-formatted
                        :date="$style->updated_at" format="D M j, Y @ g:i:sa" />
                </td>
                <td>
                    <form action="{{ route('playstyles.edit', $style->id) }}" method="get">

                        @csrf
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </form>
                </td>
                <td>
                    <form id="denyForm" action="{{ route('playstyles.destroy', $style->id) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
                <td>
                    <x-dashboard-draggable-modal buttonText="Servers"
                                                 :title="$style->name"
                                                 :id="$style->id">
                        <ul>
                            @foreach($style->servers as $server)
                                <li>
                                    <a href="{{route('servers.show', $server->id)}}">{{$server->display_name}}</a>
                                </li>
                            @endforeach
                        </ul>

                    </x-dashboard-draggable-modal>
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
                text: "This will delete the playstyle from the website and can break stuff?",
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
