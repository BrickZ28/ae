<!-- dashboard-product-card-items.blade.php -->
<div class="d-flex align-items-center mb-5">
    <span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
        {{$label}} {{ $setting }}x
    </span>

    <i class="ki-duotone {{ $setting === 'UNK' ? ' ki-cross-square text-danger ' : 'ki-check-circle text-success' }}
     fs-1">
        <span class="path1"></span>
        <span class="path2"></span>
    </i>

</div>
