<!-- DataTables.blade.php -->

@props(['data'])

<table id="example" class="display" style="width:100%">
    <thead>
    <tr>
        @foreach($data['columns'] as $column)
            <th>{{ $column }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($data['rows'] as $row)
        <tr>
            @foreach($row as $cell)
                <td>{{ $cell }}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
