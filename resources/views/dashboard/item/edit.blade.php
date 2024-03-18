<x-dashboard.layout>

    <x-breadcrumbs title="Edit Item" parent="items" child="edit" />
    <x-form :route="route('items.update', $item->id)" method="patch" file="">
        <div class="row gx-10 mb-5">

            <div class="col-lg-12">
                <x-form-input label="Item Name"
                              :value="$item->name"
                              name="name"
                              placeholder=""
                              required="required"
                              infoText=""
                              infoTextColor=""
                />

            </div>

            <div class="col-lg-12 mt-4">
                <x-form-input label="Description"
                              :value="$item->description"
                              name="description"
                              placeholder=""
                              required=""
                              infoText=""
                              infoTextColor=""
                />



                    <x-form-select label="Category" name="category_id" required="required" >
                        <option value="{{$item->category->id}}">{{$item->category->name}}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </x-form-select>

                    <x-form-input label="Price" name="price"
                                  value="{{ $item->price }}"
                                  placeholder=""
                                  required="required" />

                    <x-form-select label="Currency Type" name="currency_type" required="required" >
                        <option value="{{$item->currency_type}}">{{$item->currency_type}}</option>
                        <option value="USD">USD</option>
                        <option value="AEC">AfterEarth Credits</option>
                    </x-form-select>

                    <x-file-upload label="Update Image" file="image" />

                <x-form-checkbox label="Visible In Store"
                                 name="visible"
                                 value="1"
                                 checked="{{ old('active') == 1 || $special->active ? 'checked' : '' }}"
                />

            </div>

            <!--end::Col-->
        </div>
    </x-form>
</x-dashboard.layout>
