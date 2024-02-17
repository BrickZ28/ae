<label class="form-label fs-6 fw-bold text-gray-700 mb-3">{{ucwords($label)}}</label>
<!--begin::Input group-->
<div class="input-group mb-5 ">
    <input name="{{$name}}"
           value="{{$value}}"
           type="text"
           class="form-control"
           placeholder="{{$placeholder}}"
           aria-label="{{$placeholder}}"
           {{$required ?? ''}}

    aria-describedby="basic-addon1"/>

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


{{--@if ($errors->any())--}}

{{--        <ul>--}}
{{--            @foreach ($errors->all() as $error)--}}
{{--                <li><span style="color:#cc4343">{{ $error }}</span></li>--}}
{{--            @endforeach--}}
{{--        </ul>--}}

{{--@endif--}}
