<x-dashboard.layout>

    <x-breadcrumbs title="Create Setting" parent="settings" child="create" />
    <x-form :route="route('rules.store')" method="post" file="">
        <div class="row gx-10 mb-5">

            <div class="col-lg-12">
                <x-form-input label="Rule" name="rule" placeholder="{{old('rule' ?? 'Insert Rule')}}"
                              required="required" />

                <x-form-select label="Priority" name="priority" required="required" >
                    <option value="">Select One</option>
                    <option value=1>1</option>
                    <option value=2>2</option>
                </x-form-select>

            </div>

            <!--end::Col-->
        </div>
    </x-form>
</x-dashboard.layout>
