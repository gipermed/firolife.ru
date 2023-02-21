$('.check1').click(sayHello);

function sayHello() {
    alert('Код подтверждения: ' + getRandomIntInclusive());
    $('.check1').css("display", "none");
    $('.check3').css("display", "block");
    $('#code').css("display", "block");
}

$('.check3').click(sayHello2);

function sayHello2() {
    alert('Код принят');
    $('.check2').css("display", "none");
    $('#code').css("display", "none");
    $('.registr').css("display", "none")
    $('.dillev').css("display", "block");
}

$('.curradio').click(curradio);

function curradio() {
    $('.curier').css("display", "block");
    $('.fio').css("display", "block");
    $('.punkt').css("display", "none");
    $('.samovivoz').css("display", "none");
    $('.fioinput').prop('required', true);
}

$('.samradio').click(samradio);

function samradio() {
    $('.samovivoz').css("display", "block");
    $('.punkt').css("display", "none");
    $('.curier').css("display", "none");
    $('.curieritog').css("display", "none");

}

$('.newadrradio').click(newadrradio);

function newadrradio() {
    $('.newadr').css("display", "block");
    $('#select').css("display", "none");
}

$('.myadrradio').click(myadrradio);

function myadrradio() {
    $('.newadr').css("display", "none");
    $('#select').css("display", "block");
}

$('.punktradio').click(punktradio);

function punktradio() {
    $('.curier').css("display", "none");
    $('.curieritog').css("display", "none");
    $('.samovivoz').css("display", "none");
    $('.punkt').css("display", "block");
    $('.fio').css("display", "block");
    $('.fioinput').prop('required', true);
}

$('.checkcur').click(btncheckcur);

function btncheckcur() {

    var city;

    if($('input[name="delivadr"]:checked').val() == 1)
    {
        city = $('.select option:selected').attr('adr');
    }
    else {
        city = $('.select2 option:selected').attr('adr');
    }
    getPrice(city);
    $('.curieritog').css("display", "block");
    $('#city').html(city);
    $('.curier').css("display", "none");
    $('.nameuser').css("display", "block");
    $('.send').css("display", "block");
}

$('.samradio').click(btnchecksamradio);

function btnchecksamradio() {
    $('.send').css("display", "block");
    $('.fio').css("display", "none");
    $('.fioinput').prop('required', false);
}

function getRandomIntInclusive() {
    min = Math.ceil(1000);
    max = Math.floor(9999);
    return Math.floor(Math.random() * (max - min + 1)) + min; //Максимум и минимум включаются
}

$('.check3 ').click(getRegionDev);
function getRegionDev() {
    var getregion = sessionStorage.getItem('region');
    var getcity = sessionStorage.getItem('city');
    if (getregion.includes("Московская область")
        || getregion.includes("Москва")
    )
        $('.samoviviz').css("display", "block")
    else $('.samoviviz').css("display", "none")
    getPrice(getcity);
}

function getPrice(city){

    new ISDEKWidjet({
        defaultCity: city,
        cityFrom: 'Москва',
        country: 'Россия',
        link: true,
        onCalculate: function(wat){

            $("#SDEK_cPrice2").text(wat.profiles.courier.price);
            $("#SDEK_cPrice").text(wat.profiles.pickup.price);
            $("#SDEK_cPrice3").text(wat.profiles.courier.price);
        }
    });
}
// $(function ($) {
//     $(".phone").mask("+7 (999) 999-9999");
// });

$(document).ready(function () {
    $('.cabinet-address-input-city2').select2();

// console.log($('.js-prymery__geoip__city__line-city:first').text());

//
// var cookiesAr = document.cookie.split('; ');
// var cookiesSplit = {};
// for(var i=0;i<cookiesAr.length;i++){
//    var curCookie = cookiesAr[i].split('=');
//     cookiesSplit[curCookie[0]] = curCookie[1];
// }
});
