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

window.setTimeout(function() {
    $('#flash-message').fadeTo(500, 0).slideUp(500, function(){
        $(this).remove();
    });
}, 4000);

$('#close').on("click", function (event) {
    $(this).parent().fadeOut();
    event.preventDefault();
});