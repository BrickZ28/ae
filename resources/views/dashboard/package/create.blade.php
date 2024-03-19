<x-dashboard.layout>

    <x-breadcrumbs title="Create Package" parent="packages" child="create"/>
    <x-form :route="route('packages.store')" method="post" file="yes">
        <div class="row gx-10 mb-5">

            <div class="col-lg-12">
                <div style="display: flex; gap: 20px;">
                    <div style="flex: 1;">
                        <x-form-input label="Package Name"
                                      name="name"
                                      value="{{ old('name') }}"
                                      placeholder="Edit name for the Package"
                                      required="required"/>
                    </div>
                    <div style="flex: 1;">
                        <x-form-input label="Description"
                                      name="description"
                                      value="{{ old('description') }}"
                                      placeholder="General overview of package"
                                      required="required"/>
                    </div>
                </div>
                <label class="form-label fs-6 fw-bold text-gray-700 mb-3">Add Items to Package</label>

                <div class="tabs-container">
                    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
                        @foreach($categories as $category)
                            <li class="nav-item">
                                <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-bs-toggle="tab" href="#kt_tab_pane_{{ $category->id }}">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        @foreach($categories as $category)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="kt_tab_pane_{{ $category->id }}" role="tabpanel">
                                <div class="items-grid">
                                    @foreach($category->items->sortBy('name') as $item)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="items[]" value="{{ $item->id }}" id="item_{{ $item->id }}" /> <!-- Ensure each checkbox has a unique ID -->
                                            <label class="form-check-label" for="item_{{ $item->id }}">
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
                              value="{{ old('price') }}"
                              placeholder="Insert Price"
                              required="required"/>

                <x-form-select label="Currency Type" name="currency_type" required="required">
                    <option value="">Select One</option>
                    <option value="USD">USD</option>
                    <option value="AEC">AfterEarth Credits</option>
                </x-form-select>

                <x-file-upload label="Add Image" file="image"/>

                <x-form-checkbox label="Visible In Store"
                                 name="visible"
                                 checked="{{ old('active') == 1 ? 'checked' : '' }}"
                />

                <!--end::Col-->
            </div>
        </div>
    </x-form>
    <script>


        // Set a checkbox to indeterminate state
        document.querySelector('#kt_check_indeterminate_1').indeterminate = true;


    </script>
</x-dashboard.layout>
