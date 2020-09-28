function showMore(id, total) {

    $.ajax({
        type: "post",
        url: "/showMore",
        data: "lastId=" + id,
        dataType: 'json',
        cache: false,
        success: function(answer) {

            if (answer.length === 0) {
                $("#showMore-btn").hide();
            }

            let lastId;
            let length = answer.length;
            for (let i = 0; i < length; i++) {
                let phoneCard = render(answer[i]);
                $('#showMore-container').append(phoneCard);
                lastId = answer[i].id_good;
            }
            if (answer.length < total) {
                $("#showMore-btn").hide();
            } else {
                $("#showMore-btn").attr('onclick', 'showMore(' + lastId + ', ' + total + ');');
            }
        }
    });
}

function render(element) {
    var container = $('<div />', {
        class: 'col-2 mb-3'
    });
    var cardDeck = $('<div />', {
        class: 'card-deck'
    });
    var card = $('<div />', {
        class: 'card border-info text-info mb-3 h-100'
    });
    var link = $('<a />', {
        class: 'link stretched-link',
        href: '/phones/' + element.id_good
    });
    var img = $('<img />', {
        class: 'card-img-top px-3 py-1',
        style: 'height: 18rem',
        src: 'public/img/small/' + (element.photo ? element.photo : 'default.jpg')
    });
    var cardBody = $('<div />', {
        class: 'card-body'
    });
    var cardTitle = $('<h5 />', {
        class: 'card-title',
        text: element.name_good
    });
    var cardText = $('<p />', {
        class: 'card-text text-success font-weight-bold',
        text: element.price_good + ' ₽'
    });
    var blockBuy = $('<div />', {
        class: 'block_buy'
    });
    var phoneId = $('<input>', {
        type: 'text',
        id: 'phone_id',
        value: element.id_good,
        hidden: true
    });
    var amount = $('<input>', {
        class: 'form-control text-center text-success font-weight-bold',
        type: 'number',
        id: 'amount_' + element.id_good,
        value: 1
    });
    var btnBuy = $('<input>', {
        class: 'btn btn-success',
        type: 'button',
        value: 'Купить',
        onclick: 'addToBasket(' + element.id_good + ')'
    });
    var message = $('<span />', {
        class: 'msg',
        style: 'color: orange; font-size: 20px',
        id: 'message_' + element.id_good
    });
    var br = $('<br>');

    img.appendTo(link);
    cardTitle.appendTo(cardBody);
    cardText.appendTo(cardBody);
    link.appendTo(card);
    cardBody.appendTo(card);
    card.appendTo(cardDeck);
    cardDeck.appendTo(container);
    phoneId.appendTo(blockBuy);
    amount.appendTo(blockBuy);
    br.appendTo(blockBuy);
    btnBuy.appendTo(blockBuy);
    message.appendTo(blockBuy);
    blockBuy.appendTo(container);

    return container;
}
