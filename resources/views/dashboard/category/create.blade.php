<x-dashboard.layout>

    <x-breadcrumbs title="Create Category" parent="categories" child="create" />
    <x-form :route="route('categories.store')" method="post" file="">
        <div class="row gx-10 mb-5">

            <div class="col-lg-12">
                <x-form-input label="Rule"
                              name="name"
                              value="{{old('name')}}"
                              placeholder="Insert Category"
                              required="required" />

                <!-- Example parent div with a specific width -->
                <x-form-input label="Description"
                              name="description"
                              value="{{old('name')}}"
                              placeholder="Breif description about the category"
                              required="" />


            </div>

            <!--end::Col-->
        </div>
    </x-form>
</x-dashboard.layout>
