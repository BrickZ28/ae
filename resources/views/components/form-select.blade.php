<label class="form-label fs-6 fw-bold text-gray-700 mb-3">{{ucwords($label)}}</label>
<div class="mb-5 @error($name) is-invalid @enderror">
    <select class="form-select" aria-label="Select example" name="{{$name}}" {{$required ?? ''}} >
       {{$slot}}
    </select>
</div>

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
