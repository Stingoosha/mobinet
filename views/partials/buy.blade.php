<div class="block_buy">
    <input type="text" id="phone_id" value="{{ $phone['id'] }}" hidden>
    <input class="form-control text-center text-success font-weight-bold" type="number" id="amount_{{ $phone['id'] }}" value="{{ $amount ?? '1' }}"><br>
    <input class="btn btn-success" type="button" value="Купить" onclick="addToBasket({{ (int)$phone['id'] }})"><br>
    <span class="msg" style="color: orange; font-size: 20px" id="message_{{ $phone['id'] }}"></span>
</div>
