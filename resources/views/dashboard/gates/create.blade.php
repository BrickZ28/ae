<x-dashboard.layout>

    <x-breadcrumbs title="Create Gate" parent="gate" child="create" />
    <x-form :route="route('gates.store')" method="post" file="">
        <div class="row gx-10 mb-5">

            <div class="col-lg-12">
                <x-form-input label="Gate Name"
                              name="gate_id"
                              placeholder="Gate Name"
                              value="{{old('name')}}"
                              required="required" />
            </div>
            <div class="col-lg-12">
                <x-form-input label="Gate Pin"
                              name="pin"
                              placeholder="Gate Pin"
                              value="{{old('pin')}}"
                              required="" />
            </div>

            <x-form-select label="Gate Play Style" name="playstyle" required="required">
                <option value="">Select One</option>
                @foreach($play_styles as $play_style)
                    <option value="{{$play_style->id}}">{{$play_style->name}}</option>
                @endforeach
            </x-form-select>

            <x-form-select label="Gate Game" name="game" required="required">
                <option value="">Select One</option>
                @foreach($games as $$game)
                    <option value="{{$game->id}}">{{$game->name}}</option>
                @endforeach
            </x-form-select>



            </div>

            <!--end::Col-->
        </div>
    </x-form>
</x-dashboard.layout>
