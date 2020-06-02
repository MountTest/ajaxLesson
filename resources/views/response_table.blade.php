<table>
    <tr>
        <th>ФИО</th>
        <th>Телефон</th>
        <th>Статус</th>
        <th>Должность</th>
        <th>Действии</th>
    </tr>
    @foreach($employees as $employee)
        <tr id="{{ $employee->id }}">
            <td>{{ $employee->full_name }}</td>
            <td>{{ $employee->phone }}</td>
            <td>{{ $employee->role->role }}</td>
            @if($employee->status)
                <td>Активен</td>
            @else
                <td>Неактивен</td>
            @endif
            <th>
                <a data-id="{{ $employee->id }}" ><i class="fas fa-trash fa-lg"></i></a>
                @if($employee->status)
                    <a id="inversion_button" data-id="{{ $employee->id }}" class="inversion_button"><i class="fas fa-check fa-lg" style="width: 15px"></i></a>
                @else
                    <a id="inversion_button" data-id="{{ $employee->id }}" class="inversion_button"><i class="fas fa-times fa-lg" style="width: 15px"></i></a>
                @endif
                <a data-id="{{ $employee->id }}" ><i class="fas fa-pen fa-lg"></i></a>
            </th>
        </tr>
    @endforeach
</table>