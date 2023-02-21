$(document).ready(function() {
    $('.products-col .offersDiv').mouseleave(function(){
        // отвели курсор с объекта
        let offersDiv = event.target;
        let foot= offersDiv.closest('.product-item-foot');
        let divs=foot.querySelector('.offersDiv')

        divs.classList.add("hidden")

    });
    let addToFav = $('.add-to-favorites-btn');
    addToFav.each(function(index,el)
    {
        let product = $(el).data('product');
        window.elementHelpers.isFavoriteShow(product,this);
    });
    addToFav.on('click',function(){
        elementHelpers.clickFavorite($(this).data('product'),this);
        return false;
    })
    $('.products-col input[type="submit"]').mouseover(function() {
        let offersDiv = event.target;
        let foot= offersDiv.closest('.product-item-foot');
        let divs=foot.querySelector('.offersDiv')


        divs.classList.remove("hidden")
        //alert(foot.querySelector('.offersArray').innerHTML);
        /*var offers = JSON.parse(window.atob(foot.querySelector('.offersArray').innerHTML));
        let index;
        for (index = 0; index < offers.length; ++index) {
            console.log(offers[index]);
        }*/
    });

});
