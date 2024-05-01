<x-dashboard.layout>
    <x-datatable_shell breadcrumb-title="Users" breadcrumb-parent="user management" breadcrumb-child="users" :$filters>

        @foreach($items as $item)

            <tr>
                <td>{{$item->name}}</td>
                <td> {{$item->category->name}} </td>
                <td>{{$item->price}} {{$item->currency_type}}</td>

                <td><x-display-date-formatted
                        :date="$item->updated_at" format="D M j, Y @ g:i:sa" /></td>
                <td>
                    <x-dashboard-draggable-modal buttonText="View Item"
                                                 :title="$item->name . ' image'"
                                                 :id="$item->id">
                        <img src="{{ $item->image}}" alt="Name Not Found"
                             class="w-100"/>
                        <p class="mt-3">{{$item->description}}</p>

                        <!-- Add to cart form -->
                        <form class="add-to-cart-form" action="{{ route('carts.store', $item->id) }}" method="post">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <input type="hidden" name="id" value="{{$item->id}}">
                            <button type="submit" class="btn btn-info add-to-cart-button">Add to Cart</button>
                        </form>
                    </x-dashboard-draggable-modal>
                </td>
                <td>
                    <form action="{{ route('items.edit', $item->id) }}" method="get">
                        @csrf
                        <button type="submit" class="btn btn-info">Edit</button>
                    </form>
                </td>
                <td>
                    <form id="denyForm" action="{{ route('items.destroy', $item->id) }}" method="POST">
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
