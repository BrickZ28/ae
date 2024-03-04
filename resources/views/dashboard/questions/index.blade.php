<x-dashboard.layout>
    <x-datatable_shell breadcrumb-title="Questions" breadcrumb-parent="question management"
                       breadcrumb-child="questions"
                       :$filters>

        @foreach($questions as $question)

            <tr>
                <td>{{$question->id}}</td>
                <td> {{$question->question}}</td>
                <td><x-display-date-formatted
                        :date="$question->created_at" format="D M j, Y @ g:i:sa" />
                </td>
                <td>
                    <x-display-date-formatted
                        :date="$question->updated_at" format="D M j, Y @ g:i:sa" />
                </td>

                <td>
                    <x-dashboard-draggable-modal buttonText="View"
                                                 :title="$question->question"
                                                 :id="$question->id">


                            <ul>
                                <ul>
                                    @foreach($question->choices as $choice)
                                        <li style="{{ $choice->is_correct ? 'font-weight: bold; color: green;' : '' }}">
                                            {{ $choice->choice }}
                                            @if($choice->is_correct)
                                                - Correct Answer
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>

                            </ul>


                    </x-dashboard-draggable-modal>
                </td>
                    <!--begin::Menu-->
                <td>
                    <form  action="{{ route('questions.edit', $question->id) }}" method="get">

                        @csrf
                        <button type="submit" class="btn btn-info">Edit</button>
                    </form>
                </td>
                <td>
                    <form id="denyForm" action="{{ route('questions.destroy', $question->id) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach

    </x-datatable_shell>
    <script>
        document.getElementById('denyForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the form from submitting immediately

            // Use SweetAlert to show a confirmation dialog
            Swal.fire({
                title: 'Confirm?',
                text: "This will delete the image from the website. Are you sure you want to delete " +
                    "this question?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, do it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // User clicked 'Yes', submit the form
                    event.target.submit();
                }
            });
        });
    </script>
</x-dashboard.layout>
