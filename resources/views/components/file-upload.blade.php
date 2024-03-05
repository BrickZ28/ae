
<label for="formFileMultiple" class="form-label">{{$label}}</label>
<input class="form-control" type="file" id="formFile" name="{{$file}}" multiple="{{$multiple ?? ''}}">

<div class="pt-2">
    <ul style="list-style-type: none">
        @foreach ($errors->get($file) as $message)
            <li> <em class="fa fa-exclamation-circle text-warning fs-12px me-1"></em>
                <span class="text-danger">{{$message}}</span>
            </li>
        @endforeach
    </ul>
</div>
