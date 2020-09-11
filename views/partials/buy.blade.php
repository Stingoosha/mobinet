<div class="block_buy">
    <h3  class="description-title">Количество:</h3>
    <input type="text" id="user_id" value="{{ $userId ?? '' }}" hidden>
    <input type="text" id="phone_id" value="{{ $phone['id'] }}" hidden>
    <input type="number" id="amount_{{ $phone['id'] }}" value="{{ $amount ?? '1' }}"><br>
    <input type="button" value="Купить" onclick="addToBasket({{ (int)$phone['id'] }})"><br>
    <span class="msg" style="color: orange; font-size: 20px" id="message_{{ $phone['id'] }}"></span>
</div>
