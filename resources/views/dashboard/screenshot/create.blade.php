<x-dashboard.layout>

    <x-breadcrumbs title="Screenshots" parent="screenshot" child="create" />
    <x-form :route="route('screenshots.store')" method="post" file="yes">
        <div class="row gx-10 mb-5">

            <div class="col-lg-12">
                <x-form-input label="Title" name="title" placeholder="{{old('title' ?? 'Insert Title')}}"
                              required="required" />

                <x-form-select label="Who took Screenshot" name="created_by" required="" >
                    <option value="">Select One</option>
                    @foreach($users as $user)
                        <option value={{$user->id}}>{{$user->username}}</option>
                    @endforeach
                </x-form-select>

                <x-file-upload label="Select Screenshot" />
            </div>

            <!--end::Col-->
        </div>
    </x-form>
</x-dashboard.layout>
