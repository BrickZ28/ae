<x-dashboard.layout>
    <x-breadcrumbs title="Screenshots" parent="screenshot" child="create" />
    <x-form :route="route('screenshots.store')" method="post" file="yes">
        <div class="row gx-10 mb-5">
            <div class="col-lg-12">
                <x-form-input label="Title"
                              name="title"
                              value="{{ old('title') }}"
                              placeholder="Insert Title"
                              required="required"
                              infoTextColor=""
                              infoText=""
                />
                <x-file-upload label="Select Screenshot" file="file" />
            </div>
            <!--end::Col-->
        </div>
    </x-form>
</x-dashboard.layout>

