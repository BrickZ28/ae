<x-dashboard.layout>
    <x-datatable_shell breadcrumb-title="Items" breadcrumb-parent="View Items" breadcrumb-child="items" :$filters>

        @foreach($items as $item)

            <tr>
                <td>{{$item->image}}</td>
                <td> {{$item->name}} </td>
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
                    <form id="denyForm" action="{{ route('carts.show', $item->id) }}" method="get">
                                               @csrf
                        <button type="submit" class="btn btn-danger">Cart</button>
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



document.querySelectorAll('.add-to-cart-button').forEach(function(button) {
    button.addEventListener('click', function(event) {
        Swal.fire({
            html: '<p style="color:#c5c3c3;">Enter the quantity you wish to buy</p>',
            input: 'number',
            inputAttributes: {
                autocapitalize: 'off',
                style: 'color:white'
            },
            showCancelButton: true,
            confirmButtonText: 'Add',
            showLoaderOnConfirm: true,
            preConfirm: (quantity) => {
                if (quantity > 0) {
                    var form = event.target.closest('.add-to-cart-form');
                    form.querySelector('input[name="quantity"]').value = quantity;
                    form.submit();
                } else {
                    Swal.showValidationMessage(`Please enter a valid quantity`);
                }
            },
            allowOutsideClick: () => !Swal.isLoading()
        });
    });
});
    </script>
</x-dashboard.layout>
