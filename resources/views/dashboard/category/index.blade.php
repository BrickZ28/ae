<x-dashboard.layout>
    <x-datatable_shell breadcrumb-title="Users" breadcrumb-parent="user management" breadcrumb-child="users" :$filters>

        @foreach($categories as $category)

            <tr>
                <td>{{$category->id}}</td>
                <td> {{$category->name}} </td>
                <td>{{$category->description}}</td>
                <td>
                    <x-display-date-formatted
                        :date="$category->created_at" format="D M j, Y @ g:i:sa" />
                </td>
                <td><x-display-date-formatted
                        :date="$category->updated_at" format="D M j, Y @ g:i:sa" /></td>

                <td>
                    <form action="{{ route('categories.edit', $category->id) }}" method="get">
                        @csrf
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </form>
                </td>
                <td>
                    <form id="denyForm" action="{{ route('categories.destroy', $category->id) }}" method="POST">
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
                text: "This will delete the category from the website and can break stuff?",
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
