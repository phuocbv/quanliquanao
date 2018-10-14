@foreach( $suppliers as $value)
    <tr>
        <td>{{ $value->id }}</td>
        <td>{{ $value->name }}</td>
        <td><i class="icon-im icon-im-pencil" style="cursor: pointer" data-id="{{ $value->id }}"></i></td>
    </tr>
@endforeach