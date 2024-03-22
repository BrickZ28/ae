<x-dashboard.layout>
    <x-datatable_shell breadcrumb-title="Items" breadcrumb-parent="View Items" breadcrumb-child="items" :$filters>

        @foreach($items as $item)

            <tr>
                <td>{{$item->image}}</td>
                <td> {{$item->name}} </td>
                <td>{{$item->price}} {{$item->currency_type}}</td>

                <td>
                    <x-display-date-formatted
                        :date="$item->updated_at" format="D M j, Y @ g:i:sa"/>
                </td>
                <td>
                    <x-dashboard-draggable-modal buttonText="View Item"
                                                 :title="$item->name . ' image'"
                                                 :id="$item->id">
                        <img src="{{ $item->image}}" alt="Name Not Found"
                             class="w-100"/>
                        <p class="mt-3">{{$item->description}}</p>
                    </x-dashboard-draggable-modal>
                </td>
                <td>
                    <form class="add-to-cart-form" action="{{ route('carts.store', $item->id) }}" method="post">
                        @csrf
                        <input type="hidden" name="quantity" value="1">
                        <input type="hidden" name="id" value="{{$item->id}}">
                        <button type="button" class="btn btn-info add-to-cart-button">Add</button>
                    </form>
                </td>
                <td>
                    <form  action="{{ route('carts.show', $item->id) }}" method="get">
                        @csrf
                        <button type="submit" class="btn btn-success">Cart</button>
                    </form>
                </td>

            </tr>
        @endforeach

    </x-datatable_shell>

</x-dashboard.layout>
