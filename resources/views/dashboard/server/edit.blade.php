<x-dashboard.layout>

    <x-breadcrumbs title="Add Settings" parent="server" child="edit" />
    <x-form :route="route('servers.update', $server->id)" method="patch" file="">
        <div class="row gx-10 mb-5">

            <div class="col-lg-12">
                <x-form-input label="Settings" name="settings" placeholder=""
                              required="required" />
            </div>

        </div>
    </x-form>
</x-dashboard.layout>