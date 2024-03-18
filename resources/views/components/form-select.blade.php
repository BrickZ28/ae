<label class="form-label fs-6 fw-bold text-gray-700 mb-3">{{ucwords($label)}}</label>
<div class="mb-5 @error($name) is-invalid @enderror">
    <select class="form-select"
            aria-label="Select example"
            name="{{$name}}" {{$required ?? ''}}
            id="{{$id ?? ''}}"
    >
       {{$slot}}
    </select>
</div>

<div class="pb-2">
    <ul style="list-style-type: none">
        @foreach ($errors->get($name) as $message)
            <li> <em class="fa fa-exclamation-circle text-warning fs-12px me-1"></em>
                <span class="text-danger">{{$message}}</span>
            </li>
        @endforeach
    </ul>
</div>
