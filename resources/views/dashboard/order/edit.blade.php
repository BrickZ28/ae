<x-dashboard.layout>

    <x-breadcrumbs title="Edit Order" parent="orders" child="edit"/>
    <x-form :route="route('orders.update', $order->id)" method="patch" file="">
        <div class="row gx-10 mb-5">

            <div class="col-lg-12">
                <x-form-select label="Status" name="status" required="">
                    <option value="{{$order->status ?? ''}}">{{$order->status->name ?? 'Select Status'}}</option>
                    @foreach($statuses as $status)
                        <option value="{{$status->id}}">{{$status->name}}</option>
                    @endforeach
                </x-form-select>
            </div>

            <!--end::Col-->
        </div>


    </x-form>

    <script>
        // Store initial values
        let initialPlayer = document.getElementById('player-field').value;
        let initialContents = document.getElementById('contents-field').value;
        let initialPin = document.getElementById('pin-field').value;

        // Get the form element
        let form = document.querySelector('form');

        // Add event listener to the form's submit event
        form.addEventListener('submit', function (event) {
            // Get current values
            let currentPlayer = document.getElementById('player-field').value;
            let currentContents = document.getElementById('contents-field').value;
            let currentPin = document.getElementById('pin-field').value;

            // Check if a user is selected and if player or contents have changed and pin has not
            if (currentPlayer && (currentPlayer !== initialPlayer || currentContents !== initialContents) && currentPin === initialPin) {
                // Prevent form submission and show SweetAlert
                event.preventDefault();
                Swal.fire({
                    title: 'Confirm?',
                    text: "The player or contents have changed, but the pin has not. Update pin to escape this message or click OK to proceed with the info.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // User clicked 'OK', submit the form
                        form.submit();
                    }
                });
            }
        });
    </script>
</x-dashboard.layout>
