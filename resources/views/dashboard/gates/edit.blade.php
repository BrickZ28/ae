<x-dashboard.layout>

    <x-breadcrumbs title="Edit Gate" parent="gates" child="edit" />
    <x-form :route="route('gates.update', $gate->id)" method="patch" file="">
        <div class="row gx-10 mb-5">

            <div class="col-lg-12">
                <x-form-input label="Gate" value="{{$gate->gate_id}}" name="gate_id" placeholder=""
                              required="required" />

                <x-form-input label="Pin" value="{{$gate->pin}}" name="pin" placeholder=""
                              required="" />

                <x-form-select label="Player" name="player" required="" >
                    <option value={{$gate->player->id ?? ''}}>{{$gate->player->username ?? 'Select User'}}</option>
                    @foreach($users as $user)
                        <option value={{$user->id}}>{{$user->username}}</option>
                    @endforeach
                </x-form-select>
{{--                TODO populate with Orders cant be edited within 1 week with of addeing if not starter
                    add function that notiifes when user picked up--}}
                <x-form-select label="Add Contents" name="contents" required="" >
                    <option value=''>Add Order or Starter Kit</option>
                    <option value='{{$starter->id ?? ''}}'>{{$starter->name ?? ''}}</option>
                    @foreach($orders as $order)
                        <option value={{$order->id}}>{{$order->id}}</option>
                    @endforeach
                </x-form-select>

{{--                TODO this will only show when Dinos are hungry--}}
                <x-form-select label="Feed" name="feed" required="" >
                    <option value=>If Hungry Feed</option>
                    <option value=1>Yes</option>
                </x-form-select>

            </div>

            <!--end::Col-->
        </div>
    </x-form>
</x-dashboard.layout>
