<x-dashboard.layout>

    <x-breadcrumbs title="Edit Style" parent="playstyles" child="edit" />
    <x-form :route="route('playstyles.update', $style->id)" method="patch" file="yes">
        <div class="row gx-10 mb-5">
            <!-- Make sure to pass "file[]" for handling multiple file uploads -->
            <x-form-input label="Style"
                          name="name"
                          value="{{$style->name}}"
                          placeholder=""
                          required="" />
        </div>
    </x-form>
</x-dashboard.layout>
