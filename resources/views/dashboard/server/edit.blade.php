<x-dashboard.layout>

    <x-breadcrumbs title="Add Settings" parent="server" child="edit" />
    <x-form :route="route('servers.update', $server->id)" method="patch" file="yes">
        <div class="row gx-10 mb-5">



            <x-file-upload label="Add Settings File" file="file" />

        </div>
    </x-form>
</x-dashboard.layout>
