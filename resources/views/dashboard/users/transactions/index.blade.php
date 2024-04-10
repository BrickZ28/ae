<x-dashboard.layout>
    <x-datatable_shell breadcrumb-title="Transactions" breadcrumb-parent="transactions" breadcrumb-child="history"
                       :$filters>
        @foreach($user->transactions as $transaction)

            <tr>
                <td>{{$transaction->id}}</td>
                <td>{{$transaction->amount}}</td>
                <td>{{$transaction->reason}}</td>
                <td>{{$transaction->item->name ?? $transaction->package->name ?? ''}}</td>
                <td><x-display-date-formatted
                        :date="$transaction->created_at" format="D M j, Y @ g:i:sa" /></td>
                <td>{{$transaction->transaction_type}} initiated</td>
                <td>
                    <form action="">
                        <button class="btn btn-sm btn-primary" type="submit">View</button>
                    </form>
                </td>
            </tr>
        @endforeach

    </x-datatable_shell>

</x-dashboard.layout>
