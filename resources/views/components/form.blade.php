<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::Layout-->
        <div class="d-flex flex-column flex-lg-row">
            <!--begin::Content-->
            <div class="flex-lg-row-fluid mb-10 mb-lg-0 me-lg-7 me-xl-10">
                <!--begin::Card-->
                <div class="card">
                    <!--begin::Card body-->
                    <div class="card-body p-12">
                        <!--begin::Form-->
                        <form action="{{$route}}" id="kt_invoice_form" {{$file === 'yes' ? 'enctype=multipart/form-data' : "''" }}
                        method="{{ strtoupper($method) === 'GET' ? 'GET' : 'POST' }}">
                            @method(strtoupper($method))
                            @csrf
                            <!--begin::Wrapper-->
                            <div class="mb-0">
                                <!--begin::Row-->
                                {{$slot}}

                                <!--end::Row-->
                                <button type="submit"  id="kt_docs_sweetalert_html" class="btn
                                btn-maroon">Submit</button>
                            </div>
                            <!--end::Wrapper-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Content--></div>
        <!--end::Layout-->
    </div>
    <!--end::Content container-->
</div>

