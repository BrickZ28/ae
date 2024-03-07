<x-dashboard.layout>

    <x-breadcrumbs title="Edit Server {{$server->name}}" parent="server" child="edit" />
    <x-form :route="route('servers.update', $server->id)" method="patch" file="yes">
        <div class="row gx-10 mb-5">

            <x-form-input label="Display Name"
                          name="display_name"
                          value="{{$server->display_name}}"
                          required="required" />
            <!-- Make sure to pass "file[]" for handling multiple file uploads -->
            <x-file-upload label="Add Settings File" file="file[]" multiple="yes" />

            <select class="form-select" aria-label="Select example" name="style">
                <option >Open this select menu</option>
                @foreach($playstyles as $style)
                    <option value="{{$style->id}}">{{$style->name}}</option>
                @endforeach
            </select>
        </div>
    </x-form>
</x-dashboard.layout>
