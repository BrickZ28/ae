<x-dashboard.layout>

    <x-breadcrumbs title="Create Question" parent="questions" child="create" />
    <x-form :route="route('questions.store')" method="post" file="">
        <div class="row gx-10 mb-5">

            <div class="col-lg-12">
                <x-form-input label="Question"
                              name="question"
                              value="{{old('question')}}"
                              placeholder="{{'Insert Question'}}"
                              required="required"
                              infoText=""
                              infoTextColor=""
                />

                <div class="col-lg-12">
                    <x-form-input label="Choices"
                                  name="choices"
                                  value="{{old('choices')}}"
                                  placeholder="{{'Insert Choices'}}"
                                  required="required"
                                  infoText="Seperate Values with a comma"
                                  infoTextColor="text-warning"
                    />

                    <div class="col-lg-12">
                        <x-form-input label="Correct Answer"
                                      name="answer"
                                      value="{{old('answer')}}"
                                      placeholder="{{'Insert Answer'}}"
                                      required="required"
                                      infoText=""
                                      infoTextColor=""
                        />

            </div>

            <!--end::Col-->
        </div>
    </x-form>
</x-dashboard.layout>
