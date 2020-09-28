<div class="block_buy">
    <input type="text" id="phone_id" value="{{ $phone['id_good'] }}" hidden>
    <input class="form-control text-center text-success font-weight-bold" type="number" id="amount_{{ $phone['id_good'] }}" value="{{ $amount ?? '1' }}"><br>
    <input class="btn btn-success" type="button" value="Купить" onclick="addToBasket({{ (int)$phone['id_good'] }})"><br>
    <span class="msg" style="color: orange; font-size: 20px" id="message_{{ $phone['id_good'] }}"></span>
</div>
