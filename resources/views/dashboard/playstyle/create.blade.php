<x-dashboard.layout>

    <x-breadcrumbs title="Create Playstyle" parent="playstyle" child="create" />
    <x-form :route="route('playstyles.store')" method="post" file="">
        <div class="row gx-10 mb-5">

            <div class="col-lg-12">
                <x-form-input label="Play Style"
                              name="name"
                              placeholder="Style"
                              value="{{old('name')}}"
                              required="required" />



            </div>

            <!--end::Col-->
        </div>
    </x-form>
</x-dashboard.layout>
