<x-dashboard.layout>

    <x-breadcrumbs title="Edit Package" parent="packages" child="create" />
    <x-form :route="route('packages.update', $package->id)" method="post" file="yes">
        @method('PUT')
        <div class="row gx-10 mb-5">

            <div class="col-lg-12">
                <x-form-input label="Package Name"
                              name="name"
                              value="{{$package->name}}"
                              placeholder="Edit name for the Package"
                              required="required" />

                <x-form-input label="Description"
                              name="description"
                              value="{{$package->description}}"
                              placeholder="List Items in Package"
                              required="required" />

                <label class="form-label fs-6 fw-bold text-gray-700 mb-3">Remove Items From Package</label>
                <div style="border: 2px solid red; padding: 20px;">
                    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
                        @foreach($package->items->groupBy('category_id')->sortBy(fn($items) => $items->first()->category->name) as $categoryId => $items)
                            @php $category = $items->first()->category; @endphp
                            <li class="nav-item">
                                <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-bs-toggle="tab" href="#remove_kt_tab_pane_{{ $categoryId }}">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content" id="removeTabContent">
                        @foreach($package->items->groupBy('category_id')->sortBy(fn($items) => $items->first()->category->name) as $categoryId => $items)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="remove_kt_tab_pane_{{ $categoryId }}" role="tabpanel">
                                @foreach($items->sortBy('name') as $item)
                                    <div class="form-check">
                                        <!-- Hidden input for keeping track of existing items -->
                                        <input type="hidden" name="existing_items[]" value="{{ $item->id }}" />
                                        <!-- Checkbox to select items to keep; unchecked by default for removal -->
                                        <input class="form-check-input" type="checkbox" value="{{ $item->id }}" id="remove_item_{{ $item->id }}" name="items_to_keep[]" checked />
                                        <label class="form-check-label" for="remove_item_{{ $item->id }}">
                                            {{ $item->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>


                <label class="form-label fs-6 fw-bold text-gray-700 mt-5">Add Items to Package</label>
                <div class="tabs-container" style="border: 2px solid green; padding: 20px;">
                    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
                        @foreach($categories->sortBy('name') as $category)
                            <li class="nav-item">
                                <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-bs-toggle="tab" href="#add_kt_tab_pane_{{ $category->id }}">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content" id="addTabContent">
                        @foreach($categories as $category)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="add_kt_tab_pane_{{ $category->id }}" role="tabpanel">
                                <div class="items-grid">
                                    @foreach($category->items->sortBy('name') as $item)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="new_items[]" value="{{ $item->id }}" id="add_item_{{ $item->id }}"
                                                {{ $package->items->contains($item->id) ? 'disabled' : '' }}/>
                                            <label class="form-check-label" for="add_item_{{ $item->id }}">
                                                {{ $item->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <x-form-input label="Price" name="price"
                              value="{{ $package->price }}"
                              placeholder="Insert Price"
                              required="required" />

                <x-form-select label="Currency Type" name="currency_type" required="required" >
                    <option value="{{$package->currency_type}}">{{$package->currency_type}}</option>
                    <option value="USD">USD</option>
                    <option value="AEC">AfterEarth Credits</option>
                </x-form-select>

                <x-file-upload label="Add Image" file="image" />

                <x-form-checkbox label="Visible In Store"
                                 name="visible"
                                 checked="{{ $package->active == 1 ? 'checked' : '' }}"
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
