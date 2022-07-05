function addToCart(event) {
    var currentUrl = window.location.href;
    var url = event.target.getAttribute('data-url');
    var quantity = $('#quantity').val() ?? 1;
    url = url.slice(0,-1) + quantity;
    $.ajax({
        url: url,
        method: 'POST'
    }).then(function (){
        $.ajax({
            url: currentUrl,
            method: 'GET'
        }).then(function (data){
            $('#body').html(data);
        })
    })
}

function removeFromCart(event, url) {
    $.ajax({
        url: url,
        method: 'DELETE'
    }).then(function (data){
        $('#body').html(data);
    })
}

function updateQuantityFromCart(event) {
    event.preventDefault();
    var url = event.target.getAttribute('data-url');
    var quantity = event.target.value;
    url = url.slice(0,-1) + quantity;
    $.ajax({
        url: url,
        method: 'POST'
    }).then(function (data){
        $('#body').html(data);
    })
}

function saveAddress(event, validationUrl, url) {
    var country = $('#country').val();
    var county = $('#county').val();
    var city = $('#city').val();
    var street = $('#street').val();
    var number = $('#number').val();
    var postalCode = $('#postalCode').val();
    $.ajax({
        url: validationUrl,
        method: 'POST',
        data: {
            country: country,
            county: county,
            city: city,
            street: street,
            number: number,
            postalCode: postalCode,
        },
        success: function (data) {
            if(data['status'] == 200){
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        country: country,
                        county: county,
                        city: city,
                        street: street,
                        number: number,
                        postalCode: postalCode,
                    },
                }).then(function (data){
                    $('#body').html(data);
                })
            }
            $('#country').next().html(data['messages'].country);
            $('#county').next().html(data['messages'].county);
            $('#city').next().html(data['messages'].city);
            $('#street').next().html(data['messages'].street);
            $('#number').next().html(data['messages'].number);
            $('#postalCode').next().html(data['messages'].postalCode);
        },
    });
}

window.setTimeout(function() {
    $('#flash-message').fadeTo(500, 0).slideUp(500, function(){
        $(this).remove();
    });
}, 4000);

$('#close').on("click", function (event) {
    $(this).parent().fadeOut();
    event.preventDefault();
});