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
        </div>

<label for="style" class="form-label">Select Playstyle</label>
        <div class="row gx-10 mb-5">
            <select class="form-select" aria-label="Select Playstyle" name="style">
                @foreach($playstyles as $style)
                    <option value="{{$style->id}}">{{$style->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="row gx-10 mb-5">

<label for="style" class="form-label">Select Game</label>
            <select class="form-select" aria-label="Select Game" name="game">
                <option value="">Select One</option>
                @foreach($games as $game)
                    <option value="{{$game->id}}">{{$game->display_name}}</option>
                @endforeach
            </select>
        </div>
    </x-form>
</x-dashboard.layout>
