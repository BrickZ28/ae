<x-dashboard.layout>

    <x-breadcrumbs title="Create Package" parent="packages" child="create" />
    <x-form :route="route('packages.store')" method="post" file="yes">
        <div class="row gx-10 mb-5">

            <div class="col-lg-12">
                <x-form-input label="Package Name"
                              name="name"
                              value="{{old('name')}}"
                              placeholder="Create a name for the Package"
                              required="required" />

                <!-- Example parent div with a specific width -->
                <x-form-input label="Description"
                              name="description"
                              value="{{old('description')}}"
                              placeholder="List Items in Package"
                              required="required" />

                <x-form-select label="Select Items" name="items[]" required="required" id="items">
                    <option value="">Select One</option>
                    @foreach($items as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </x-form-select>

                <x-form-input label="Package Items" name="package_items" value="" readonly="readonly" id="package_items" />

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
    <script>
        $(document).ready(function() {
            var selectedItemsArray = []; // Array to store selected item names

            $('#items').change(function() {
                console.log("Dropdown change event triggered");
                var selectedItems = $('#items').val();
                if (!Array.isArray(selectedItems)) {
                    selectedItems = [selectedItems];
                }
                console.log("Selected items:", selectedItems);

                // Get item names for newly selected items
                var newItemNames = [];
                selectedItems.forEach(function(itemId) {
                    var itemName = $('#items option[value="' + itemId + '"]').text();
                    if (!selectedItemsArray.includes(itemName)) { // Check if item name is not already in the array
                        newItemNames.push(itemName);
                        selectedItemsArray.push(itemName); // Add item name to selected items array
                    }
                });

                // Update the "Package Items" input field
                $('#package_items').val(selectedItemsArray.join(', '));

                // Update the list with newly selected items
                var itemList = $('#item_list');
                newItemNames.forEach(function(itemName) {
                    itemList.append('<li>' + itemName + '</li>');
                });
            });
        });


    </script>
</x-dashboard.layout>
