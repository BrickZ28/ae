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
                                  infoText="Seperate Values with a ^ (Shift 6)"
                                  infoTextColor="text-warning"
                    />

                   <div id="radioChoicesContainer"  >

                    </div>

                    <!--end::Col-->

                </div>
            </div>
        </div>
    </x-form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const choicesInput = document.querySelector('input[name="choices"]');
            const radioChoicesContainer = document.getElementById('radioChoicesContainer');

            choicesInput.addEventListener('input', function () {
                const choices = this.value.split('^').filter(Boolean); // Split by '^' and remove any empty strings
                radioChoicesContainer.innerHTML = ''; // Clear previous radio buttons

                choices.forEach((choice, index) => {
                    const radioWrapper = document.createElement('div');
                    radioWrapper.className = 'form-check mb-2'; // Added 'mb-2' for margin-bottom

                    const radioInput = document.createElement('input');
                    radioInput.type = 'radio';
                    radioInput.className = 'form-check-input';
                    radioInput.id = 'choice' + index;
                    radioInput.name = 'answer'; // Use this name to access the selected value
                    radioInput.value = choice.trim();

                    const label = document.createElement('label');
                    label.className = 'form-check-label';
                    label.htmlFor = 'choice' + index;
                    label.textContent = choice.trim();

                    // This line changes the text color of the label
                    label.style.color = '#9A9CAE'; // Apply an inline style for the text color

                    radioWrapper.appendChild(radioInput);
                    radioWrapper.appendChild(label);

                    radioChoicesContainer.appendChild(radioWrapper);
                });
            });
        });

    </script>


</x-dashboard.layout>
