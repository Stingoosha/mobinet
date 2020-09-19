function selectBrand() {
    let brand = $(".brand");
    // console.log(brand);
    brand.click(function() {
        let checked = [];
        $('input:checkbox:checked').each(function() {
            checked.push($(this).val());
            // console.log(checked);
        });

        $.ajax({
            type: "post",
            url: "/selectBrand",
            data: "checked=" + checked,
            dataType: 'json',
            cache: false,
            success: function(answer) {
                // console.log(answer);
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
