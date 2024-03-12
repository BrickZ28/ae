<x-dashboard.layout>

    <x-breadcrumbs title="Edit Category" parent="categories" child="edit" />
    <x-form :route="route('categories.update', $category->id)" method="patch" file="">
        <div class="row gx-10 mb-5">

            <div class="col-lg-12">
                <x-form-input label="Category Name"
                              :value="$category->name"
                              name="name"
                              placeholder=""
                              required="required"
                              infoText=""
                              infoTextColor=""
                />

            </div>

            <div class="col-lg-12 mt-4">
                <x-form-input label="Category Description"
                              :value="$category->description"
                              name="description"
                              placeholder=""
                              required=""
                              infoText=""
                              infoTextColor=""
                />

            </div>

            <!--end::Col-->
        </div>
    </x-form>
</x-dashboard.layout>
