<x-dashboard.layout>
    <x-datatable_shell breadcrumb-title="Users" breadcrumb-parent="user management" breadcrumb-child="users" :$filters>

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
                    <form action="{{ route('playstyles.edit', $game->id) }}" method="get">
                        @csrf
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </form>
                </td>
                <td>
                    <form id="denyForm" action="{{ route('playstyles.destroy', $game->id) }}" method="POST">
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

</x-dashboard.layout>
