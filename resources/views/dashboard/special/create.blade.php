<x-dashboard.layout>

    <x-breadcrumbs title="Create Special" parent="specials" child="create"/>
    <x-form :route="route('specials.store')" method="post" file="">

        <div class="row gx-10 mb-5">
            <x-form-input label="Title*"
                          name="title"
                          placeholder=""
                          value="{{ old('title') }}"
                          info-text=""
                          info-text-color=""
                          required="yes"
            />

            <x-form-input label="Description*"
                          name="description"
                          placeholder=""
                          value="{{ old('description') }}"
                          info-text=""
                          info-text-color=""
                          required="ues"
            />

            <x-form-input label="Discount (%)"
                          name="discount"
                          placeholder=""
                          value="{{ old('discount') }}"
                          info-text=""
                          info-text-color=""
                          required=""
            />

            <x-form-datetime label="Date Range*"
                             name="dates"

            />
            <x-form-input label="Usage Limit"
                          name="usage_limit"
                          type="number"
                          placeholder=""
                          value="{{ old('usage_limit') }}"
                          info-text=""
                          info-text-color=""
                          required=""
            />

            <x-form-checkbox label="Active"
                             :checked="old('active')"
                             name="status"

            />
        </div>

    </x-form>


</x-dashboard.layout>
