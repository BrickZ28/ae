<x-dashboard.layout>

    <x-breadcrumbs title="Create Item" parent="items" child="create" />
    <x-form :route="route('items.store')" method="post" file="yes">
        <div class="row gx-10 mb-5">

            <div class="col-lg-12">
                <x-form-input label="Item" name="name"
                              value="{{ old('name') }}"
                              placeholder="Insert Name"
                              required="required" />

                <x-form-input label="Description" name="description"
                              value="{{ old('description') }}"
                              placeholder="Brief description about the item"
                              required="" />

                <x-form-select label="Category" name="category_id" required="required" >
                    <option value="">Select One</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </x-form-select>

                <x-form-select label="Game" name="game_id" required="required" >
                    <option value="">Select One</option>
                    @foreach($games as $game)
                        <option value="{{ $game->id }}">{{ $game->display_name }}</option>
                    @endforeach
                </x-form-select>

                <x-form-select label="Play Style" name="playstyle_id" required="required" >
                    <option value="">Select One</option>
                    @foreach($playstyles as $playstyle)
                        <option value="{{ $playstyle->id }}">{{ $playstyle->name }}</option>
                    @endforeach
                </x-form-select>

                <x-form-input label="Price" name="price"
                              value="{{ old('price') }}"
                              placeholder="Insert Price"
                              required="required" />

                <x-form-select label="Currency Type" name="currency_type" required="required" >
                    <option value="">Select One</option>
                    <option value="USD">USD</option>
                    <option value="AEC">AfterEarth Credits</option>
                </x-form-select>

                <x-file-upload label="Add Image" file="image" />

                <x-form-checkbox label="Visible In Store"
                                 name="visible"
                                 checked="{{ old('active') == 1 ? 'checked' : '' }}"
                />

            </div>

            <!--end::Col-->
        </div>
    </x-form>
</x-dashboard.layout>
