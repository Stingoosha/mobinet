function addToBasket(id) {
    let msgs = $(".msg");
    let user_id = $("#user_id").val();
    let amount = $("#amount_" + id).val();
    let message_id = "message_" + id;
    let str = "user_id=" + user_id + "&phone_id=" + id + "&amount=" + amount + "&message_id=" + message_id;
    $.ajax({
        type: "post",
        url: "/tobasket",
        data: str,
        success: function(answer) {
            clearText(msgs);
            $("#" + message_id).text(answer);
        }
    });
}

function clearText(arr) {
    for (let i = 0; i < arr.length; i++) {
        let text = $(arr[i]).text('');
    }
}