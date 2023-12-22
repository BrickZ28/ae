<label class="form-label fs-6 fw-bold text-gray-700 mb-3">{{ucwords($label)}}</label>
<!--begin::Input group-->
<div class="input-group mb-5 ">
    <input name="{{$name}}"
           type="text"
           class="form-control"
           placeholder="{{$placeholder}}"
           aria-label="{{$placeholder}}"
           {{$required ?? ''}}

    aria-describedby="basic-addon1"/>
</div>

@if ($errors->any())

        <ul>
            @foreach ($errors->all() as $error)
                <li><span style="color:#cc4343">{{ $error }}</span></li>
            @endforeach
        </ul>

@endif
