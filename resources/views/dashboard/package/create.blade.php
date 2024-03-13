<x-dashboard.layout>

    <x-breadcrumbs title="Create Package" parent="packages" child="create" />
    <x-form :route="route('packages.store')" method="post" file="yes">
        <div class="row gx-10 mb-5">

            <div class="col-lg-12">
                <x-form-input label="Package Name"
                              name="name"
                              value="{{old('name')}}"
                              placeholder="Create a name for the Package"
                              required="required" />

                <!-- Example parent div with a specific width -->
                <x-form-input label="Description"
                              name="description"
                              value="{{old('description')}}"
                              placeholder="List Items in Package"
                              required="required" />

                <x-form-checkbox label="Visible In Store"
                                 name="visible"
                                 checked="{{ old('active') == 1 ? 'checked' : '' }}"
                />


            </div>

            <!--end::Col-->
        </div>
    </x-form>
</x-dashboard.layout>
