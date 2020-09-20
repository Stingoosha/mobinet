@extends('layouts.layout', ['title' => 'Пользователи', 'layout' => $layout])

@section('content')

    <h1 class="display-1 text-info">Пользователи</h1>
    <div class="row">
        <div class="col-10 mx-auto">
            <div class="table-responsive">
                <table class="table text-info">
                    <tr class="bg-info">
                        <th>ID</th>
                        <th>Пользователь</th>
                        <th>Логин</th>
                        <th>Роль</th>
                        <th></th>
                    </tr>
                @if (!empty($users))
                    @foreach ($users as $user)
                        <tr>
                            <td class="{{ $user['id'] == $newUserId ? 'bg-success text-light' : '' }}">{{ $user['id'] }}</td>
                            <td><a class="btn btn-outline-info" href="/users/{{ $user['id'] }}">Подробнее</a></td>
                            <td class="{{ $user['id'] == $newUserId ? 'bg-success text-light' : '' }}">{{ $user['login'] }}</td>
                            <form action="/users/{{ $user['id'] }}/edit" method="post">
                            <td><select class="form-control w-100" name="newRole">
                            @foreach ($roles as $role)
                                <option {{ $user['id_role'] == $role['id_role'] ? 'selected' : '' }}>{{ $role['name_role'] }}</option>
                            @endforeach
                            </select></td>
                            <td><input type="submit" value="Изменить" class="btn btn-outline-success"></td>
                            </form>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endif
                </table>
            </div>
        </div>
    </div>

@endsection
