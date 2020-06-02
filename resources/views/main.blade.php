@extends('layouts.app')

@section('content')
    <div class="search mt-3 border p-2">
        <h2>Поиск</h2>
        <div class="row justify-content-around">
            <input class="col-9" id="search_input" type="text">
            <button id="search-button" class="col-2">Поиск</button>
        </div>
    </div>
    <div class="filter mt-3 border p-2">
        <h2>Фильтер</h2>
        <div class="filter-buttons">
            <button class="filter-button" data-id="0">Все</button>
            @foreach($roles as $role)
                <button class="filter-button" data-id="{{ $role->id }}">{{ $role->role }}</button>
            @endforeach
            <button id="inactive" data-id="1">Неактивнные</button>
        </div>
    </div>
    <div class="control-panel mt-3 border p-2">
        <h2>Управление</h2>
        <div class="add-button">
            <button>
                Добавить
            </button>
        </div>
    </div>
    <div id="employees-table" class="table mt-3 col-12">
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
                        <a data-id="{{ $employee->id }}"><i class="fas fa-trash fa-lg"></i></a>
                        @if($employee->status)
                            <a  data-id="{{ $employee->id }}" class="inversion_button"><i class="fas fa-check fa-lg" style="width: 15px"></i></a>
                        @else
                            <a  data-id="{{ $employee->id }}" class="inversion_button"><i class="fas fa-times fa-lg" style="width: 15px"></i></a>
                        @endif
                        <a data-id="{{ $employee->id }}"><i class="fas fa-pen fa-lg"></i></a>
                    </th>
                </tr>
            @endforeach
        </table>
    </div>
    @push('scripts')
        {{--script for search--}}
        <script>
            $('#search-button').on('click', function (event) {
                let searchText = $('#search_input').val();
                $.ajax({
                    url: "{{ route('search') }}",
                    method: "post",
                    data: {
                        '_token': "{{ csrf_token() }}",
                        "search_text": searchText,
                    },
                    success: function (data) {
                      if (!data.status){
                          alert("Поиск не дал результата");
                      } else {
                        $('#employees-table').html(data.result_html);
                      }
                    }
                })
            })
        </script>
        {{--script for filter--}}
        <script>
            $(document).on('click', '.filter-button', function (event) {
                let me = $(event.currentTarget);
                let role_id = me.data('id');
                $.ajax({
                    url: "{{ route('filter') }}",
                    method: "post",
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'role_id': role_id,
                    },
                    success: function (data) {
                        $('#employees-table').html(data.result_html);
                    }
                })
            })
        </script>
        {{--script get inversion status--}}
        <script>
            $("#inactive").on('click', function (event) {
                let me = $(event.currentTarget);
                $.ajax({
                    url: "{{ route('status') }}",
                    method: "post",
                    data: {
                        '_token': "{{ csrf_token() }}",
                    },
                    success: function (data) {
                        $("#employees-table").html(data.result_html);
                    }
                })
            })
        </script>
        {{--script for inversion status--}}
        <script>
            $(document).on('click', '.inversion_button', function (event) {
                console.log('12333');
                let me = $(event.currentTarget);
                let emp_id = me.data("id");

                $.ajax({
                    url: "{{ route('inversion_status') }}",
                    method: "put",
                    data: {
                        'emp_id': emp_id,
                        '_token': "{{ csrf_token() }}",
                    },
                    success: function (data) {
                        console.log('12333');
                        $("#" + emp_id).remove();
                    }
                })
            })
        </script>
    @endpush
@endsection