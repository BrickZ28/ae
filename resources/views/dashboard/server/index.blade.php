<x-dashboard.layout>
    <x-datatable_shell breadcrumb-title="Servers" breadcrumb-parent="server management" breadcrumb-child="servers"
                       :$filters>

        @foreach($servers as $server)

            <tr>
                <td>{{$server->serverhost_id}}</td>
                <td class="d-flex align-items-center">
                    {{$server->name}}
                </td>
                <td>{{$server->slots}}</td>
                <td>
                    <x-display-date-formatted
                        :date="$server->end_date" format="D M j, Y @ g:i:sa" />
                </td>
                <td>{{$server->status}}</td>


            </tr>
        @endforeach

    </x-datatable_shell>

</x-dashboard.layout>
