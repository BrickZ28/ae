<x-dashboard.layout>

    <div class="flex-row-fluid ml-lg-8">
        <!--begin::Section-->
        <div class="card card-custom gutter-b">
            <!--begin::Header-->
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label font-weight-bolder font-size-h3 ">My Shopping Cart</span>
                </h3>

            </div>
            <!--end::Header-->

            <div class="card-body">
                <!--begin::Shopping Cart-->
                <div class="table-responsive">
                    <table class="table">
                        <!--begin::Cart Header-->
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th class="text-center">Qty</th>
                            <th class="text-right">Price</th>
                            <th></th>
                        </tr>
                        </thead>
                        <!--end::Cart Header-->

                        <tbody>
                        <!--begin::Cart Content-->
                        @foreach($itemsUSD as $item)
                            <tr class="shopping-border">
                                <td class="d-flex align-items-center font-weight-bolder">
                                    <div class="symbol symbol-60 flex-shrink-0 mr-4 ">
                                        <div class="symbol-label"
                                             style="background-image: url('{{ $item->image }}')"></div>
                                    </div>
                                    <!-- Trigger the SweetAlert2 popup with a button -->
                                    <button type="button" class="btn btn-bg-light btn-color-info item-info"
                                            style="margin-left: 20px;"
                                            data-name="{{ $item->name }}" data-image="{{ $item->image }}"
                                            data-quantity="{{ $item->pivot->quantity }}"
                                            data-price="{{ $item->price }}">{{ $item->name }}</button>
                                </td>
                                <td class="text-center align-middle">
                                    <form action="{{ route('carts.updateQuantity', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="quantity" value="{{ $item->pivot->quantity }}"
                                               min="1" style="width: 50px;">
                                        <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                    </form>
                                </td>
                                <td class="text-right align-middle font-weight-bolder font-size-h5">
                                    ${{ $item->price }}
                                </td>
                                <td class="text-right align-middle">
                                    <form action="{{ route('carts.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger font-weight-bolder font-size-sm">
                                            Remove
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        <!--end::Cart Content-->

                        <!--begin::Cart Footer-->
                        <tr>
                            <td colspan="2"></td>
                            <td class="font-weight-bolder font-size-h4 text-right">Total USD</td>
                            <td class="font-weight-bolder font-size-h4 text-right">${{ $totalUSD }}</td>
                        </tr>

                        @foreach($itemsAEC as $item)
                            <tr class="shopping-border">
                                <td class="d-flex align-items-center font-weight-bolder">
                                    <div class="symbol symbol-60 flex-shrink-0 mr-4 ">
                                        <div class="symbol-label"
                                             style="background-image: url('{{ $item->image }}')"></div>
                                    </div>
                                    <!-- Trigger the SweetAlert2 popup with a button -->
                                    <button type="button" class="btn btn-bg-light btn-color-info item-info"
                                            style="margin-left: 20px;"
                                            data-name="{{ $item->name }}" data-image="{{ $item->image }}"
                                            data-quantity="{{ $item->pivot->quantity }}"
                                            data-price="{{ $item->price }}">{{ $item->name }}</button>
                                </td>
                                <td class="text-center align-middle">
                                    <form action="{{ route('carts.updateQuantity', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="quantity" value="{{ $item->pivot->quantity }}"
                                               min="1" style="width: 50px;">
                                        <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                    </form>
                                </td>
                                <td class="text-right align-middle font-weight-bolder font-size-h5">
                                    {{ $item->price }} AEC
                                </td>
                                <td class="text-right align-middle">
                                    <form action="{{ route('carts.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger font-weight-bolder font-size-sm">
                                            Remove Item
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        <tr>
                            <td colspan="2"></td>
                            <td class="font-weight-bolder font-size-h4 text-right">Total AEC</td>
                            <td class="font-weight-bolder font-size-h4 text-right">${{ $totalAEC }}</td>
                        </tr>

                        <tr>

                            <td colspan="2" class="border-0 text-right pt-10">
                                <a href="{{route('checkout')}}" class="btn btn-success font-weight-bolder px-8">
                                    @if($totalUSD === 0 && $totalAEC > 0)
                                        Purchase Now
                                    @else
                                        Proceed to Checkout
                                    @endif

                                </a>
                            </td>
                        </tr>
                        <!--end::Cart Footer-->
                        </tbody>
                    </table>
                </div>
                <!--end::Shopping Cart-->
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.item-info').forEach(item => {
            item.addEventListener('click', function () {
                // Get the data from the button
                const name = this.getAttribute('data-name');
                let image = this.getAttribute('data-image');
                const price = this.getAttribute('data-price');
                const currency_type = this.getAttribute('data-currency');
                let description = this.getAttribute('data-description');

                // Check if the description is blank
                description = description ? description : 'No description added';

                // Format the price based on the currency type
                const formattedPrice = currency_type === 'USD' ? `$${price}` : `${price} AEC`;

                // Use SweetAlert to show the data
                Swal.fire({
                    title: `<img src="${image}" onerror="this.onerror=null; this.src='{{asset('assets/media/logos/favicon.ico')}}';" style="width: 100%; max-width: 250px; margin: 0 auto; display: block;">`,
                    html: `
                <ul>
                    <li>Name: ${name}</li>
                    <li>Price: ${formattedPrice}</li>
                </ul>
                <p>${description}</p>
            `,
                    showCloseButton: true,
                    showConfirmButton: true,
                });
            });
        });
    </script>
</x-dashboard.layout>
