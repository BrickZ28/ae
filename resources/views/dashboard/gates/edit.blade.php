<x-dashboard.layout>

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
                {{-- TODO IF user is waiting for starter logic--}}
                {{--                    TODO add function that notiifes when user picked up--}}
                <x-form-select id="contents-field" label="Add Contents" name="contents" required="">
                    <option value=''>Add Order or Starter Kit</option>
                    <option value='{{$starter->id ?? ''}}'>{{$starter->name ?? ''}}</option>
                    @foreach($orders as $order)
                        <option value={{$order->id}}>{{$order->id}}</option>
                    @endforeach
                </x-form-select>

                {{--                TODO this will only show when Dinos are hungry WEEKLY FEED--}}
                <x-form-select label="Feed" name="feed" required="">
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
