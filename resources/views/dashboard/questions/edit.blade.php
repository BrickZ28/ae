<x-dashboard.layout>
    <x-breadcrumbs title="Create Rule" parent="rules" child="edit" />
    <x-form :route="route('questions.update', $question->id)" method="patch" file="">
        <div class="row gx-10 mb-5">
            <div class="col-lg-12">
                <x-form-input label="Question" value="{{ $question->question }}" name="question" placeholder="" required="required" />

                @foreach($question->choices as $index => $choice)
                    <div class="mb-3">
                        <label>Choice {{ $index + 1 }}</label>
                        <input type="hidden" name="choices[{{ $index }}][id]" value="{{ $choice->id }}">
                        <input type="text" class="form-control" name="choices[{{ $index }}][text]" value="{{ old('choices.'.$index.'.text', $choice->choice) }}" required>
                    </div>
                @endforeach

                <label class="mb-3">Select Correct Answer</label>
                @foreach($question->choices as $index => $choice)
                    <div class="form-check form-check-custom form-check-solid mb-3">
                        <input class="form-check-input" type="radio" name="correct_answer" value="{{ $choice->id }}" id="choice{{ $choice->id }}" {{ $choice->is_correct ? 'checked' : '' }}>
                        <label class="form-check-label" for="choice{{ $choice->id }}">
                            {{ $choice->choice }}
                        </label>
                    </div>
                @endforeach
            </div>
            <!-- Button to submit form -->

        </div>
    </x-form>
</x-dashboard.layout>
