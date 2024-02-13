<x-dashboard.layout>

    <x-breadcrumbs title="Create Server" parent="server" child="create" />
    <x-form :route="route('servers.store')" method="post" file="">
        <div class="row gx-10 mb-5">

            <div class="col-lg-12">
                <x-form-input label="Server" name="name" placeholder="{{old('server' ?? 'Server Name')}}"
                              required="required" />

                <x-form-input label="Server IP" name="ip" placeholder="{{old('server' ?? 'Server IP')}}"
                              required="" />

            </div>

            <!--end::Col-->
        </div>
    </x-form>
</x-dashboard.layout>
