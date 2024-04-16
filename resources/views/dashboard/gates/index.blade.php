<x-dashboard.layout>
    <x-datatable_shell breadcrumb-title="Gates" breadcrumb-parent="gate management" breadcrumb-child="gates"
                       :$filters>

        @foreach($gates as $gate)
            <tr>
                <td>{{$gate->gate_id}}</td>
                <td>{{$gate->pin}}</td>
                <td>{{$gate->player->username ?? 'Not Assigned'}}</td>
                <td>{{$gate->playstyle->name}}</td>
                <td><x-display-date-formatted
                        :date="$gate->last_fed" format="D M j, Y @ g:i:sa" /></td>
                <td>{{$gate->admin->username ?? 'Empty Gate'}}</td>

                <td>
                    <form action="{{ route('gates.edit', $gate->id) }}" method="get">
                        @csrf
                        <button type="submit" class="btn btn-info">Edit</button>
                    </form>
                </td>


            </tr>
        @endforeach

    </x-datatable_shell>

</x-dashboard.layout>
