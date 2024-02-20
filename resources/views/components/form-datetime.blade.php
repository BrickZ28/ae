<div class="mb-5">
    <label class="form-label">{{$label}}</label>
    <input class="form-control form-control-solid" placeholder="Pick date range" id="kt_daterangepicker_{{$name}}"
           name="{{$name}}" value="{{$value}}"/>
</div>


<!--begin::Javascript-->

<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
<!--end::Javascript-->

<script>
    $(document).ready(function () {
        $('#kt_daterangepicker_{{$name}}').daterangepicker({
            timePicker: true, // Enable time picker if needed
            startDate: moment().startOf("hour"),
            endDate: moment().startOf("hour").add(32, "hour"),
            locale: {
                format: "{{config('constants.date.form_format')}}"
            }
        });
    });
</script>
