<x-dashboard.layout>

    <x-breadcrumbs title="Edit Gate" parent="gates" child="edit" />
    <x-form :route="route('gates.update', $rule->id)" method="patch" file="">
        <div class="row gx-10 mb-5">

            <div class="col-lg-12">
                <x-form-input label="Gate" value="{{$gate->gate_id}}" name="gate_id" placeholder=""
                              required="required" />

                <x-form-input label="Pin" value="{{$gate->pin}}" name="pin" placeholder=""
                              required="" />

                <x-form-select label="Player" name="player" required="" >
                    <option value={{$gate->player->id ?? ''}}>{{$gate->player->username ?? 'Select User'}}</option>
                    @foreach($players as $player)
                        <option value={{$player->id}}>{{$player->username}}</option>
                    @endforeach
                </x-form-select>

                <x-form-select label="Priority" name="priority" required="required" >
                    <option value={{$gate->playstyle->id}}>{{$gate->playstyle->name ?? 'Select User'}}</option>
                    @foreach($playstyles as $playstyle)
                        <option value={{$playstyle->id}}>{{$playstyle->name}}</option>
                    @endforeach
                </x-form-select>

            </div>

            <!--end::Col-->
        </div>
    </x-form>
</x-dashboard.layout>
