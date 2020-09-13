function selectBrend() {
    $('#brends').click(function() {
        let checked = [];
        $('input:checkbox:checked').each(function() {
            checked.push($(this).val());
        });
        
        $.ajax({
            type: "post",
            url: "/selectBrend",
            data: "checked=" + checked,
            dataType: 'json',
            cache: false,
            success: function(answer) {

                $('#showMore-container').empty();
                $('#showMore-div').hide();
                let length = answer.length;
                for (let i = 0; i < length ; i++) {
                    let phoneCard = render(answer[i]);
                    $('#showMore-container').append(phoneCard);
                }
    
            }
        });
    });
}