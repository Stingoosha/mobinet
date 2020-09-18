@extends('layouts.layout', ['title' => 'Модели', 'userData' => $userData])

@section('content')

    <h1 class="display-1 text-info">Модели</h1>
    <div class="row">
        <div class="col-9 mr-auto">
            <div class="table-responsive">
                <table class="table text-info">
                    <tr class="bg-info">
                        <th>Наименование модели</th>
                        <th>Подробнее</th>
                        <th>Наименование бренда</th>
                        <th>Стоимость</th>
                        <th>Новая цена</th>
                        <th class="overflow-hidden">Фото</th>
                        <th></th>
                        <th></th>
                    </tr>
                @if (!empty($phones))
                    @foreach ($phones as $phone)
                        <tr>
                            <form action="/tels/{{ $phone['id'] }}/edit" method="post">
                                <td class="{{ $phone['id'] == $newPhoneId ? 'bg-success text-light' : '' }}"><input type="text" class="form-control text-info w-100 {{ $phone['id'] == $newPhoneId ? 'bg-success text-light' : '' }}" name="newPhoneName" value="{{ $phone['name'] }}" required></td>
                                <td class="{{ $phone['id'] == $newPhoneId ? 'bg-success text-light' : '' }}"><a class="btn btn-outline-info {{ $phone['id'] == $newPhoneId ? 'bg-success text-light border-light' : '' }}" href="/tels/{{ $phone['id'] }}">Подробнее</a></td>
                                <td class="{{ $phone['id'] == $newPhoneId ? 'bg-success text-light' : '' }}"><select class="form-control text-info {{ $phone['id'] == $newPhoneId ? 'bg-success text-light' : '' }}" name="newBrandName">
                                @foreach ($brands as $brand)
                                    <option {{ $brand['id_brand'] == $phone['id_brand'] ? 'selected' : '' }}>{{ $brand['name_brand'] }}</option>
                                @endforeach
                                </select></td>
                                <td class="{{ $phone['id'] == $newPhoneId ? 'bg-success text-light' : '' }}"><input type="text" class="form-control text-info {{ $phone['id'] == $newPhoneId ? 'bg-success text-light' : '' }}" name="newPhonePrice" value="{{ $phone['price'] }} &#8381;" required></td>
                                <td class="{{ $phone['id'] == $newPhoneId ? 'bg-success text-light' : '' }}">{{ $phone['new_price'] ?? '0' }} &#8381;</td>
                                <td class="{{ $phone['id'] == $newPhoneId ? 'bg-success text-light' : '' }}">{{ $phone['photo'] ? '+' : '-' }}</td>
                                <td><input type="submit" value="Изменить" class="btn btn-outline-warning"></td>
                            </form>
                            <!-- Button trigger modal -->
                            <td><button type="button" class="btn btn-outline-danger" onclick="showModalConfirmation('tels', {{ $phone['id'] }}, 'модели', 'эту модель')" data-toggle="modal" data-target="#confirmation">
                            Удалить</button></td>
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
        <div class="col-3">
            <form class="border border-info rounded p-3" action="/tels/create" method="post">
                <div class="form-group">
                    <h4 class="display-4 text-info text-center">Новая модель</h4>
                    <input type="text" class="col-10 mx-auto mb-3 form-control text-center" name="newPhoneName" placeholder="Наименование модели" required>
                    <span class="mb-3" for="newBrandName">Наименование бренда</span>
                    <select class="form-control text-info mb-3 col-10 mx-auto" name="newBrandName">
                    @foreach ($brands as $brand)
                        <option>{{ $brand['name_brand'] }}</option>
                    @endforeach
                    <input type="text" class="col-10 mx-auto mb-3 form-control text-center" name="newPhonePrice" placeholder="Стоимость" required>
                </div>
                <button type="submit" class="col-6 btn btn-outline-info">Добавить</button>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="confirmation" tabindex="-1" role="dialog" aria-labelledby="confirmationTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <a class="col" id="confirm-href" href=""><button type="button" class="col btn btn-outline-success">Да</button></a>
                <button type="button" class="col btn btn-outline-danger" data-dismiss="modal">Нет</button>
            </div>
            </div>
        </div>
    </div>

@endsection
