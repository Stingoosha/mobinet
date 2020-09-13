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
            for (let i = 0; i < answer.length; i++) {
                let phoneCard = render(answer[i]);
                $('#showMore-container').append(phoneCard);
                lastId = answer[i].id;
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
    var $container = $('<div />', {
        class: 'col-2 mb-3'
    });
    var $cardDeck = $('<div />', {
        class: 'card-deck'
    });
    var $card = $('<div />', {
        class: 'card border-info text-info mb-3 h-100'
    });
    var $link = $('<a />', {
        class: 'link stretched-link',
        href: '/phones/' + element.id
    });
    var $img = $('<img />', {
        class: 'card-img-top',
        src: 'public/img/small/' + (element.photo ? element.photo : 'default.jpg')
    });
    var $cardBody = $('<div />', {
        class: 'card-body'
    });
    var $cardTitle = $('<h5 />', {
        class: 'card-title',
        text: element.name
    });
    var $cardText = $('<p />', {
        class: 'card-text text-success font-weight-bold',
        text: element.price + ' ₽'
    });

    $img.appendTo($link);
    $cardTitle.appendTo($cardBody);
    $cardText.appendTo($cardBody);
    $link.appendTo($card);
    $cardBody.appendTo($card);
    $card.appendTo($cardDeck);
    $cardDeck.appendTo($container);

    return $container;
}
