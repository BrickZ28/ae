<x-dashboard.layout>

    <x-breadcrumbs title="Update Special" parent="specials" child="update"/>
    <x-form :route="route('specials.update', $special->id)" method="put" file="">

        <div class="row gx-10 mb-5">
            <x-form-input label="Title*"
                          name="title"
                          placeholder=""
                          value="{{ $special->title }}"
                          info-text=""
                          info-text-color=""
                          required="yes"
            />

            <x-form-input label="Description*"
                          name="description"
                          placeholder=""
                          value="{{ $special->description }}"
                          info-text=""
                          info-text-color=""
                          required="ues"
            />

            <x-form-input label="Discount (%)"
                          name="discount"
                          placeholder=""
                          value="{{ $special->discount }}"
                          info-text=""
                          info-text-color=""
                          required=""
            />

            <x-form-datetime label="Date Range*"
                             name="dates"
                             :value="date('Y-m-d', strtotime($special->start_date)) . ' - ' . date('Y-m-d', strtotime($special->end_date))"

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
                             name="active"
                             value="1"
                             checked="{{ old('active') == 1 || $special->active ? 'checked' : '' }}"
                             />





        </div>

    </x-form>


</x-dashboard.layout>
