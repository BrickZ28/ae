<label class="form-label fs-6 fw-bold text-gray-700 mb-3">{{ucwords($label)}}</label>
<!--begin::Input group-->
<div class="input-group mb-5 ">
    <input name="{{$name ?? ""}}"
           value="{{$value ?? ""}}"
           type="text"
           class="form-control"
           id="{{$id ?? ""}}"
           placeholder="{{$placeholder ?? ""}}"
           aria-label="{{$placeholder ?? ""}}"
          {{$readonly ?? ""}}
          {{$required ?? ""}}

    aria-describedby="basic-addon1"/>

</div>
@if (!$errors->get($name))
    <h3 class="{{$infoTextColor ?? ""}}" > {{$infoText ?? ""}}</h3>
@else
    <div class="pb-2">
        <ul style="list-style-type: none">
            @foreach ($errors->get($name) as $message)
                <li> <em class="fa fa-exclamation-circle text-warning fs-12px me-1"></em>
                    <span class="text-danger">{{$message}}</span>
                </li>
            @endforeach
        </ul>
        <h3 class="{{$infoTextColor ?? ""}}" > {{$infoText ?? ""}}</h3>
    </div>
@endif
