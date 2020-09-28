@extends('layouts.layout', ['title' => 'Скидки', 'layout' => $layout])

@section('content')

    <h1 class="display-1 text-info">Скидки</h1>
    <div class="row">
        <div class="col-8 mr-auto">
            <div class="table-responsive">
                <table class="table text-info">
                    <tr class="bg-info">
                        <th>Наименование скидки</th>
                        <th>Подробнее</th>
                        <th>Процент скидки</th>
                        <th class="px-5">Дата создания</th>
                        <th></th>
                        <th></th>
                    </tr>
                @if (!empty($discounts))
                    @foreach ($discounts as $discount)
                        <tr>
                            <form action="/discounts/{{ $discount['id_discount'] }}/edit" method="post">
                            <td class="{{ $discount['id_discount'] == $newDiscountId ? 'bg-success text-light' : '' }}"><input type="text" class="form-control {{ $discount['id_discount'] == $newDiscountId ? 'bg-success text-light' : '' }}" name="newDiscountName" value="{{ $discount['name_discount'] }}" required></td>
                            <td class="{{ $discount['id_discount'] == $newDiscountId ? 'bg-success text-light' : '' }}"><a class="btn btn-outline-info {{ $discount['id_discount'] == $newDiscountId ? 'bg-success text-light border-light' : '' }}" href="/discounts/{{ $discount['id_discount'] }}">Подробнее</a></td>
                            <td class="{{ $discount['id_discount'] == $newDiscountId ? 'bg-success text-light' : '' }}"><input type="text" class="form-control {{ $discount['id_discount'] == $newDiscountId ? 'bg-success text-light' : '' }}" name="newDiscountPercent" value="{{ $discount['percent'] }}" required></td>
                            <td class="{{ $discount['id_discount'] == $newDiscountId ? 'bg-success text-light' : '' }}"><p class="lead {{ $discount['id_discount'] == $newDiscountId ? 'bg-success text-light' : '' }}">{{ $discount['created_at'] }}</p></td>
                            <td><input type="submit" value="Изменить" class="btn btn-outline-warning"></td>
                            </form>
                            <!-- Button trigger modal -->
                            <td><button type="button" class="btn btn-outline-danger" onclick="showModalConfirmation('discounts', {{ $discount['id_discount'] }}, 'скидки', 'эту скидку')" data-toggle="modal" data-target="#confirmation">
                            Удалить</button></td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endif
                </table>
            </div>
        </div>
        <div class="col-4">
            <form class="border border-info rounded p-3" action="/discounts/create" method="post">
                <div class="form-group">
                    <h4 class="display-4 text-info text-center">Новая скидка</h4>
                    <input type="text" class="col-10 mx-auto form-control text-center mb-3" name="newDiscountName" placeholder="Наименование скидки" required>
                    <input type="text" class="col-10 mx-auto form-control text-center" name="newDiscountPercent" placeholder="Процент скидки" required>
                </div>
                <button type="submit" class="col-6 btn btn-outline-info">Добавить</button>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="confirmation" tabindex="-1" discount="dialog" aria-labelledby="confirmationTitle" aria-hidden="true">
        <div class="modal-dialog" discount="document">
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
