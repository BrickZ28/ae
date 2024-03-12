<x-dashboard.layout>
    <!-- dashboard/index.blade.php -->
    <x-DataTables :data="$data" />

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#example').DataTable();
            });
        </script>
    @endpush


</x-dashboard.layout>
