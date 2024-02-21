<div class="mb-5">
    <label class="form-label">{{$label}}</label>
    <input class="form-control form-control-solid" placeholder="Pick date range" id="{{$name}}"
           name="{{$name}}" value="{{$value}}"/>
</div>


<!--begin::Javascript-->

<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
<!--end::Javascript-->

<script>
    $(document).ready(function () {
        $({{$name}}).daterangepicker({
            timePicker: true, // Enable time picker if needed
            startDate: moment().startOf("hour"),
            endDate: moment().startOf("hour").add(32, "hour"),
            locale: {
                format: "M/d/Y h:mm A"
            }
        });
    });
</script>
