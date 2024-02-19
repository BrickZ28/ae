<x-dashboard.layout>

    <x-breadcrumbs title="Create Game" parent="games" child="create" />
    <x-form :route="route('games.store')" method="post" file="">
        <div class="row gx-10 mb-5">

            <div class="col-lg-12">
                <x-form-input label="API Game Name"
                              :value="old('api_name')"
                              name="api_name"
                              placeholder="MUST MATCH GAME CONFIG NAME exARK: Survival Evolved (PS 4)"
                              required="required"
                              infoText="MUST MATCH GAME CONFIG NAME ex ARK: Survival Evolved (PS 4)"
                              infoTextColor="text-warning"
                />

            </div>

            <div class="col-lg-12 mt-4">
                <x-form-input label="Game Name"
                              :value="old('display_name')"
                              name="display_name"
                              placeholder="Game that will show on a games played list"
                              required="required"
                              infoText="Game that will show on a games played list"
                              infoTextColor="text-info"
                />

            </div>
        </div>
    </x-form>
</x-dashboard.layout>
