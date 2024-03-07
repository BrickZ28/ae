



<div class="mb-0">
    <label class="form-label">{{ucwords($name)}}</label>
    <input class="form-control form-control-solid" name="{{$name}}" placeholder="Pick date rage"
           id="kt_daterangepicker_1"/>
</div>






<!--begin::Javascript-->

<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
<!--end::Javascript-->

<script>



    $("#kt_daterangepicker_1").daterangepicker();




</script>
