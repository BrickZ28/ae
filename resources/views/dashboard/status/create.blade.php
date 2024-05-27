<x-dashboard.layout>

    <x-breadcrumbs title="Create Status" parent="status" child="create"/>
    <x-form :route="route('statuses.store')" method="post" file="">
        <div class="row gx-10 mb-5">

            <div class="col-lg-12">
                <x-form-input label="Status" name="status" placeholder="{{old('status' ?? 'Insert Status')}}"
                              required="required"/>


            </div>

            <!--end::Col-->
        </div>
    </x-form>
</x-dashboard.layout>
