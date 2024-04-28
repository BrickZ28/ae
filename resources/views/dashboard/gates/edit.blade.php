<x-dashboard.layout>


    <!--begin::Alert-->
    @if($gate->last_fed <= \Carbon\Carbon::now()->subDays(7))
        <div class="alert alert-dismissible bg-danger d-flex flex-column flex-sm-row p-5 mb-10">
            <!-- Your alert code here -->
            <h4 class="mb-2 light">HUNGRY DINO</h4>
            <span>Please check the gate and make sure the dino has been fed and update below</span>
            <!-- Your alert code here -->
        </div>
    @endif

    @if($no_kit_users)
        <div class="alert alert-dismissible bg-info d-flex flex-column flex-sm-row p-5 mb-10">
            <!-- Your alert code here -->
            <h4 class="mb-2 light">PLAYER NEEDS KIT</h4>

                <ul>
                    @foreach($no_kit_users as $no_kit_user)
                    <li>                <span>{{$no_kit_user->username}} did not get a kit on registration cause there were none to issue. Please issue a gate to this user</span>
                    </li>
                    @endforeach
                </ul>

            <!-- Your alert code here -->
        </div>
    @endif
    <!--end::Alert-->
    <x-breadcrumbs title="Edit Gate" parent="gates" child="edit"/>
    <x-form :route="route('gates.update', $gate->id)" method="patch" file="">
        <div class="row gx-10 mb-5">

            <div class="col-lg-12">
                <x-form-input label="Gate" value="{{$gate->gate_id}}" name="gate_id" placeholder=""
                              required="required"/>

                <x-form-input id="pin-field" label="Pin" value="{{$gate->pin}}" name="pin" placeholder=""
                              required=""/>

                <x-form-select id="player-field" label="Player" name="player" required="">
                    <option value={{$gate->player->id ?? ''}}>{{$gate->player->username ?? 'Select User'}}</option>
                    @foreach($users as $user)
                        <option value={{$user->id}}>{{$user->username}}</option>
                    @endforeach
                </x-form-select>
                {{--                TODO populate with Orders cant be edited within 1 week with of addeing if not starter

                {{--                    TODO add function that notiifes when user picked up--}}
                <x-form-select id="contents-field" label="Add Contents" name="contents" required="">
                    <option value=''>Add Order or Starter Kit</option>
                    <option value='{{$starter->id ?? ''}}'>{{$starter->name ?? ''}}</option>
                    @foreach($orders as $order)
                        <option value={{$order->id}}>{{$order->id}}</option>
                    @endforeach
                </x-form-select>


                <x-form-select label="Feed Dino" name="feed" required="">
                    <option value=>If Hungry Feed</option>
                    <option value=1>Yes</option>
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

        // Add event listeners
        document.getElementById('player-field').addEventListener('change', checkForChanges);
        document.getElementById('contents-field').addEventListener('change', checkForChanges);

        function checkForChanges() {
            // Get current values
            let currentPlayer = document.getElementById('player-field').value;
            let currentContents = document.getElementById('contents-field').value;
            let currentPin = document.getElementById('pin-field').value;

            // Check if player or contents have changed and pin has not
            if ((currentPlayer !== initialPlayer || currentContents !== initialContents) && currentPin === initialPin) {
                // Prevent form submission and show SweetAlert
                event.preventDefault();
                Swal.fire({
                    title: 'Confirm?',
                    text: "The player or contents have changed, but the pin has not. Do you want to proceed?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, do it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // User clicked 'Yes', submit the form
                        document.getElementById('denyForm').submit();
                    }
                });
            }
        }
    </script>
</x-dashboard.layout>
