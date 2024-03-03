<x-dashboard.layout>

    <x-breadcrumbs title="Question" parent="questions" child="ask" />
    <!--begin::Alert-->
    <!--begin::Alert-->
    <div class="alert  bg-primary d-flex flex-column flex-sm-row p-5 mb-10">


        <!--begin::Wrapper-->
        <div class="d-flex flex-column text-light pe-0 pe-sm-10">
            <!--begin::Title-->
            <h4 class="mb-2 light">Time left to answer question</h4>
            <!--end::Title-->

            <!--begin::Content-->
            <div id="timer">02:00</div>
            <!--end::Content-->
        </div>
        <!--end::Wrapper-->

        <!--begin::Close-->
        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
            <i class="ki-duotone ki-cross fs-1 text-light"><span class="path1"></span><span class="path2"></span></i>
        </button>
        <!--end::Close-->
    </div>
    <!--end::Alert-->
    <!--end::Alert-->

    <x-form :route="route('questions.user.attempt', $random_question->id)" method="get" file="">
        <div class="row gx-10 mb-5">
            <input type="hidden" name="attempt_token" value="{{ session('attempt_token') }}">
            <div class="col-lg-12">
                <x-form-input label="Question"
                              name="question"
                              value="{{$random_question->question}}"
                              placeholder=""
                              required="required"
                              infoText=""
                              infoTextColor=""
                />



                <div class="col-lg-12">
                    <label class="mb-3">Select Answer</label>
                    @foreach($random_question->choices as $choice)
                        <div class="form-check form-check-custom form-check-solid mb-3"> <!-- Added spacing -->
                            <input class="form-check-input" type="radio" name="choice" value="{{ $choice->id }}" id="choice{{ $choice->id }}">
                            <label class="form-check-label" for="choice{{ $choice->id }}">
                                {{ $choice->choice }}
                            </label>
                        </div>
                    @endforeach
                </div>

                </div>

                <!--end::Col-->
            </div>
    </x-form>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var timeLimit = 120; // Time limit set to 2 minutes
            var timer = document.getElementById('timer'); // Assuming an element with ID 'timer' displays the countdown
            var interval = setInterval(function() {
                var minutes = parseInt(timeLimit / 60, 10);
                var seconds = parseInt(timeLimit % 60, 10);

                minutes = minutes < 2 ? "0" + minutes : minutes;
                seconds = seconds < 0 ? "0" + seconds : seconds;

                timer.textContent = minutes + ":" + seconds;

                if (--timeLimit < 0) {
                    clearInterval(interval);
                    // Handle time expiration, e.g., submit the form, show a message, etc.
                    alert('Time expired!');
                    // Optionally submit the form automatically
                    // document.getElementById('yourFormId').submit();
                }
            }, 1000);
        });
    </script>
</x-dashboard.layout>
