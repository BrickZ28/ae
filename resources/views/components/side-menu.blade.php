<!--begin:Menu item-->

@foreach($header as $section=>$menu)

    <div class="menu-item pt-5">
        <!--begin:Menu content-->
        <div class="menu-content">
            <span class="menu-heading fw-bold text-uppercase fs-7">{{$section}}</span>
        </div>
        <!--end:Menu content-->
    </div>

    @foreach($menu as $submenu=>$path)
        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
            <!--begin:Menu link-->
            <span class="menu-link">
                <span class="menu-icon">
                    <i class="ki-duotone ki-address-book fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>
                </span>
                <span class="menu-title">{{ucwords($submenu)}}</span>
                <span class="menu-arrow"></span>
            </span>
            <!--end:Menu link-->

            @foreach($path as $name=>$link)
                <!--begin:Menu sub-->
                <div class="menu-sub menu-sub-accordion">
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a id="{{ $name == 'View Cart' ? 'myCartSideMenu' : '' }}" class="menu-link" href={{$link}}>
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
                            <span class="menu-title">{{$name}}</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                </div>
            @endforeach
            <!--end:Menu sub-->
        </div>

    @endforeach

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var cartLink = document.querySelector('#myCartSideMenu');
            if (cartLink) {
                cartLink.addEventListener('click', function (e) {
                    var cartIsEmpty = @json($cartIsEmpty);
                    if (cartIsEmpty) {
                        e.preventDefault(); // Prevent the default action
                        Swal.fire("OH No", "It looks like your cart is empty! Please browse the shop in the side menu", "error");
                    }
                });
            }
        });

    </script>

@endforeach


