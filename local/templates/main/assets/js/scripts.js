'use strict';
// import {clickFavorite} from "../../../../../../scp58331/local/templates/main/assets/js/helpers/catalogElement";
(function ($) {
    $(function() {
        BX.addCustomEvent('onAjaxSuccess', function(e,dd){
            $(function() {
                if(e['order']){
                    var have_pickup = false;
                    for(var i=0;i<e['order']['DELIVERY'].length;i++){
                        if(e['order']['DELIVERY'][i]['ID'] == 15){
                            have_pickup = true;
                        }
                        if(e['order']['DELIVERY'][i]['CHECKED']){
                            if($('input[name=DELIVERY_ID]:checked').val() != e['order']['DELIVERY'][i]['CHECKED']){
                                if(dd.url == '/bitrix/components/bitrix/sale.order.ajax/ajax.php'){
                                    $('.order__delivery-info').show();
                                    var select_id = $('input[name=DELIVERY_ID]:checked').val();
                                    $('.order__delivery-item').removeClass('active');
                                    //$('.order__address-result').hide();
                                    if($('.order__address-result:visible').length == 0) {
                                        $('.order__delivery-item[data-val=' + select_id + ']').addClass('active');
                                        $('.order__delivery-item[data-val=' + select_id + ']').show();
                                        $('.order__delivery-item[data-val2=' + select_id + ']').addClass('active');
                                        $('.order__delivery-item[data-val2=' + select_id + ']').show();
                                        $('.order__delivery-item[data-val3=' + select_id + ']').addClass('active');
                                        $('.order__delivery-item[data-val3=' + select_id + ']').show();
                                        $('.order__delivery-item[data-val4=' + select_id + ']').addClass('active');
                                        $('.order__delivery-item[data-val4=' + select_id + ']').show();
                                        $('.order__delivery-item[data-val5=' + select_id + ']').addClass('active');
                                        $('.order__delivery-item[data-val5=' + select_id + ']').show();
                                    }
									if(select_id == 15){
										$('.jsOrder__store:first').click();
									}

                                    $('.order__delivery-select-content').removeClass('active');
                                }
                            }
                        }
                    }
                    if(have_pickup){
                        $('.parent_store').show();
                    }else{
                        $('.parent_store').hide();
                        $('input[name=DELIVERY_TYPE_2]').prop('checked',false);
                        $('.parent_pvz').find('input[name=DELIVERY_TYPE_2]').prop('checked',true);
                        $('.parent_pvz').addClass('active');
                    }
                    $('.order__delivery-header-item.active').click();
                }
            });

            /*$('input[name=ORDER_PROP_4]:not(.init)').on('change',function(){
                $.getJSON('/local/ajax/set_location.php',
                    {
                        CITY_CODE: $(this).val(),
                        ACTION: 'select',
                    },
                    function (data) {
                        $('.jsOrder__address').hide();
                        $('.jsOrder__address[data-city='+data['NAME_RU']+']').show();
                    }
                );
            });*/
            $('input[name=ORDER_PROP_4]').addClass('init');
			
        });

        var select_id = $('input[name=DELIVERY_ID]:checked').val();
        $('.order__delivery-item').removeClass('active');
        $('.order__address-result').hide();
        $('.order__delivery-item[data-val='+select_id+']').addClass('active');
        $('.order__delivery-item[data-val='+select_id+']').show();
        $('.order__delivery-item[data-val2='+select_id+']').addClass('active');
        $('.order__delivery-item[data-val2='+select_id+']').show();
        $('.order__delivery-item[data-val3='+select_id+']').addClass('active');
        $('.order__delivery-item[data-val3='+select_id+']').show();
        $('.order__delivery-item[data-val4='+select_id+']').addClass('active');
        $('.order__delivery-item[data-val4='+select_id+']').show();
        $('.order__delivery-item[data-val5='+select_id+']').addClass('active');
        $('.order__delivery-item[data-val5='+select_id+']').show();




    });
})(jQuery);
function clickFavorite(id){
    isFavorite(id,0);
}
function isFavoriteShow(id){
    isFavorite(id,1);
}
function isFavorite(id,action){
    axios.get('/ajax/', {
        params: {
            ID: id,
            action: 'is-favorite',
            sessid: BX.bitrix_sessid(),
        }
    }).then(response => {
        let favInfo = response.data.result['favorite'];

        if(action == 1){
            if (favInfo) {
                $('[data-product='+id+']').addClass("active").find('span').text("Удалить из избранного");
            }
        }else{
            if (favInfo) {
                removeFromFavorite(id);
            } else {
                addToFavorite(id);
            }
        }

    });
}
function removeFromFavorite(id){
    axios.get('/ajax/', {
        params: {
            ID: id,
            action: 'remove-from-favorites',
            sessid: BX.bitrix_sessid(),
        }
    }).then(response => {
        if (response.data.success) {
            // $('[data-product='+id+']').addClass("active").find('span').text("Удалить из избранного");
            $('[data-product='+id+']').removeClass("active").find('span').text("В избранное");
        }
    });
}
function addToFavorite(id){
    axios.get('/ajax/', {
        params: {
            ID: id,
            action: 'add-to-favorites',
            sessid: BX.bitrix_sessid(),
        }
    }).then(response => {
        if (response.data.success) {
            $('[data-product='+id+']').addClass("active").find('span').text("Удалить из избранного");
            // $('[data-product='+id+']').removeClass("active").find('span').text("В избранное");
        }
    });
}


$(document).ready(function () {
    $('.brands-tabs__item').on('click',function(){
        $('.brands-tabs-block').removeClass('active').hide();
        $('.brands-tabs__item').removeClass('active');
        $(this).addClass('active');
        $('.brands-tabs-block[data-type='+$(this).data("type")+']').show().addClass('active');
    })
    setTimeout(function hideQuestion() {$('.js-bxmaker__geoip__city__line-question').hide();}, 5000);
	$('.orderSubmitUnAuth').on('click', function(e) {

		$('html, body').animate({
			scrollTop: $('body').offset().top
		}, {
			duration: 370,
			easing: "linear"
		});
		$('.alert-danger').hide();
		
		$('.order__phone-auth .order__phone-input').addClass('novalid');
		$('.orderSubmitError').show();
		e.preventDefault();
		return false;
	});


    if($(window).width() < 768) {
        $('.is-parent.catalog-menu-level-2 > a').on('click', function (e) {
            $(this).toggleClass('active');
            $(this).parent().find('.catalog-items-3').slideToggle();
            e.preventDefault();
        });
    }

    $('html').keydown(function(e){
        if (e.keyCode == 13) {
            if($('.bxmaker-authuserphone-login-link:visible').length > 0){
                $('.bxmaker-authuserphone-login-link').click();
            }
            if($('.cbaup_btn:visible').length > 0){
                $('.cbaup_btn:visible').click();
            }

             /*if($('.header-search-input:visible').length > 0){
                $('.header-search-submit:visible').click();
            }*/

            e.preventDefault();
        }
    });

    $('#title-search-input').focus(function(){        
        $('html').keydown(function(e) {
            if (e.keyCode == 13) {
                $('.header-search-submit:visible').click();
            }
        })
    });

     $(".js-phone-masked2").focus(function(){       
        if($('.bxmaker-authuserphone-login-link:visible').length > 0){
            $('.bxmaker-authuserphone-login-link').click();
        }
    });

    $('.cart__sticky2').stick_in_parent();
    //cart-sidebar
    if($('.cart-body').height() > $('.cart__sticky2').height()){
        // var sticky = new Sticky('.cart__sticky2');
    }

    $('.filter__showmore').on('click',function(){
       $(this).hide();
       $(this).parent().find('.form-group').show();
    });

    //choose first delivery
    if($('.bx-soa-pp-company.order__delivery-service:visible:first').length > 0){
        $('.bx-soa-pp-company.order__delivery-service:visible:first').find('input[name=DELIVERY_ID]').prop('checked',true);
        $('.bx-soa-pp-company.order__delivery-service:visible:first').find('input[name=DELIVERY_ID]').change();
        BX.Sale.OrderAjaxComponent.sendRequest('refreshOrderAjax');
    }

    // $('.select2-container--disabled').on('click',function(){
    //     if($(this).prev().attr('id') == 'my_sity'){
    //
    //     }
    // });

    $('.js-send-email').on('change',function(){
        $('input[name=ORDER_PROP_2]').val($(this).val());
    });

    $('.order__delivery-header-item').on('click',function(){
        $('.order__delivery-header-item').removeClass('active');
        $(this).addClass('active');
        $('.order__delivery-header-item').find('input').prop('checked',false);
        $(this).find('input').prop('checked',true);
        $(this).find('input:checked').change();
    });
    $('.order__custom-radio').on('click',function(){
        $(this).next('label').click();
    });
    $('input[name=DELIVERY_TYPE]').on('change',function(){
        $('.order__delivery-info').hide();
        $('.order__address-result').hide();
        var select_1_level = $('input[name=DELIVERY_TYPE]:checked').val();
        if(JS_DELIVERIES[select_1_level]['SUB']){
            $('.order__delivery-header').show();

            $('.order__delivery-service').hide();
            var first_index = $('.parent_'+select_1_level+'.active').find('input').val();

            if(JS_DELIVERIES[select_1_level]['SUB'][first_index]['ITEMS']){
                for(var i=0;i<JS_DELIVERIES[select_1_level]['SUB'][first_index]['ITEMS'].length;i++){
                    $('.deliveryId_'+JS_DELIVERIES[select_1_level]['SUB'][first_index]['ITEMS'][i]['PROPERTY_ID_VALUE']).show();
                }
            }
        }else{
            $('.order__delivery-header').hide();
            $('.order__delivery-service').hide();
            if(JS_DELIVERIES[select_1_level]['ITEMS']){
                for(var i=0;i<JS_DELIVERIES[select_1_level]['ITEMS'].length;i++){
                    $('.deliveryId_'+JS_DELIVERIES[select_1_level]['ITEMS'][i]['PROPERTY_ID_VALUE']).show();
                }
            }
        }
        // $('input[name=DELIVERY_ID]:checked').parent().removeClass('bx-selected');
        // $('input[name=DELIVERY_ID]:checked').prop('checked',false);
        $('#bx-soa-delivery').find('.order__delivery-service:visible').click();

        if($('.deliveryId_'+$('input[name=DELIVERY_ID]:checked').val()+':visible').length>0){
            $('.order__delivery-info').show();
        }
    });
    $('input[name=DELIVERY_TYPE_2]').on('change',function(){
        var select_1_level = $('input[name=DELIVERY_TYPE]:checked').val();
        var select_2_level = $('input[name=DELIVERY_TYPE_2]:checked').val();

        $('.order__delivery-service').hide();
        $('.order__delivery-info').hide();
        if(JS_DELIVERIES[select_1_level]['SUB']){
            if(JS_DELIVERIES[select_1_level]['SUB'][select_2_level]['ITEMS']){
                for(var i=0;i<JS_DELIVERIES[select_1_level]['SUB'][select_2_level]['ITEMS'].length;i++){
                    $('.deliveryId_'+JS_DELIVERIES[select_1_level]['SUB'][select_2_level]['ITEMS'][i]['PROPERTY_ID_VALUE']).show();
                }
            }
        }else if(JS_DELIVERIES[select_1_level]['ITEMS']){
            for(var i=0;i<JS_DELIVERIES[select_1_level]['ITEMS'].length;i++){
                $('.deliveryId_'+JS_DELIVERIES[select_1_level]['ITEMS'][i]['PROPERTY_ID_VALUE']).show();
            }
        }

        var curParentPrice = 0, curParentPriceFormat;
        $('.order__delivery-service:visible').each(function(){
            var servicePrice = Number($(this).find('.bx-soa-pp-delivery-cost').html().replace(/[^0-9]/g,""));
            if(curParentPrice == 0 || curParentPrice>servicePrice){
                curParentPrice = servicePrice;
                curParentPriceFormat = $(this).find('.bx-soa-pp-delivery-cost').html();
            }
        });
        if(curParentPrice == 0){
            curParentPriceFormat = 'Бесплатно';
        }else{
            curParentPriceFormat = 'от '+curParentPriceFormat;
        }
        $('.order__delivery-header-item.active .order__delivery-header-cost').html(curParentPriceFormat);
        if($('.deliveryId_'+$('input[name=DELIVERY_ID]:checked').val()+':visible').length>0){
            $('.order__delivery-info').show();
        }
		var select_delivery = false;
		if($('.bx-soa-pp-company.order__delivery-service:visible:first').length > 0){
			$('.bx-soa-pp-company.order__delivery-service:visible').each(function(){
				if($(this).find('input[name=DELIVERY_ID').prop('checked') == true){
					select_delivery = true;
				}
			});
			
			if(!select_delivery){
				$('.bx-soa-pp-company.order__delivery-service:visible:first').find('input[name=DELIVERY_ID]').prop('checked',true);
				$('.bx-soa-pp-company.order__delivery-service:visible:first').find('input[name=DELIVERY_ID]').change();
				$('.bx-soa-pp-company.order__delivery-service:visible:first').click();
			}
			
			
			//BX.Sale.OrderAjaxComponent.sendRequest('refreshOrderAjax');
		}
    });

    $('input[name=SEND_EMAIL]').on('change',function(){
        if($('input[name=SEND_EMAIL]:checked').val() == 'on'){
            $('.cart-sidebar__email').slideDown(300);
        }else{
            $('.cart-sidebar__email').slideUp(300);
        }
    })
    $('.cart-sidebar__clear').on('click',function(){
        $('.cart-sidebar__input').val('');
    });
    $('input').on('focus',function(){
        $(this).removeClass('novalid');
    })
    $('.jsEditData').on('click',function(){
        $('.order__address-result').hide();
        var select_id = $('input[name=DELIVERY_ID]:checked').val();
        $('.order__delivery-item[data-val='+select_id+']').show();
        $('.order__delivery-item[data-val2='+select_id+']').show();
        $('.order__delivery-item[data-val3='+select_id+']').show();
        $('.order__delivery-item[data-val4='+select_id+']').show();
        $('.order__delivery-item[data-val5='+select_id+']').show();
    });
    $('.jsShowPvz').on('click',function(){
        if(!$('input[name=ADDRESS_FIO2]').val()){
            $('input[name=ADDRESS_FIO2]').addClass('novalid');                     
        }
        return false;
    });
    $('.jsApplyAddress').on('click',function(){
        var addressId = $('.jsOrder__addressId').val();
        var fio = $('input[name=ADDRESS_FIO]').val();
        var full_address = $('.jsOrder__addressFull').val();

        if(!fio){
            $('input[name=ADDRESS_FIO]').addClass('novalid');
        }

        if(addressId && fio){
            $('input[name=ORDER_PROP_1]').val(fio);
            $('.order__delivery-item').hide();
            $('.order__address-result').show();
            $('.jsFioAddress').html($('input[name=ADDRESS_FIO]').val());
            $('.jsFullAddress').html(full_address);
            $('.jsPriceAddress').html($('.bx-selected .bx-soa-pp-delivery-cost').text());
        }
    });
    $('.jsOrderNewAddress').on('click',function(){
        var t = $(this).closest('.order__delivery-add');
        var code = $('.cabinet-address-input-city option:selected').attr('value');
        var index = $('.cabinet-address-input-city option:selected').attr('ind');
        var street = $('#my_street option:selected').attr('value');
        var street2 = $('.jsStreet2').val();

        var title = t.find('.cabinet-address-input-title').val();
        var city =  t.find('.cabinet-address-input-city').val();
        var region =$('.cabinet-address-input-city option:selected').attr('region');
        var comment = t.find('.cabinet-address-input-comment').val();
        var isMain = t.find('.cabinet-address-input-main').prop('checked');
        var data = city;
        var item;
        var arr = [];
        arr.push(code);
        arr.push(index);
        arr.push(region);
        arr.push(title);
        arr.push(city);
        arr.push(comment);
        arr.push(isMain);
        arr.push(street);
        arr.push(street2);
        t.find('.cabinet-address-input-data').each(function () {
            var value = $(this).val();
            if (!value) {arr.push(""); return;}
            var inputTitle = $(this).closest('.form-block').find('.form-block-title').text().toLowerCase();
            data += ", ".concat(inputTitle, " ").concat(value);
            arr.push(value);
        });
        if(!$('input[name=ADDRESS_FIO]').val()){
            $('input[name=ADDRESS_FIO]').addClass('novalid');
        }
        if(code && city && street && $('input[name=ADDRESS_FIO]').val()){
            // $.ajax({
            //     url: '/ajax/input_ajax.php',
            //     method: 'post',
            //     dataType: 'html',
            //     data: {action: "new", arr: arr},
            // });

            if(street2){
                var cur_street = street2;
            }else{
                var cur_street = $('#my_street option:selected').text();
            }

            var full_address = 'Нас. пункт: '+$('#my_sity option:selected').text()+', ул. '+cur_street+', дом '+ arr[9] + ', корп. '+ arr[10]+ ', стр. ' + arr[11]+', под. '+ arr[12]+', кв. '+ arr[13];

            $('.order__delivery-item').hide();
            $('.order__address-result').show();
            $('input[name=ORDER_PROP_1]').val($('input[name=ADDRESS_FIO]').val());
            $('.jsFioAddress').html($('input[name=ADDRESS_FIO]').val());
            $('.jsFullAddress').html(full_address);
            $('input[name=ORDER_PROP_6]').val(full_address);
            $('.jsPriceAddress').html($('.bx-selected .bx-soa-pp-delivery-cost').text());
        }
        $('input[name=ORDER_PROP_11]').val('');
        $('.jsStoreName').html('Выберите магазин');
        $('.jsStoreName').parent().removeClass('active').removeClass('selected');
    });
    $('input[name=ADDRESS_TYPE]').on('change',function(){
       var select_id = $('input[name=ADDRESS_TYPE]:checked').val();
        if(select_id == 'new'){
            $('.order__delivery-add').slideDown(300);
            $('.jsPersonalAddress').slideUp(300);
        }else{
            $('.order__delivery-add').slideUp(300);
            $('.jsPersonalAddress').slideDown(300);
        }
    });
    $('.order__delivery-select-title').on('click',function(){
        $(this).toggleClass('active');
        $('.order__delivery-select-content').toggleClass('active');
        if($('.order__delivery-select-content').hasClass('active')){
            $('.order__delivery-select-content').slideDown(300);
        }else{
            $('.order__delivery-select-content').slideUp(300);
        }
    });
    $('.order__delivery-select-item').on('click',function(){
        var id = $(this).data('id');
        var name = $(this).data('name');

        if($(this).hasClass('jsOrder__store')){
            $('input[name=ORDER_PROP_11]').val(id);
            $('input[name=ORDER_PROP_6]').val('');
        }
        if($(this).hasClass('jsOrder__address')){
            $('input[name=ORDER_PROP_11]').val('');
            $('.jsStoreName').html('Выберите магазин');
            $('.jsStoreName').parent().removeClass('active').removeClass('selected');
            $('input[name=ORDER_PROP_12]').val(id);
            $('input[name=ORDER_PROP_6]').val($(this).data('full'));
        }

        // $('.jsStoreName').html(name);
        $(this).closest('.order__delivery-select').find('.jsStoreName').html(name);
        $('.order__delivery-select-content').slideUp(300);
        $('.order__delivery-select-title').toggleClass('active');
        $('.order__delivery-select-content').toggleClass('active');
        $('.order__delivery-select-title').addClass('selected');
    });
    /*if($('.js_location_confirm').attr('data-confirm') != 'Y'){
        $('.prymery__geoip__popup-option--bold').removeClass('prymery__geoip__popup-option--bold');
        ymaps.ready(init);
        function init(){
            $.getJSON('/local/ajax/set_location.php',
                {
                    DATA: ymaps.geolocation,
                },
                function (data) {
                    if(data['NAME_RU']){
                        $('body').find('.js-prymery__geoip__city__line-city').click();
                        $('body').find('.js-prymery__geoip__city__line-question-btn-yes').attr('data-id',data['ID']);
                        $('body').find('.js-prymery__geoip__city__line-city').html(data['NAME_RU']);
                        $('body').find('.prymery__geoip__popup-search input[name=city]').val(data['NAME_RU']);
                        $('body').find('.prymery__geoip__popup-search input[name=city]').keyup();
                        $('body').find('.js-prymery__geoip__popup').addClass('importantHide');
                        $('body').find('.js-prymery__geoip__popup-background').hide();
                        $('body').find('.js-prymery__geoip__popup-content').hide();
                        $('body').find('.js-prymery__geoip__city__line-question').addClass('geoip_active-show');
                        $.getJSON('/local/ajax/set_location.php',
                            {
                                CITY_ID: data['ID'],
                                ACTION: 'select',
                            },
                            function (data) {
                                $('body').find('.js-prymery__geoip__city__line-question').css({'display':'block','opactiy':'1'});
                                $('body').find('.js-prymery__geoip__city__line-question').removeClass('geoip_active-show');
                            }
                        );
                    }
                }
            );
        }
    }*/

    $('.order__phone-btn').on('click',function(e){
        var phone = $('.order__phone-input').val();
        $('#modal-enter .phone').val(phone);
        $('.codeLinkJs').click();
    });
    $('.order__modalpayments-close').on('click',function(e){
        $('.order__modalpayments').hide();
        e.preventDefault();
    });
    $('.js-prymery__geoip__city__line-question-btn-yes').on('click',function(e){
        var id = $(this).data('id');

        // if($('.js-prymery__geoip__popup-option[data-id='+id+']').length == 0){
        //     $('.prymery__geoip__popup-options-col:last-child .js-prymery__geoip__popup-option:last-child').attr('data-id',id);
        // }

        $('body').find('.js-prymery__geoip__city__line-city').click();
        // $('.prymery__geoip__popup-search input[name=city]').keyup();
        $('.js-prymery__geoip__popup-search-option[data-location='+id+']').click();

        $('body').find('.js-prymery__geoip__popup-option[data-id='+id+']').click();
        $('body').find('.js-prymery__geoip__popup').addClass('importantHide');
        $('body').find('.js-prymery__geoip__popup-background').hide();
        $('body').find('.js-prymery__geoip__popup-content').hide();
    });

    $('.js-prymery__geoip__city__line-city').on('click',function(){
        if($('body').find('.js-prymery__geoip__popup').hasClass('importantHide')){
            $('body').find('.js-prymery__geoip__popup').removeClass('importantHide');
            $('body').find('.js-prymery__geoip__popup-background').show();
            $('body').find('.js-prymery__geoip__popup-content').show();
            $('.js-prymery__geoip__city__line-city').click();
        }
    });
    $(".js-phone-masked2").inputmask("+7 (999) 999-99-99",{ showMaskOnHover: false });
    $('.custom-file__value').on('change', function(){
        const chooseSelector = this;
        const chooseFiles = chooseSelector.files[0];
        if ( chooseFiles ) {
            const fileReader = new FileReader();
            fileReader.readAsDataURL(chooseFiles);
            fileReader.addEventListener("load", function () {
                $(chooseSelector).closest('.custom-file__item').addClass('file-loaded');
                $(chooseSelector).prev().empty().append('<img src="' + this.result + '" />');
            });
        }
    });

    const chooseFile = document.querySelector('.reviews-photo__value');
    $('.reviews-photo__value').on('change', function(){
        getImgData();
    });

    function getImgData() {
        const files = chooseFile.files;
        if (files) {
            $('.review-item__photo').removeClass('current-photo').empty();
            for ( let i = 0; i < chooseFile.files.length; i++ ) {
                const fileReader = new FileReader();
                fileReader.readAsDataURL(files[i]);
                fileReader.addEventListener("load", function () {
                    $('.review-item__photo').eq(i).append('<img src="' + this.result + '" />');
                });
            }
            if ( chooseFile.files.length < 5 ) {
                $('.review-item__photo').eq(chooseFile.files.length).addClass('current-photo');
            }
        }
    }

    $(".js-datepicker").datepicker({
        dateFormat: 'dd/mm/yy',
        changeYear: true,
        changeMonth: true,
        yearRange: "1940:2006",
        firstDay: 1,
        monthNames : ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь' ],
        monthNamesShort : [ 'Янв', 'Февр', 'Март', 'Апр', 'Май', 'Июнь', 'Июль', 'Авг', 'Сент', 'Окт', 'Нояб', 'Дек' ],
        dayNames: ['Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота',  'Воскресенье' ],
        dayNamesMin: [ 'Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб' ],
    });

    $('.jsChangeMail').on('click',function(){
        $.getJSON('/local/ajax/profile.php',
            {
                FIELD: 'EMAIL',
                PROMO_UPDATE: 'Y',
                VAL: $(this).prev().val()
            },
            function (data) {

            }
        );
    });
    $('.jsDelProfile').on('click',function(){
        $.getJSON('/local/ajax/del_profile.php',
            {
                DEL: 'Y',
            },
            function (data) {                
                location.reload();
            }
        );
    });

    $(document).on('click', '.toggle-order-extra', function(){
        $(this).toggleClass('open').prev().stop().slideToggle();
    });

    $('.jsCloseModal').on('click',function(){
        $('.modal-profile-delete').removeClass('open');
    });

    $('.notification-enable-all').on('click', function(){
        $('.notification-checkbox').addClass('active');
        $('.notification-checkbox').find('.checkbox-input').prop('checked', true);
    });

    $('.notification-disable-all').on('click', function(){
        $('.notification-checkbox').removeClass('active');
        $('.notification-checkbox').find('.checkbox-input').prop('checked', false);
    });

    $('.edit-personal-value').on('click', function(){
        $(this).closest('.personal-info__val').addClass('editing').removeClass('editing-complete');
    });

    $('.personal-info__val .custom-checkbox').on('click', function(){
        let currentTextValue = $(this).find('.custom-checkbox__text').text();
        $(this).closest('.personal-info__val').removeClass('editing').addClass('editing-complete');
        $(this).closest('.personal-info__val').find('.personal-info__val__current').text(currentTextValue);

        $.getJSON('/local/ajax/profile.php',
            {
                FIELD: 'GENDER',
                VAL: $('input[name=personal-gender]:checked').val()
            },
            function (data) {

            }
        );
    });
    $('input[name=personal-birthday]').on('change', function(){
        $.getJSON('/local/ajax/profile.php',
            {
                FIELD: 'HB',
                VAL: $('input[name=personal-birthday]').val()
            },
            function (data) {

            }
        );
    });
    $('.nameComplete').on('click', function(){
        $.getJSON('/local/ajax/profile.php',
            {
                FIELD: 'NAME',
                VAL: $('input[name=user-name]').val()
            },
            function (data) {

            }
        );
    });
    $('.notification-enable-all').on('click', function(){
        $.getJSON('/local/ajax/profile.php',
            {
                FIELD: 'ALL_PROMO',
                VAL: 1
            },
            function (data) {

            }
        );
    });
    $('.notification-disable-all').on('click', function(){
        $.getJSON('/local/ajax/profile.php',
            {
                FIELD: 'ALL_PROMO',
                VAL: 0
            },
            function (data) {

            }
        );
    });
    $('.promoJs').on('change', function(){
        if($(this).prop('checked')){
            var val = 1;
        }else{
            var val = 0;
        }
        $.getJSON('/local/ajax/profile.php',
            {
                PROMO_UPDATE: 'Y',
                FIELD: $(this).data('code'),
                VAL: val
            },
            function (data) {

            }
        );
    });
    $('.delAwait').on('click', function(){
        $.getJSON('/local/ajax/del_await.php',
            {
                ITEM_ID: $(this).data('product'),
                ID: $(this).data('id'),
                ACTION: 'DEL'
            },
            function (data) {
                location.reload();
            }
        );
    });

    $('.product-reviews-count').on('click', function(){
        $([document.documentElement, document.body]).animate({
            scrollTop: $(".product-tabs-section").offset().top
        }, 1000);
        $('.product-tabs-nav li, .product-tabs-section .tab-block').removeClass('active');
        $('.product-tabs-nav li:nth-child(2)').addClass('active');
        $('#product-tab-2').addClass('active');

    });

    $('.step-completed').on('click', function(){
        let currentTextValue = $(this).prev().val();
        $(this).closest('.personal-info__val').removeClass('editing').addClass('editing-complete');
        $(this).closest('.personal-info__val').find('.personal-info__val__current').text(currentTextValue);
    });

    $('.custom-modal__close, .custom-modal__bg').on('click', function(e){
        e.preventDefault();
        $(this).closest('.custom-modal').toggleClass('open');
    });

    $('.js-open-profile-delete').on('click', function(e){
        e.preventDefault();
        $('.modal-profile-delete').addClass('open');
    });

    $('.js-open-user-enter').on('click', function(e){
        e.preventDefault();
        $('.modal-user-enter').addClass('open');
    });

    $('.btn-review-toggle').on('click', function(e){
        e.preventDefault();
        if ( $(this).hasClass('js-open-user-enter') ) { return; }
        $(this).closest('.product-tab-section').find('.btn-review-toggle').toggleClass('active');
        $(this).closest('.product-tab-section').find('.new-review-add').stop().slideToggle();
    });

    $('.new-review-cancel').on('click', function(e){
        e.preventDefault();
        $(this).closest('.product-tab-section').find('.btn-review-toggle').toggleClass('active');
        $(this).closest('.product-tab-section').find('.new-review-add').stop().slideToggle();
    });

    $('.js-rating-star li').on('mouseenter', function(){
        if ( $(this).closest('.js-rating-star').hasClass('rating-set') ) { return; }
        let ratingIndex = $(this).index();
        $('.js-rating-star li').removeClass('active');
        for ( let i = 0; i <= ratingIndex; i++ ) {
            $('.js-rating-star li').eq(i).addClass('active');
        }
    });

    $('.js-rating-star li').on('click', function(){
        $('.js-rating-star').addClass('rating-set');
        let ratingIndex = $(this).index();
        $('rating-value').val(ratingIndex);
        $('.js-rating-star li').removeClass('active');
        for ( let i = 0; i <= ratingIndex; i++ ) {
            $('.js-rating-star li').eq(i).addClass('active');
        }
        $('.rating-value').val(ratingIndex+1);
    });

    $('.js-review-message').on('input', function(){
        $('.review-current-symbols').text($(this).val().length);
    });

    let productHotSlidersList = document.querySelectorAll('.product-hot-slider-container ');
    productHotSlidersList.forEach(function(sliderItem) {
        const swiper = new Swiper(sliderItem.querySelector('.product-hot-slider'), {
            speed: 700,
            slidesPerView: 2,
            breakpoints: {
                320: {
                    spaceBetween: 6,
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 3,
                },
                992: {
                    spaceBetween: 30,
                    slidesPerView: 3,
                }
            }
        });
    });

    var productSlidersList = document.querySelectorAll('.product-item-slider-container');
    productSlidersList.forEach(function(sliderItem) {
        const swiper = new Swiper(sliderItem.querySelector('.product-item-slider'), {
            speed: 700,
            slidesPerView: 5,
            navigation: {
                nextEl: sliderItem.querySelector('.swiper-button-next'),
                prevEl: sliderItem.querySelector('.swiper-button-prev'),
            },
            breakpoints: {
                320: {
                    spaceBetween: 6,
                    slidesPerView: 2,
                },
                576: {
                    slidesPerView: 3,
                },
                992: {
                    spaceBetween: 30,
                    slidesPerView: 5,
                }
            }
        });
    });

    var brandsSlidersList = document.querySelectorAll('.brands-slider-container');
    brandsSlidersList.forEach(function(sliderItem) {
        const brandsSwiper = new Swiper(sliderItem.querySelector('.brands-main-slider'), {
            speed: 700,
            loop: false,
            spaceBetween: 6,
            slidesPerView: 'auto',
            navigation: {
                nextEl: sliderItem.querySelector('.swiper-button-next'),
                prevEl: sliderItem.querySelector('.swiper-button-prev'),
            },
            breakpoints: {
                768: {
                    slidesPerView: 3,
                },
                992: {
                    spaceBetween: 28,
                    slidesPerView: 5,
                },
                1366: {
                    spaceBetween: 28,
                    slidesPerView: 8,
                }
            }
        });
    });

    $('.form-order-cancel').on('submit',function(){
        $('.order-cancel__success').addClass('visible');
    });
    $(document).on('change, keyup', '.order__phone-input', function(){
        if($(this).val() && $(this).val().replace(/[^0-9]/g,"").length == 11){
            $('.order__phone-btn').removeClass('disabled');
        }else{
            $('.order__phone-btn').addClass('disabled');
        }
    });
    $(document).on('click', '.order__phone-btn', function(e){
        if(!$(this).hasClass('disabled')){
            $.getJSON('/local/ajax/check_phone.php',
                {
                    ACTION: 'SEND',
                    PHONE: $('.order__phone-input').val().replace(/[^0-9]/g,""),
                },
                function (data) {
                }
            );
        }
        e.preventDefault();
    });
    $(document).on('click', '.order-products__toggle', function(){
        $(this).toggleClass('open').closest('.order-item').find('.order-item__products-previews-cont, .order-item__products').stop().slideToggle();
    });

    $(document).on('click', '.order-item__cancel .order-tip-toggler', function(e){
        e.preventDefault();
        $(this).closest('.order-item__cancel').find('.order-cancel__tip').toggleClass('visible');
    });

    $(document).on('click', '.order-cancel__tip', function(e){
        e.preventDefault();
        $(this).closest('.order-cancel__tip').toggleClass('visible');
    });

    $(document).on('click', '.order-cancel__success .close', function(e){
        e.preventDefault();
        $(this).closest('.order-cancel__success').toggleClass('visible');
    });

    /* header-contacts */
    $(document).on('click', '.header-contacts-open', function () {
        $('.header-contacts').toggleClass('active');
        return false;
    });
    $(document).on('click', function (event) {
        if ($(event.target).closest('.header-contacts').length) return;
        $('.header-contacts').removeClass('active');
    });
    /* header-nav */

    $(document).on('click', '.header-nav-open', function (event) {
        $('html').addClass('header-nav-opened header-nav-is-open');
        return false;
    });
    $(document).on('click', '.header-nav-close', function (event) {
        closeHeaderNav();
        return false;
    });
    $(document).on('click', function (event) {
        if ($(event.target).closest('.header-nav-open, .header-nav').length) return;
        closeHeaderNav();
    });

    function closeHeaderNav() {
        if (!$('html').hasClass('header-nav-is-open')) return;
        $('html').removeClass('header-nav-is-open');
        setTimeout(function () {
            $('html').removeClass('header-nav-opened');
        }, 400);
    }

    /* header-catalog */


    $(document).on('click', '.header-catalog-open', function () {
        $(this).toggleClass('active');
        $('.header-catalog-menu-level-1').slideToggle(400);
        return false;
    });

    function positionMenuMarker(li) {
        var span = li.children('a').children('span');
        var width = span.innerWidth();
        // var position = li.position().left + ((li.innerWidth() - width) / 2);
        var position = li.position().left + 30;

        console.log(width);
        console.log(li.innerWidth());
        console.log(li.position());
        console.log(li.position().left);
        // var position = li.position().left + 30;
        $('.header-catalog-menu-marker').css({
            transform: 'translateX(' + position + 'px)',
            width: width
        });
    }

    if($('.header-catalog-menu-level-1>li.current-menu-item').length > 0){
        positionMenuMarker($('.header-catalog-menu-level-1>li.current-menu-item'));
    }
    $(document).on('mouseenter', '.header-catalog-menu-level-1>li', function () {
        positionMenuMarker($(this));
    });
    $(document).on('mouseleave', '.header-catalog-menu-level-1>li', function () {
        if($('.header-catalog-menu-level-1>li.current-menu-item').length > 0){
            positionMenuMarker($('.header-catalog-menu-level-1>li.current-menu-item'));
        }
    });
    $(document).on('click', '.header-nav-is-open .header-catalog-menu-level-1>.menu-item-has-children>a', function (event) {
        var li = $(this).closest('li');
        if (li.hasClass('current')) return false;

        if (li.hasClass('active')) {
            li.find('.header-catalog-menu-level-2 .menu-item-has-children').removeClass('active current').slideDown(400);
            li.find('.header-catalog-menu-level-2 .menu-item-has-children .header-catalog-menu-view-all').slideUp(400);
            li.find('.header-catalog-menu-level-2').children('.header-catalog-menu-view-all').slideDown(400);
            li.find('.header-catalog-menu-level-2 ul').slideUp(400);
            li.removeClass('active').addClass('current');
        } else {
            if (li.children('ul').find('.header-catalog-sub-menu-list').length) {
                li.addClass('active');
            } else {
                li.addClass('current');
            }

            li.parent().children('li:not(.header-catalog-menu-view-all)').not(li).slideUp(400);
            li.parent().children('.header-catalog-menu-view-all').slideDown(400);
            li.find('.header-catalog-menu-level-2').children('.header-catalog-menu-view-all').show(0);
            li.children('.header-catalog-sub-menu').slideDown(400);
        }

        return false;
    });
    $(document).on('click', '.header-nav-is-open .header-catalog-sub-menu-list>.menu-item-has-children>a', function (event) {
        var li = $(this).closest('li');
        if (li.hasClass('current')) return false;

        if (li.hasClass('active')) {
            li.children('ul').find('.menu-item-has-children').removeClass('active current').slideDown(400);
            li.children('ul').find('.menu-item-has-children .header-catalog-menu-view-all').slideUp(400);
            li.children('ul').children('.header-catalog-menu-view-all').slideDown(400);
            li.children('ul').find('ul').slideUp(400);
            li.removeClass('active').addClass('current');
        } else {
            if (li.children('ul').find('.header-catalog-sub-menu-list').length) {
                li.addClass('active');
            } else {
                li.addClass('current');
                li.closest('ul').closest('li').removeClass('current').addClass('active');
            }

            li.parent().children('li').not(li).slideUp(400);
            li.children('ul').children('.header-catalog-menu-view-all').show(0);
            li.children('ul').slideDown(400);
        }

        return false;
    });
    $(document).on('click', '.header-catalog-menu-close-sub-menu>a', function () {
        $('.header-catalog-menu-level-1 .menu-item-has-children').removeClass('active current').slideDown(400);
        $('.header-catalog-menu-level-1 .header-catalog-menu-view-all').slideUp(400);
        $('.header-catalog-sub-menu').slideUp(400);
        $('.header-catalog-menu-level-2 ul').slideUp(400);
        return false;
    });
    /* header-nav-mobile-about-toggle */

    $(document).on('click', '.header-nav-mobile-about-toggle', function () {
        $(this).toggleClass('active');
        $('.header-nav-mobile-about-menu').slideToggle(400);
        return false;
    });
    /* sliders */

    $('.promo-slider').each(function (index) {
        var t = $(this);
        var slider = new Swiper(this, {
            speed: 600,
            loop: true,
            watchSlidesVisibility: true,
            navigation: {
                nextEl: t.find('.slider-arrow-next')[0],
                prevEl: t.find('.slider-arrow-prev')[0]
            },
            pagination: {
                el: t.closest('.promo-slider-section').find('.slider-dots')[0],
                type: 'bullets',
                clickable: true
            }
        });
    });
    $('.category-section-products-slider, .youtube-slider').each(function (index) {
        var t = $(this);
        var slider = new Swiper(this, {
            speed: 600,
            watchSlidesVisibility: true,
            navigation: {
                nextEl: t.find('.slider-arrow-next')[0],
                prevEl: t.find('.slider-arrow-prev')[0]
            },
            breakpoints: {
                0: {
                    slidesPerView: 2,
                    spaceBetween: 6
                },
                480: {
                    slidesPerView: 3,
                    spaceBetween: 6
                },
                1024: {
                    slidesPerView: 2,
                    spaceBetween: 10
                },
                1200: {
                    slidesPerView: 3,
                    spaceBetween: 10
                },
                1440: {
                    slidesPerView: 3,
                    spaceBetween: 30
                }
            }
        });
    });
    $('.brands-slider').each(function (index) {
        var t = $(this);
        var slider = new Swiper(this, {
            speed: 400,
            watchSlidesVisibility: true,
            loop: true,
            autoplay: {
                delay: 4000
            },
            navigation: {
                nextEl: t.closest('.brands-section').find('.slider-arrow-next')[0],
                prevEl: t.closest('.brands-section').find('.slider-arrow-prev')[0]
            },
            breakpoints: {
                0: {
                    slidesPerView: 'auto',
                    spaceBetween: 6
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 8
                },
                1200: {
                    slidesPerView: 6,
                    spaceBetween: 8
                },
                1440: {
                    slidesPerView: 8,
                    spaceBetween: 26
                }
            }
        });
    });
    var navSlider;
    var mainSlider;
    var globImages;
    var globImagesMain;
    $('.product-gallery-slider').each(function () {
        globImages = $('.product-gallery-nav-slide').find("img");
        var t = $(this);
        globImagesMain=$('.product-gallery-slider').find("a");
        navSlider = new Swiper(t.closest('.product-gallery').find('.product-gallery-nav-slider')[0], {
            speed: 400,
            slideToClickedSlide: true,
            slidesPerView: 5,
            spaceBetween: 5,
            watchSlidesVisibility: true,
            watchSlidesProgress: true,
            direction: 'vertical'
        });
        mainSlider = new Swiper(this, {
            speed: 400,
            watchSlidesVisibility: true,
            thumbs: {
                swiper: navSlider
            },
            navigation: {
                nextEl: t.closest('.product-gallery').find('.slider-arrow-next')[0],
                prevEl: t.closest('.product-gallery').find('.slider-arrow-prev')[0]
            },
            on: {
                slideChange: function slideChange() {
                    var realIndex = this.realIndex;
                    var activeSlide = t.closest('.product-gallery').find('.product-gallery-nav-slider .swiper-slide').eq(realIndex);
                    var nextSlide = activeSlide.next();
                    var prevSlide = activeSlide.prev();

                    if (nextSlide.length && !nextSlide.hasClass('swiper-slide-visible')) {
                        this.thumbs.swiper.slideNext();
                    } else if (prevSlide.length && !prevSlide.hasClass('swiper-slide-visible')) {
                        this.thumbs.swiper.slidePrev();
                    }
                }
            }
        });
    });
    $('.products-slider').each(function (index) {
        var t = $(this);
        var slider = new Swiper(this, {
            speed: 400,
            watchSlidesVisibility: true,
            navigation: {
                nextEl: t.find('.slider-arrow-next')[0],
                prevEl: t.find('.slider-arrow-prev')[0]
            },
            breakpoints: {
                0: {
                    slidesPerView: 2,
                    spaceBetween: 6
                },
                480: {
                    slidesPerView: 3,
                    spaceBetween: 6
                },
                768: {
                    slidesPerView: 4,
                    spaceBetween: 6
                },
                1200: {
                    slidesPerView: 5,
                    spaceBetween: 10
                },
                1440: {
                    slidesPerView: 5,
                    spaceBetween: 28
                }
            }
        });
    });
    $('.product-review-imgs-slider').each(function (index) {
        var t = $(this);
        var slider = new Swiper(this, {
            speed: 400,
            watchSlidesVisibility: true,
            navigation: {
                nextEl: t.closest('.product-review-imgs').find('.slider-arrow-next')[0],
                prevEl: t.closest('.product-review-imgs').find('.slider-arrow-prev')[0]
            },
            breakpoints: {
                0: {
                    slidesPerView: 3,
                    spaceBetween: 12
                },
                768: {
                    slidesPerView: 5,
                    spaceBetween: 30
                },
                1440: {
                    slidesPerView: 5,
                    spaceBetween: 50
                }
            }
        });
    });
    $('.contacts-shop-slider').each(function () {
        var slider;
        var t = $(this);
        initSlider();
        $(window).on('resize', initSlider);

        function initSlider() {
            if ($(window).width() < 1024) {
                if (!slider) {
                    var shopFancy = t.find('.contacts-shop-img:last').data('fancybox');
                    t.find('.contacts-shop-img:first').attr('data-fancybox', shopFancy);
                    t.closest('.contacts-shop').find('.hidden-tablet .contacts-shop-img').removeAttr('data-fancybox');
                    slider = new Swiper(t[0], {
                        speed: 400,
                        loop: false,
                        slidesPerView: 'auto',
                        spaceBetween: 32,
                        watchSlidesVisibility: true,
                        navigation: {
                            nextEl: t.find('.slider-arrow-next')[0],
                            prevEl: t.find('.slider-arrow-prev')[0]
                        },
                        breakpoints: {
                            0: {
                                slidesPerView: 1,
                                spaceBetween: 0
                            },
                            480: {
                                slidesPerView: 2,
                                spaceBetween: 8
                            },
                            768: {
                                slidesPerView: 2,
                                spaceBetween: 20
                            }
                        }
                    });
                }
            } else {
                if (slider) {
                    t.find('.visible-tablet .contacts-shop-img').removeAttr('data-fancybox');
                    slider.destroy(true, true);
                    slider = null;
                }
            }
        }
    });
    $('.articles-slider').each(function (index) {
        var t = $(this);
        var slider = new Swiper(this, {
            speed: 400,
            watchSlidesVisibility: true,
            navigation: {
                nextEl: t.find('.slider-arrow-next')[0],
                prevEl: t.find('.slider-arrow-prev')[0]
            },
            breakpoints: {
                0: {
                    slidesPerView: 1,
                    spaceBetween: 6
                },
                480: {
                    slidesPerView: 2,
                    spaceBetween: 6
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 6
                },
                1200: {
                    slidesPerView: 4,
                    spaceBetween: 10
                },
                1440: {
                    slidesPerView: 4,
                    spaceBetween: 28
                }
            }
        });
    });
    /* product-item-favorites lk */

    $(document).on('click', '.cabinet.cabinet-products .add-to-favorites-btn', function () {
        elementHelpers.removeFromFavorite($(this).data('product'));
    });
    $(document).on('click', '.js-add-favorites', function () {
        // elementHelpers.clickFavorite($(this).data('product'));
        clickFavorite($(this).data('product'));
    });
    /* add-to-cart-btn */

    $(document).on('click', '.product-item-btn, .product-btn', function () {
        var t = $(this);

        if (t.data('text') && t.data('text-active')) {
            if (t.hasClass('active')) {
                t.text(t.data('text'));
            } else {
                t.text(t.data('text-active'));
            }
        }

        t.toggleClass('active');
        return false;
    });
    /* tabs */

    $(document).on('click', '.tabs-nav a', function (event) {
        var t = $(this);
        var li = t.parent();
        var tab = t.attr('href');
        var tabs = t.closest('.tabs-nav').data('tabs');
        if (li.hasClass('active')) return false;
        t.closest('.tabs-nav').find('li').removeClass('active');
        $(tabs).find('.tab-block').removeClass('active');
        li.addClass('active');
        $(tab).addClass('active');
        return false;
    });
    /* modal */

    var isOpenModal = false;
    $(document).on('click', '.modal-open-btn', function () {
        var t = $(this);
        var modal = t.data('modal') || t.attr('href');
        openModal(modal);
        return false;
    });
    $(document).on('click', '.modal-close-btn, .modal-close-link', function () {
        closeModal();
        return false;
    });

    function closeModal() {
        $.fancybox.close(true);
    }

    function openModal(modal) {
        var timeout = 0;
        if ($('html').hasClass('fancybox-is-open')) isOpenModal = true;
        if (isOpenModal) timeout = 399;
        closeModal();
        setTimeout(function () {
            $.fancybox.open({
                src: modal,
                type: 'inline',
                opts: getFancyboxModalOpts(modal)
            });
            setTimeout(function () {
                isOpenModal = false;
            }, 400);
        }, timeout);
    }

    function getScrollbarWidth() {
        var div = $('<div style="width:50px;height:50px;overflow:hidden;position:absolute;top:-200px;left:-200px;"><div style="height:100px;"></div></div>');
        $('body').append(div);
        var w1 = $('div', div).innerWidth();
        div.css('overflow-y', 'scroll');
        var w2 = $('div', div).innerWidth();
        $(div).remove();
        return w1 - w2;
    }

    function getFancyboxModalOpts(modal) {
        var scrollbarWidth = getScrollbarWidth();
        return {
            smallBtn: false,
            toolbar: false,
            touch: false,
            animationDuration: 400,
            beforeLoad: function beforeLoad() {
                if (!$('html').hasClass('fancybox-is-open')) {
                    $('html').addClass('fancybox-is-open').css({
                        marginRight: scrollbarWidth
                    });
                }
            },
            afterLoad: function afterLoad() {
                setTimeout(function () {
                    $(modal).addClass('active');
                }, 0);
            },
            beforeClose: function beforeClose() {
                $(modal).addClass('close');
                setTimeout(function () {
                    $(modal).removeClass('active close');
                }, 400);
            },
            afterClose: function afterClose() {
                if (isOpenModal) return;
                $('html').removeClass('fancybox-is-open').css({
                    marginRight: 0
                });
            }
        };
    }

    /* password-input-type-toggle */


    $(document).on('click', '.password-input-type-toggle', function () {
        var t = $(this);
        var input = t.closest('.form-block').find('.input');

        if (t.hasClass('active')) {
            input.attr('type', 'password');
        } else {
            input.attr('type', 'text');
        }

        t.toggleClass('active');
        return false;
    });
    /* checkbox */

    $(document).on('change', '.checkbox-input', function () {
        var t = $(this);

        if (t.prop('checked')) {
            t.closest('label').addClass('active');
        } else {
            t.closest('label').removeClass('active');
        }
    });
    /* catalog-sort-link */

    // $(document).on('click', '.catalog-sort-link', function () {
    //     $(this).toggleClass('active');
    //     return false;
    // });
    /* range slider */

  /*  $('.range-slider').each(function () {
        var slider = $(this);
        var wrapp = slider.closest('.range-slider-wrapp');
        var inputFrom = wrapp.find('.range-input-from');
        var inputTo = wrapp.find('.range-input-to');
        var min = slider.data('min');
        var max = slider.data('max');
        var valueFrom = slider.data('value-from');
        var valueTo = slider.data('value-to');
        var step = slider.data('step') || 1;
        slider.slider({
            min: min,
            max: max,
            values: [valueFrom, valueTo],
            range: true,
            step: step,
            slide: function slide(event, ui) {
                inputFrom.val(replacePriceValue(ui.values[0]));
                inputTo.val(replacePriceValue(ui.values[1]));
            }
        });
        var value;
        inputFrom.on('blur', function () {
            var t = $(this);
            var val = parseInt(t.val().replace(' ', ''));
            var valueInputTo = parseInt(inputTo.val().replace(' ', '')) || valueTo;

            if (!val) {
                t.val(value);
                return;
            }

            if (val < min || val > valueInputTo) {
                t.val(min);
            }

            slider.slider('values', [t.val(), valueInputTo]);
            t.val(replacePriceValue(t.val()));
        });
        inputTo.on('blur', function () {
            var t = $(this);
            var val = parseInt(t.val().replace(' ', ''));
            var valueInputFrom = parseInt(inputFrom.val().replace(' ', '')) || valueFrom;

            if (!val) {
                t.val(value);
                return;
            }

            if (val > max || val < valueInputFrom) {
                t.val(max);
            }

            slider.slider('values', [valueInputFrom, t.val()]);
            t.val(replacePriceValue(t.val()));
        });
        $('.range-input').on({
            focus: function focus() {
                value = $(this).val();
                $(this).val('');
            },
            keypress: function keypress(event) {
                var key, keyChar;
                if (event.keyCode) key = event.keyCode; else if (event.which) key = event.which;

                if (key == 13) {
                    $(this).trigger('blur');
                    return false;
                }

                if (key == null || key == 0 || key == 8 || key == 9 || key == 39 || key == 48) return true;
                keyChar = String.fromCharCode(key);
                if (!/[1-9]/.test(keyChar)) return false;
            }
        });
    });

    function replacePriceValue(str) {
        str = str.toString().replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');
        return str.replace('.', ',');
    }
*/
    /* catalog-filter-menu-more-toggle */


    $(document).on('click', '.catalog-filter-menu-more-toggle', function () {
        var t = $(this);

        if (t.hasClass('active')) {
            t.text(t.data('text'));
        } else {
            t.text(t.data('text-active'));
        }

        t.toggleClass('active');
        t.closest('.catalog-filter-section').find('.catalog-filter-menu-more').slideToggle(400);
        return false;
    });
    /* catalog-filter */

    $(document).on('click', '.catalog-filter-open', function (event) {
        $('html').addClass('catalog-filter-opened catalog-filter-is-open');
        return false;
    });
    $(document).on('click', '.catalog-filter-close', function (event) {
        closeCatalogFilter();
        return false;
    });
    $(document).on('click', function (event) {
        if ($(event.target).closest('.catalog-filter-open, .catalog-filter').length) return;
        closeCatalogFilter();
    });

    function closeCatalogFilter() {
        if (!$('html').hasClass('catalog-filter-is-open')) return;
        $('html').removeClass('catalog-filter-is-open');
        setTimeout(function () {
            $('html').removeClass('catalog-filter-opened');
        }, 400);
    }

    /* catalog-view-more-btn */


    $(document).on('click', '.catalog-view-more-btn', function () {
        $(this).closest('.read-more-btn-wrapp').fadeOut(400);
        $('.catalog-row').addClass('active');
        return false;
    });
    /* catalog-nav-open */

    $(document).on('click', '.catalog-nav-open', function () {
        if (!$('.catalog-menu-mobile').length) return;
        var t = $(this);

        if (t.hasClass('active')) {
            closeCatalogNav();
        } else {
            t.addClass('active');
            $('.catalog-nav').addClass('active');
        }
    });
    $(document).on('click', function (event) {
        if ($(event.target).closest('.catalog-nav').length) return;
        closeCatalogNav();
    });

    function closeCatalogNav() {
        $('.catalog-nav-open').removeClass('active');
        $('.catalog-nav').removeClass('active');
    }

    /* modal-adult */
    // localStorage.clear();


    if ($('.modal-adult').length && !localStorage.getItem('is-adult')) {
        openModal('#modal-adult');
    }

    $(document).on('click', '.modal-adult-ok', function () {
        localStorage.setItem('is-adult', true);
        $('body').removeClass('is-not-adult', true);
        return false;
    });

    function initSizeColor()
    {
        let size = document.querySelector(".product-size-list a");
        if (size !== null) size.click();
        let color = document.querySelector(".product-color-list a");
        if (color !== null) color.click();
    }

    function filterSwiper()
    {
        let product_body = $('.product-body');
        var colorName = product_body.find('.product-color-list .active a').data('name');
        var size = product_body.find('.product-size-list .active a').data('name');
        mainSlider.removeAllSlides();
        navSlider.removeAllSlides();
        globImages.each(function(index){
            let fileName = globImages[index].getAttribute('data-desc');
            if(fileName==null)
                return true;
            let delimiter = fileName.lastIndexOf("__");
            if(delimiter===-1)
                return true;
            let tmp=fileName.substring(delimiter);

            let retColor = tmp.lastIndexOf(colorName);
            let retSize = tmp.lastIndexOf(size);
            if(retColor!==-1 && (retSize!==-1 || size===undefined))
            {
                let wrp=$('<div class="product-gallery-nav-slide swiper-slide"></div>').append($('<span></span>'));
                $(globImages[index]).appendTo(wrp.find('span'));
                navSlider.appendSlide(wrp);
                let wrp2 = $('<div class="product-gallery-slide swiper-slide"></div>').append(globImagesMain[index]);
                mainSlider.appendSlide(wrp2);
                return true;
            }
        });
        if(mainSlider.slides.length===0)
        {
            let wrp=$('<div class="product-gallery-nav-slide swiper-slide"></div>').append($('<span></span>'));
            let no_photo1 = $('<img alt="no-photo" class="image-main-element"' +
                ' src="/local/templates/main/assets/img/no-photo.svg">');
            let no_photo2 = $('<img alt="no-photo" class="product-img no-photo"' +
                ' src="/local/templates/main/assets/img/no-photo.svg">');
            no_photo1.appendTo(wrp.find('span'))
            navSlider.appendSlide(wrp);
            let wrp2 = $('<div class="product-gallery-slide swiper-slide"></div>').append(no_photo2);
            mainSlider.appendSlide(wrp2);
        }
    }

    /* product-size-list */
    $(document).on('click', '.product-size-list li', function () {
        let t=$(this).find("a");
        t.closest('.product-size-list').find('li').removeClass('active');
        t.parent().addClass('active');
        filterSwiper();
        return false;
    });

    /* product-color-list */
    $(document).on('click', '.product-color-list li', function () {
        var t = $(this).find("a");
        var color = t.data('color');
        t.closest('.product-color-list').find('li').removeClass('active');
        t.parent().addClass('active');
        t.closest('.product-color').find('.product-color-selected').text(color);
        filterSwiper();
        return false;
    })
    /* select-number */
    ;
    initSizeColor();
    (function () {
        /*$(document).on('click', '.select-number-btn', function (event) {
            event.preventDefault();
            var t = $(this);
            var wrapp = t.closest('.select-number');
            var input = wrapp.find('.select-number-input');
            var val = input.val();
            var min = input.data('min') || 0;
            var max = input.data('max') || Infinity;
            var step = input.data('step') || 1;
            var desc = input.data('desc') || '';
            val = val.replace(desc, '');
            val = +val;

            if (t.hasClass('select-number-btn-minus')) {
                wrapp.find('.select-number-btn-plus').removeClass('disabled');
                if (val - step == min) t.addClass('disabled');
                if (val == min) return;
                input.val(val - step + desc).trigger('input');
            } else {
                wrapp.find('.select-number-btn-minus').removeClass('disabled');
                if (val + step == max) t.addClass('disabled');
                if (val == max) return;
                input.val(val + step + desc).trigger('input');
            }
        });*/
        var value;
        $(document).on('focus', '.select-number-input', function () {
            value = $(this).val();
            $(this).val('');
        });
        $(document).on('blur', '.select-number-input', function () {
            var t = $(this);
            var wrapp = t.closest('.select-number');
            var val = t.val();
            var min = t.data('min') || 0;
            var max = t.data('max') || Infinity;
            var desc = t.data('desc') || '';
            val = val.replace(desc, '');
            val = +val;

            if (!val) {
                t.val(value);
                return;
            }

            if (val <= min) {
                t.val(min + desc);
                wrapp.find('.select-number-btn-minus').addClass('disabled');
                wrapp.find('.select-number-btn-plus').removeClass('disabled');
                return;
            }

            if (val >= max) {
                t.val(max + desc);
                wrapp.find('.select-number-btn-plus').addClass('disabled');
                wrapp.find('.select-number-btn-minus').removeClass('disabled');
                return;
            }

            wrapp.find('.select-number-btn').removeClass('disabled');
            t.val(val + desc);
        });
        $(document).on('keypress', '.select-number-input', function (event) {
            var key, keyChar;
            if (event.keyCode) key = event.keyCode; else if (event.which) key = event.which;

            if (key == 13) {
                $(this).trigger('blur').trigger('input');
                return false;
            }

            if (key == null || key == 0 || key == 8 || key == 9 || key == 39) return true;
            keyChar = String.fromCharCode(key);
            if (!/[0-9]/.test(keyChar)) return false;
        });
    })();
    /* toggle-mobile-link */


    $(document).on('click', '.toggle-mobile-link', function () {
        var t = $(this);

        if (t.hasClass('active')) {
            t.find('span').text(t.data('text'));
        } else {
            t.find('span').text(t.data('text-active'));
        }

        t.toggleClass('active');
        t.closest('.toggle-mobile-wrapp').find('.toggle-mobile-block').toggleClass('active');
        return false;
    });
    /* product-expected-btn-add */

    $(document).on('click', '.product-expected-btn-add', function () {
        var t = $(this);
        var state = $('.product-state-expected');

        if (t.hasClass('active')) {
            t.text(t.data('text'));
            state.text(state.data('text'));
        } else {
            t.text(t.data('text-active'));
            state.text(state.data('text-active'));
            openModal('#modal-expected-add');
        }

        t.toggleClass('active');
        return false;
    });
    /* fancybox */

    $('[data-fancybox]').fancybox(getFancyboxOptions());

    function getFancyboxOptions() {
        return {
            hash: false,
            buttons: ['thumbs', 'close'],
            btnTpl: {
                arrowLeft: "<button data-fancybox-prev class=\"fancybox-button fancybox-button--arrow_left\">\n\t\t\t\t\t<svg width=\"24\" height=\"24\"><use xlink:href=\"#icon-arrow-down\"/></svg>\n\t\t\t\t</button>",
                arrowRight: "<button data-fancybox-next class=\"fancybox-button fancybox-button--arrow_right\">\n\t\t\t\t\t<svg width=\"24\" height=\"24\"><use xlink:href=\"#icon-arrow-down\"/></svg>\n\t\t\t\t</button>",
                thumbs: "<button data-fancybox-thumbs class=\"fancybox-button fancybox-button--thumbs\" >\n\t\t\t\t\t<svg width=\"24\" height=\"24\"><use xlink:href=\"#icon-grid\"/></svg>\n\t\t\t\t</button>",
                close: "<button data-fancybox-close class=\"fancybox-button fancybox-button--close\">\n\t\t\t\t\t<svg width=\"24\" height=\"24\"><use xlink:href=\"#icon-close\"/></svg>\n\t\t\t\t</button>"
            },
            transitionEffect: 'slide',
            transitionDuration: 600,
            parentEl: 'html',
            iframe: {
                tpl: '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" allowfullscreen allow="autoplay; fullscreen" src=""></iframe>',
                preload: false
            },
            onUpdate: function onUpdate(instance, current) {
                if (current.type !== 'iframe') return;
                set16x9(current);
            }
        };
    }

    function set16x9(current) {
        var ratio = 16 / 9;
        var video = current.$content;

        if (video) {
            video.hide();
            var width = current.$slide.width();
            var height = current.$slide.height() - 50;

            if (height * ratio > width) {
                height = width / ratio;
            } else {
                width = height * ratio;
            }

            video.css({
                width: width,
                height: height
            }).show();
        }
    }

    /* rating-select */


    $('.rating-select').each(function () {
        var t = $(this);
        var input = t.find('.rating-select-input');
        t.on('mousemove', function (event) {
            var x = event.clientX;
            var position = x - t.offset().left;
            var starWidth = t.width() / 5;

            if (position <= starWidth) {
                setRating(1);
            }

            if (position <= starWidth * 2 && position > starWidth) {
                setRating(2);
            }

            if (position <= starWidth * 3 && position > starWidth * 2) {
                setRating(3);
            }

            if (position <= starWidth * 4 && position > starWidth * 3) {
                setRating(4);
            }

            if (position > starWidth * 4) {product-color-list
                setRating(5);
            }
        });
        t.on('click', function () {
            t.toggleClass('active');
        });
        t.on('mouseout', function () {
            if (!t.hasClass('active')) {
                setRating(0);
            }
        });

        function setRating(star) {
            var starWidth = t.width() / 5;
            t.find('.rating-state').width(starWidth * star);

            if (star) {
                input.val(star);
            } else {
                input.val('');
            }
        }
    });
    /* product-review-form */

    $(document).on('click', '.product-review-add-btn', function () {
        var t = $(this);

        if (t.hasClass('active')) {
            t.text(t.data('text'));
        } else {
            t.text(t.data('text-active'));
        }

        t.toggleClass('active');
        t.closest('.product-tab-section').find('.product-review-form').fadeToggle(400);
        return false;
    });
    $(document).on('click', '.product-review-form-close', function () {
        $(this).closest('.product-tab-section').find('.product-review-add-btn').trigger('click');
        return false;
    });
    $(document).on('keyup input', '.product-review-form-input', function () {
        var t = $(this);
        var maxlength = Number(t.attr('maxlength'));
        var value = t.val();
        var length = value.length;

        if (length > maxlength) {
            value = value.slice(0, maxlength);
        }

        t.val(value);
        t.closest('.form-block').find('.product-review-form-input-letters').text(value.length);
    });
    $(document).on('change', '.product-review-form-img input', function () {
        var t = $(this);
        var files = t[0].files;
        var label = t.closest('.product-review-form-img');

        if (!files) {
            label.find('img').remove();
            label.removeClass('active');
            return;
        }

        var file = files[0];
        var reader = new FileReader();
        reader.readAsDataURL(file);

        reader.onloadend = function () {
            label.addClass('active');
            var img = "<img src=\"".concat(reader.result, "\" alt=\"\">");
            label.find('span').html(img);
        };
    });
    /* contacts-shop-schema-print */

    $(document).on('click', '.contacts-shop-schema-print', function () {
        var src = $(this).closest('.contacts-shop-col').find('.contacts-shop-img').attr('href');
        var popup;
        popup = window.open(src);
        popup.onbeforeunload = closePrint;
        popup.onafterprint = closePrint;
        popup.focus();
        popup.print();

        function closePrint() {
            if (popup) popup.close();
        }

        return false;
    });
    /* contacts-map */

    if ($('.contacts-map').length) {
        $.getScript('https://api-maps.yandex.ru/2.1/?lang=ru_RU', initMap);
    }

    function initMap() {
        ymaps.ready(function () {
            var canvas = $('.contacts-map');
            var lat = canvas.data('lat');
            var lng = canvas.data('lng');
            var zoom = $(window).width() < 480 ? canvas.data('zoom-mobile') : canvas.data('zoom');
            var myMap = new ymaps.Map(canvas[0], {
                center: [lat, lng],
                zoom: zoom,
                controls: ['zoomControl']
            }, {
                searchControlProvider: 'yandex#search'
            });
            myMap.behaviors.disable('scrollZoom');
            $('.contacts-shop').each(function () {
                var t = $(this);
                var lat = t.data('lat');
                var lng = t.data('lng');
                var balloonContent = t.find('.contacts-shop-address').html();
                var myPlacemark = new ymaps.Placemark([lat, lng], {
                    balloonContent: balloonContent
                }, {
                    preset: 'islands#redDotIcon'
                });
                myMap.geoObjects.add(myPlacemark);
            });
        });
    }

    /* faq */


    $(document).on('click', '.faq-item-toggle', function () {
        var t = $(this);

        if (t.hasClass('active')) {
            close();
        } else {
            close();
            t.addClass('active');
            t.closest('.faq-item').find('.faq-item-body').slideDown(400);
        }

        function close() {
            var faq = t.closest('.faq');
            faq.find('.faq-item-toggle').removeClass('active');
            faq.find('.faq-item-body').slideUp(400);
        }

        return false;
    });
    /* cart */

    $(document).on('change', '.cart-select-all .checkbox-input', function () {
        if ($(this).prop('checked')) {
            $('.cart-item-checkbox .checkbox-input').prop('checked', true).trigger('change');
        } else {
            $('.cart-item-checkbox .checkbox-input').prop('checked', false).trigger('change');
        }
    });
    $(document).on('input', '.cart-item .select-number-input', function () {
        var t = $(this);
        var unit = t.closest('.cart-item').find('.cart-item-number-unit');

        if (Number(t.val() > 1)) {
            unit.addClass('active');
        } else {
            unit.removeClass('active');
        }
    });
    /* ordering-form */

    $(document).on('input change', '.ordering-form [required]', function () {
        var form = $(this).closest('.ordering-form');
        var validForm = true;
        form.find('[required]').each(function () {
            var t = $(this);

            if (t.attr('type') === 'checkbox') {
                if (!t.prop('checked')) {
                    validForm = false;
                    return false;
                }
            } else if (t.attr('type') === 'radio') {
                var radioChecked = false;
                $('[name="' + t.attr('name') + '"]').each(function () {
                    if ($(this).prop('checked')) {
                        radioChecked = true;
                        return false;
                    }
                });
                if (!radioChecked) validForm = false;
            } else {
                if (!t.val()) {
                    validForm = false;
                    return false;
                }
            }
        });

        if (validForm) {
            form.find('.submit').removeAttr('disabled');
        } else {
            form.find('.submit').attr('disabled', true);
        }
    });
    /* ordering-section-title-toggle */

    $(document).on('click', '.ordering-section-title-toggle', function () {
        $(this).toggleClass('active').closest('.ordering-section').find('.ordering-section-body').slideToggle(400);
    });
    /* radio */

    $(document).on('change', '.radio-input', function () {
        var t = $(this);
        var name = t.attr('name');
        $("[name=\"".concat(name, "\"]")).closest('label').removeClass('active');

        if (t.prop('checked')) {
            t.closest('label').addClass('active');
        } else {
            t.closest('label').removeClass('active');
        }
    });
    /* ordering-delivery-city-select */

    $(document).on('click', '.ordering-delivery-city-select-input', function () {
        var t = $(this);
        var wrapp = t.closest('.ordering-delivery-city-select');
        t.trigger('blur');

        if (wrapp.hasClass('active')) {
            wrapp.removeClass('active');
        } else {
            wrapp.addClass('active');
            setTimeout(function () {
                return wrapp.find('.ordering-delivery-city-select-search-input').trigger('focus');
            }, 100);
        }
    });
    $(document).on('click', function (event) {
        if ($(event.target).closest('.ordering-delivery-city-select').length) return;
        $('.ordering-delivery-city-select').removeClass('active');
    });
    /* modal-thanks */

    if ($('#modal-thanks').length) {
        openModal('#modal-thanks');
    }
    /* cabinet-menu */


    $(document).on('click', '.cabinet-menu .current-menu-item a', function () {
        $(this).closest('.cabinet-menu-wrapp').toggleClass('active');
        return false;
    });
    $(document).on('click', function (event) {
        if ($(event.target).closest('.cabinet-menu-wrapp').length) return;
        $('.cabinet-menu-wrapp').removeClass('active');
    });
    /* cabinet-profile-form */

    $(document).on('input', '.cabinet-profile-form input', function () {
        $(this).closest('.cabinet-profile-form').find('.submit').removeAttr('disabled');
    });
    /* cabinet-profile-del-btn */

    // $(document).on('click', '.cabinet-profile-del-btn', function () {
    //     $(this).addClass('active');
    // });
    /* cabinet-address */

    $(document).on('click', '.cabinet-address-add-btn', function () {
        $('.cabinet-address-add, .cabinet-address-new').slideToggle(400);
        return false;
    });
    $(document).on('click', '.cabinet-address-new .cabinet-address-form-del', function () {
        $('.cabinet-address-add, .cabinet-address-new').slideToggle(400);
        return false;
    });

    $(document).on('submit', '.cabinet-address-form', function (event) {
        var t = $(this);
        var code = $('.cabinet-address-input-city option:selected').attr('value');
        var index = $('.cabinet-address-input-city option:selected').attr('ind');
        var street = $('#my_street option:selected').attr('value');
        var street2 = $('.jsStreet2').val();


        var title = t.find('.cabinet-address-input-title').val();
        var city =  t.find('.cabinet-address-input-city').val();
        var region =$('.cabinet-address-input-city option:selected').attr('region');
        var comment = t.find('.cabinet-address-input-comment').val();
        var isMain = t.find('.cabinet-address-input-main').prop('checked');
        var data = city;
        var item;
        var arr = [];
        arr.push(code);
        arr.push(index);
        arr.push(region);
        arr.push(title);
        arr.push(city);
        arr.push(comment);
        arr.push(isMain);
        arr.push(street);
        arr.push(street2);

        t.find('.cabinet-address-input-data').each(function () {
            var value = $(this).val();
            if (!value) {arr.push(""); return;}
            var inputTitle = $(this).closest('.form-block').find('.form-block-title').text().toLowerCase();
            data += ", ".concat(inputTitle, " ").concat(value);
            arr.push(value);
        });
//alert(arr);
        $.ajax({
            url: '/ajax/input_ajax.php',
            method: 'post',
            dataType: 'html',
            data: {action: "new", arr: arr},
        });
/*
        if (t.closest('.cabinet-address-new').length) {
            var form = t.clone();
            item = $($('#cabinet-address-item').html());
            $('.cabinet-address-list').append(item);
            item.find('.cabinet-address-item-form').append(form);
            $('.cabinet-address-add, .cabinet-address-new').slideToggle(400);
            t.find('.input').val('');
            t.find('.cabinet-address-input-main').prop('checked', false);
            t.find('.cabinet-address-form-main-checkbox').removeClass('active');
            t.find('.cabinet-address-input-city').val(t.find('.cabinet-address-input-city').data('value-default'));
        } else {
            item = t.closest('.cabinet-address-item');
            item.find('.cabinet-address-item-form, .cabinet-address-item-body').slideToggle(400);
        }

        item.find('.cabinet-address-item-title').text(title);
        item.find('.cabinet-address-item-city').text(city);
        item.find('.cabinet-address-item-data').text(data);
        item.find('.cabinet-address-item-comment').text(comment);

        if (isMain) {
            $('.cabinet-address-input-main').prop('checked', false);
            $('.cabinet-address-form-main-checkbox').removeClass('active');
            item.find('.cabinet-address-input-main').prop('checked', true);
            item.find('.cabinet-address-form-main-checkbox').addClass('active');
        } else {
            item.find('.cabinet-address-input-main').prop('checked', false);
            item.find('.cabinet-address-form-main-checkbox').removeClass('active');
        }
        */
        location.reload();
        return false;
    });

    $(document).on('click', '.cabinet-address-item-edit', function () {
        var item = $(this).closest('.cabinet-address-item');
        item.find('.cabinet-address-item-form, .cabinet-address-item-body').slideToggle(400);
        return false;
    });
    $(document).on('click', '.cabinet-address-item .cabinet-address-form-del, .cabinet-address-item-del', function () {
        var item = $(this).closest('.cabinet-address-item');
        item.fadeOut(400, function () {
            return item.remove();
        });
        return false;
    });

    $(document).on('click', '.cabinet-address-item-delnew', function () {
        var t = $(this).closest('.personal-address__item');
        var id = t.find('.cabinet-address-input-id').val();
        $.ajax({
            url: '/ajax/input_ajax.php',
            method: 'post',
            dataType: 'html',
            data: {action: "del", arr: id },
        });
        location.reload();
        return false;
    });

    $(document).on('click', '.cabinet-address-item-editnew', function () {

        var t = $(this).closest('.personal-address__item');
        var code_city = t.find('.cabinet-address-code').val();
        var id = t.find('.cabinet-address-input-id').val();
        var typeadr = t.find('.cabinet-address-input-typeadr').val();
        var city = t.find('.cabinet-address-input-cityn').val();
        var street = t.find('.cabinet-address-input-street').val();
        var street_code = t.find('.cabinet-address-street_code').val();
        var home = t.find('.cabinet-address-input-home').val();
        var korpus = t.find('.cabinet-address-input-korpus').val();
        var stroenie = t.find('.cabinet-address-input-stroenie').val();
        var kvartira = t.find('.cabinet-address-input-kvartira').val();
        var coment = t.find('.cabinet-address-input-coment').val();
        var index = t.find('.cabinet-address-input-index').val();
        var floor = t.find('.cabinet-address-input-floor').val();

        $('#my_sity2').append('<option value="'+code_city+'" selected>'+city+'</option>');
        $("#my_street2").append('<option value="'+street_code+'" selected>'+street+'</option>');

        $("#idadr").val(id);
        $(".cabinet-address-street_code2").val(street_code);
        $("#nameadr").val(typeadr);
        // $("#city").val(city);
        // $("#street").val(street);
        $("#home").val(home);
        $("#korpus").val(korpus);
        $("#stroenie").val(stroenie);
        $("#kvartira").val(kvartira);
        $("#coment").val(coment);
        $("#index").val(index);
        $("#floor").val(floor);
        return false;
    });

    $(document).on('submit', '.cabinet-address-formedit', function (event) {
        var t = $(this);
        // var id = t.find('.cabinet-address-input-id').val();
        // var city = t.find('.cabinet-address-input-city').val();
        // var comment = t.find('.cabinet-address-input-comment').val();
        // var typeadr = t.find('.cabinet-address-input-title').val();
        // var street = t.find('.cabinet-address-input-street').val();
        // var home = t.find('.cabinet-address-input-home').val();
        // var korpus = t.find('.cabinet-address-input-korpus').val();
        // var stroenie = t.find('.cabinet-address-input-stroenie').val();
        // var kvartira = t.find('.cabinet-address-input-kvartira').val();
        //
        // var arr = [];
        // arr.push(typeadr);
        // arr.push(comment);
        // arr.push("false");
        // arr.push(kvartira);
        // arr.push(stroenie);
        // arr.push(street);
        // arr.push(korpus);
        // arr.push(home);
        // arr.push(city);
        // arr.push(id);

        var id = t.find('.cabinet-address-input-id').val();
        var code = t.find('.cabinet-address-input-city option:selected').attr('value');
        var index = t.find('.cabinet-address-index').val();
        // var street = t.find('.cabinet-address-street_code2').val();
        var street = t.find('.jsStreet3').val();
        if(street == 'other'){
            var street2 = t.find('.jsStreet2').val();
        }

        var stroenie = t.find('.cabinet-address-input-stroenie').val();
        var kvartira = t.find('.cabinet-address-input-kvartira').val();
        var korpus = t.find('.cabinet-address-input-korpus').val();
        var home = t.find('.cabinet-address-input-home').val();

        var title = t.find('.cabinet-address-input-title').val();
        var city =  t.find('.cabinet-address-input-city').val();
        var region = $('.cabinet-address-input-city option:selected').attr('region');
        var comment = t.find('.cabinet-address-input-comment').val();
        var floor = t.find('.cabinet-address-input-floor').val();
        var isMain = t.find('.cabinet-address-input-main').prop('checked');
        var data = city;
        var item;
        var arr = [];
        arr.push(code);
        arr.push(index);
        arr.push(region);
        arr.push(title);
        arr.push(city);
        arr.push(comment);
        arr.push(isMain);
        arr.push(street);
        // arr.push(street2);

        arr.push(stroenie);
        arr.push(kvartira);
        arr.push(korpus);
        arr.push(home);

        arr.push(id);
        arr.push(floor);
        arr.push(street2);

        //alert(id);
        $.ajax({
            url: '/ajax/input_ajax.php',
            method: 'post',
            dataType: 'html',
            data: {action: "edit", arr: arr},
        });
        location.reload();
        return false;
    });

    $(document).on('input', '.cabinet-address-item .cabinet-address-input-title', function () {
        var t = $(this);
        var item = t.closest('.cabinet-address-item');
        item.find('.cabinet-address-item-title').text(t.val());
        return false;
    });
    $(document).on('input', '.cabinet-address-item .cabinet-address-input-city', function () {
        var t = $(this);
        var item = t.closest('.cabinet-address-item');
        item.find('.cabinet-address-item-city').text(t.val());
        return false;
    });
    /* order-cart-link */

    $(document).on('click', '.order-cart-link', function () {
        $(this).closest('.order-cart').toggleClass('active').find('.order-cart-body').slideToggle(400);
        return false;
    });
    $(document).on('click', '.notification__icon', function () {
        $(this).closest('.notification-block').remove();
        return false;
    });
    /* form-ajax */

    $(document).on('submit', '.form-ajax', function (event) {
        event.preventDefault();
        var sentModal = $(this).data('modal-sent');
        var t = $(this);
        t.find('.submit').attr('disabled', true);
        t.ajaxSubmit({
            clearForm: true,
            success: function success(data) {
                closeModal();
                t.find('.submit').removeAttr('disabled');
                openModal(sentModal);
            }
        });
        return false;
    });
    /* cookie-submit */

    if (!localStorage.getItem('cookie-submit')) {
        $('.cookie').addClass('active');
    }

    $(document).on('click', '.cookie-submit', function () {
        $('.cookie').slideUp(400);
        localStorage.setItem('cookie-submit', 1);
        return false;
    });
    /* scroll-btn */

    $(window).on('load scroll resize', function () {
        if ($(this).scrollTop() > 0) {
            $('.scroll-btns').addClass('active');
        } else {
            $('.scroll-btns').removeClass('active');
        }
    });
    $(document).on('click', '.scroll-btn', function () {
        var t = $(this);

        if (t.data('scroll') === 'top') {
            scrollToBlock('body');
        }

        if (t.data('scroll') === 'bottom') {
            scrollToBlock('.footer');
        }

        return false;
    });

    function scrollToBlock(to, speed, offset) {
        if (typeof to === 'string') to = $(to);
        if (!to[0]) return;
        offset = offset || 0;
        speed = speed || 1000;
        $('html, body').stop().animate({
            scrollTop: to.offset().top - offset
        }, speed);
    }

    /* page-favorites */


    $(document).on('click', '.page-favorites .product-item-favorites', function () {
        $(this).addClass('disabled').closest('.products-col').fadeOut(400);
        return false;
    });
    /* product-item-await-remove */

    $(document).on('click', '.product-item-await-remove', function () {
        $(this).addClass('disabled').closest('.products-col').fadeOut(400);
        return false;
    });
    /* modal-thanks */

    // if ($('#modal-password-change').length) {
    //     openModal('#modal-password-change');
    // }
});

$(function () {
    let items = [];

    $.each($('.js-view-counter[data-item-id]'), function (index, counter) {
        let itemId = Number($(counter).attr('data-item-id'));
        if (!items.includes(itemId)) {
            items.push(itemId);
        }
    });

    axiosHelpers.getRequest('items-views', {items})
        .then(function (response) {
            if (response.data.success) {
                let items = response.data.result.items;
                items.forEach(function (item) {
                    $(`.js-view-counter[data-item-id=${item.id}]`).text(item.counter);
                })
            }
        });
});