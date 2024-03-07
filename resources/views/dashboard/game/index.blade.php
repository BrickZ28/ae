<x-dashboard.layout>
    <x-datatable_shell breadcrumb-title="Games" breadcrumb-parent="game management" breadcrumb-child="games" :$filters>

        @foreach($games as $game)

            <tr>
                <td>{{$game->id}}</td>
                <td>{{$game->api_name}}</td>
                <td>{{$game->display_name}}</td>
                <td>
                    <x-display-date-formatted
                        :date="$game->created_at" format="D M j, Y @ g:i:sa" />
                </td>
                <td>
                    <form action="{{ route('games.edit', $game->id) }}" method="get">
                        @csrf
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </form>
                </td>
                <td>
                    <form id="denyForm" action="{{ route('games.destroy', $game->id) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
                <td>
                    <x-dashboard-draggable-modal buttonText="Servers"
                                                 :title="$game->name"
                                                 :id="$game->id">
                        <ul>
                            @foreach($game->servers as $server)
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
                text: "This will delete the games from the website and can break stuff?",
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
