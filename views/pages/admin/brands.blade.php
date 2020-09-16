@extends('layouts.layout', ['title' => 'Бренды', 'userData' => $userData])

@section('content')

    <h1 class="display-1 text-info">Бренды</h1>
    <div class="row">
        <div class="col-7 mr-auto">
            <div class="table-responsive">
                <table class="table text-info">
                    <tr class="bg-info">
                        <th class="col">Наименование бренда</th>
                        <th class="col"></th>
                        <th class="col"></th>
                    </tr>
                @if (!empty($brands))
                    @foreach ($brands as $brand)
                        <tr>
                            <form action="/brands/{{ $brand['id_brand'] }}/edit" method="post">
                                <td><input type="text" class="form-control {{ $brand['id_brand'] == $newBrandId ? 'bg-success text-light' : '' }}" name="newBrand" value="{{ $brand['name_brand'] }}" required></td>
                                <td><input type="submit" value="Изменить" class="btn btn-outline-warning"></td>
                            </form>
                            <td><a class="btn btn-outline-danger" href="/brands/{{ $brand['id_brand'] }}/remove">Удалить</a></td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endif
                </table>
            </div>
        </div>
        <div class="col-4">
            <form class="border border-info rounded p-3" action="/brands/create" method="post">
                <div class="form-group">
                    <h4 class="display-4 text-info text-center">Новый бренд</h4>
                    <input type="text" class="col-10 mx-auto form-control text-center" name="newBrand" placeholder="Наименование бренда" required>
                </div>
                <button type="submit" class="col-6 btn btn-outline-info">Добавить</button>
            </form>
        </div>
    </div>

@endsection
