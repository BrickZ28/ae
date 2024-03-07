
<label for="formFileMultiple" class="form-label">{{$label}}</label>
<input class="form-control" type="file" id="formFile" name="{{$file}}" multiple="{{$multiple ?? ''}}">

<div class="form-label fs-6 fw-bold text-gray-700 mb-3">
    <ul style="list-style-type: none">
        @foreach ($errors->get($file) as $message)
            <li> <em class="fa fa-exclamation-circle text-warning fs-12px me-1"></em>
                <span class="text-danger">{{$message}}</span>
            </li>
        @endforeach
    </ul>
</div>
