@foreach( $suppliers as $value)
    <tr>
        <td>{{ $value->id }}</td>
        <td>{{ $value->name }}</td>
        <td>
            <a href="{{ route('admin.suppliers.edit', ['id' => $value->id]) }}">
                <i class="icon-im icon-im-pencil"></i>
            </a>
        </td>
    </tr>
@endforeach