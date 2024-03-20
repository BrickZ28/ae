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
                            <tr>
                                <td class="d-flex align-items-center font-weight-bolder">
                                    <div class="symbol symbol-60 flex-shrink-0 mr-4 ">
                                        <div class="symbol-label" style="background-image: url('{{ $item->image }}')"></div>
                                    </div>
                                    <a href="#" class=" text-hover-primary">{{ $item->name }}</a>
                                </td>
                                <td class="text-center align-middle">
                                    <span class="mr-2 font-weight-bolder">{{ $item->pivot->quantity }}</span>
                                </td>
                                <td class="text-right align-middle font-weight-bolder font-size-h5">
                                    ${{ $item->price }}
                                </td>
                                <td class="text-right align-middle">
                                    <form action="{{ route('carts.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger font-weight-bolder font-size-sm">Remove</button>
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
                            <tr>
                                <td class="d-flex align-items-center font-weight-bolder">
                                    <div class="symbol symbol-60 flex-shrink-0 mr-4 ">
                                        <div class="symbol-label" style="background-image: url('{{ $item->image }}')"></div>
                                    </div>
                                    <a href="#" class=" text-hover-primary">{{ $item->name }}</a>
                                </td>
                                <td class="text-center align-middle">
                                    <span class="mr-2 font-weight-bolder">{{ $item->pivot->quantity }}</span>
                                </td>
                                <td class="text-right align-middle font-weight-bolder font-size-h5">
                                    ${{ $item->price }}
                                </td>
                                <td class="text-right align-middle">
                                    <form action="{{ route('carts.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger font-weight-bolder font-size-sm">Remove</button>
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
                                <a href="#" class="btn btn-success font-weight-bolder px-8">Proceed to Checkout</a>
                            </td>
                        </tr>
                        <!--end::Cart Footer-->
                        </tbody>
                    </table>
                </div>
                <!--end::Shopping Cart-->
            </div>
        </div>
</x-dashboard.layout>
