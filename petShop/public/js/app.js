function addToCart(event) {
    var currentUrl = window.location.href;
    var url = event.target.getAttribute('data-url');
    var quantity = $('#quantity').val() ?? 1;
    url = url.slice(0, -1) + quantity;
    $.ajax({
        url: url,
        method: 'POST'
    }).then(function () {
        $.ajax({
            url: currentUrl,
            method: 'GET'
        }).then(function (data) {
            $('#body').html(data);
        })
    })
}

function removeFromCart(event, url) {
    $.ajax({
        url: url,
        method: 'DELETE'
    }).then(function (data) {
        $('#body').html(data);
    })
}

function updateQuantityFromCart(event) {
    event.preventDefault();
    var url = event.target.getAttribute('data-url');
    var quantity = event.target.value;
    url = url.slice(0, -1) + quantity;
    $.ajax({
        url: url,
        method: 'POST'
    }).then(function (data) {
        $('#body').html(data);
    })
}

function placeOrder(event, validationUrl, saveAddressUrl, placeOrderUrl, homepageUrl) {
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
        }
    }).then(function (data) {
        if (data['status'] == 200) {
            if ($('#placeOrderCheckbox').is(':checked')) {
                $.ajax({
                    url: saveAddressUrl,
                    method: 'POST',
                    data: {
                        country: country,
                        county: county,
                        city: city,
                        street: street,
                        number: number,
                        postalCode: postalCode,
                    },
                }).then(function () {
                    $.ajax({
                        url: placeOrderUrl,
                        method: 'POST',
                        data: {
                            saveAddress: true
                        }
                    }).then(function (data) {
                        $('#body').html(data);
                        window.history.pushState("data", "Animax", homepageUrl);
                    })
                })
            } else {
                $.ajax({
                    url: placeOrderUrl,
                    method: 'POST',
                    data: {
                        saveAddress: false,
                        country: country,
                        county: county,
                        city: city,
                        street: street,
                        number: number,
                        postalCode: postalCode,
                    }
                }).then(function (data) {
                    $('#body').html(data);
                    window.history.pushState("data", "Animax", homepageUrl);
                })
            }
        } else {
            $('#country').next().html(data['messages'].country);
            $('#county').next().html(data['messages'].county);
            $('#city').next().html(data['messages'].city);
            $('#street').next().html(data['messages'].street);
            $('#number').next().html(data['messages'].number);
            $('#postalCode').next().html(data['messages'].postalCode);
        }
    });
}

window.setTimeout(closeFlashMessage, 4000);

$('#close').on("click", closeFlashMessage);

function closeFlashMessage() {
    $('#flash-message').fadeTo(500, 0).slideUp(500, function () {
        $(this).remove();
    });
}

function updatePageByFilters(defaultUrl) {
    var currentUrl = window.location.href.split("?")[0];
    var url = currentUrl.includes('/products') ? currentUrl : defaultUrl;

    var sortDropdown = $('#sortDropdown option:selected') ?? null;

    var sortedOptionText = sortDropdown.text();
    var sort = sortDropdown.val() ? sortDropdown.val().split("-") : [];

    var sortBy = sort[0] === 'null' ? null : sort[0];
    var direction = sort[1] === 'null' ? null : sort[1];

    var minPrice = $('#minPrice').val();
    var maxPrice = $('#maxPrice').val();

    var productName = $('#productName').val();

    $.ajax({
        url: url,
        method: 'GET',
        data: {
            sortedOptionText: sortedOptionText,
            sortBy: sortBy,
            direction: direction,
            minPrice: minPrice,
            maxPrice: maxPrice,
            productName: productName,
        }
    }).then(function (data) {
        var newUrl = $(data).filter('#currentUrl').html();
        newUrl = newUrl.replaceAll("&amp;", "&");
        window.location = newUrl;
    })
}

slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n = 1) {
    showSlides(slideIndex += n);
}

function showSlides(n) {
    let i;
    let slides = document.getElementsByClassName("mySlides")
    if (slides[0]) {
        if (n > slides.length) {
            slideIndex = 1
        }
        if (n < 1) {
            slideIndex = slides.length
        }
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        slides[slideIndex - 1].style.display = "block";
    }
}

starRating("rating_form_stars_0");
starRating("rating_form_stars_1");
starRating("rating_form_stars_2");
starRating("rating_form_stars_3");
starRating("rating_form_stars_4");

// function starRating(id) {
//     $('#' + id).css("display", "none");
//
//     var star = $('label[for="' + id + '"]');
//
//     var starNumber = id.split("_")[3];
//
//     star.css("mix-blend-mode", "luminosity");
//
//     star.hover(function () {
//         for (var i = 0; i <= starNumber; i++) {
//             $('label[for="rating_form_stars_' + i + '"]').addClass("star-active");
//         }
//     }, function () {
//         if (!star.hasClass("active")) {
//             for (var i = 0; i <= starNumber; i++) {
//                 $('label[for="rating_form_stars_' + i + '"]').removeClass("star-active");
//             }
//         }
//     });
//
//     star.click(function () {
//         for (var i = 0; i <= 4; i++) {
//             $('label[for="rating_form_stars_' + i + '"]').removeClass("active");
//             $('label[for="rating_form_stars_' + i + '"]').removeClass("star-active");
//             $('label[for="rating_form_stars_' + i + '"]').off("mouseenter mouseleave");
//             $('#' + id).prop("checked", true);
//         }
//         if (!star.hasClass("active")) {
//             for (var i = 0; i <= starNumber; i++) {
//                 $('label[for="rating_form_stars_' + i + '"]').addClass("active");
//                 $('label[for="rating_form_stars_' + i + '"]').addClass("star-active");
//             }
//         }
//     });
// }

function starRating(id) {
    $('#' + id).hide();

    var star = $('label[for="' + id + '"]').css("mix-blend-mode", "luminosity");

    star.hover(function () {
        $('label[for^="rating_form_stars_"]').slice(0, Number(this.htmlFor.split("_")[3])+1).addClass("star-active");
    }, function () {
        $('label[for^="rating_form_stars_"]').not(".active").removeClass("star-active");
    });

    star.click(function () {
        $('label[for^="rating_form_stars_"]').removeClass("active star-active").off("mouseenter mouseleave");
        $('#' + id).prop("checked", true);
        $('label[for^="rating_form_stars_"]').slice(0, Number(this.htmlFor.split("_")[3])+1).addClass("active star-active");
    });
}
