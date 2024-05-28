<x-dashboard.layout>

    <x-breadcrumbs title="Create Status" parent="status" child="create"/>
    <x-form :route="route('statuses.store')" method="post" file="">
        <div class="row gx-10 mb-5">

            <div class="col-lg-12">
                <x-form-input label="Status" name="status" placeholder="{{old('status' ?? 'Insert Status')}}"
                              required="required"/>
                <x-form-select label="Color" name="color" required="yes">


                    <option value="primary">Primary</option>
                    <option value="secondary">Secondary</option>
                    <option value="success">Success</option>
                    <option value="info">Info</option>
                    <option value="warning">Warning</option>
                    <option value="danger">Danger</option>

                </x-form-select>


                <span class="badge py-3 px-4 fs-7 badge-light-primary">Primary</span>
                <span class="badge py-3 px-4 fs-7 badge-light-secondary">Secondary</span>
                <span class="badge py-3 px-4 fs-7 badge-light-success">Success</span>
                <span class="badge py-3 px-4 fs-7 badge-light-info">Info</span>
                <span class="badge py-3 px-4 fs-7 badge-light-warning">Warning</span>
                <span class="badge py-3 px-4 fs-7 badge-light-danger">Danger</span>
            </div>

            <!--end::Col-->
        </div>
    </x-form>
</x-dashboard.layout>
