BX.ready(function () {
    BXmakerGeoIPDeliveryManager.init();
});



// ?????????? ?????? ? ?????????? ????????
if (!!window.BXmakerGeoIPDeliveryConstructor === false) {

    /**
     * ???????? ????? ??? ??????????? ?????????? ?????? ? ????? ? ????????? ????????
     * @param box
     * @constructor
     */
    var BXmakerGeoIPDeliveryConstructor = function (box) {
        var that = this;
        that.baseParams = {}; //??????? ?????????
        that.params = {};
        that.box = box;
        that.box.addClass('js-bxmaker__geoip__delivery--init');
        that.value = that.box.find('.js-bxmaker__geoip__delivery-box');
        that.rand = that.box.attr('data-rand');


        //??????? ????????? ------
        if (!window.BxmakerGeoipDeliveryDataBase || !window.BxmakerGeoipDeliveryDataBase[that.rand]) {
            return false;
        }
        that.baseParams = window.BxmakerGeoipDeliveryDataBase[that.rand];

        //???? ????????? ????????????? ????????? ????????? bxmaker:geoip.city
        if (!!window.BXmakerGeoIPCity && window.BXmakerGeoIPCity.isInit()) {
            that.execute();
        }
        else {
            $(document).on('bxmaker.geoip.city.inited', $.proxy(that.execute, that));
        }

    };

    /**
     * ?????????? ???????? ??????
     */
    BXmakerGeoIPDeliveryConstructor.prototype.execute = function () {
        var that = this;

        //???? ??????? ???????? ?? ????????? ?????????
        that.log('debug is on');


        //??????????? ?????
        that.box.find('.js-bxmaker__geoip__delivery-city').text(window.BXmakerGeoIPCity.getCity());

        // ???????? ? ????? ?????? ???????? ????????
        if (window.frameCacheVars !== undefined && !window.frameCacheVars.AUTO_UPDATE) {

            // ???? ??? ???????? ajax  ????, ?? ??????? ?????? ??????
            that.reload();
        }
        else
        {
            // ????????, ???? ?? ?????? ??? ?????? ??????????
            if (!window.BxmakerGeoipDeliveryData && !window.BxmakerGeoipDeliveryData[that.rand]) {
                return false;
            }
            that.params = window.BxmakerGeoipDeliveryData[that.rand];

            if (that.params.location != window.BXmakerGeoIPCity.getLocation() || that.params.city != window.BXmakerGeoIPCity.getCity()) {
                that.params.location = window.BXmakerGeoIPCity.getLocation();
                that.params.city = window.BXmakerGeoIPCity.getCity();

                that.reload();
            }
            else {

                that.box.removeClass('preloader');

                // ???????????
                that.initEvent();
            }
        }
    };


    BXmakerGeoIPDeliveryConstructor.prototype.log = function () {
        if (this.baseParams.debug) {
            var args = Array.prototype.slice.call(arguments);
            args.unshift('bxmaker:geoip.delivery[' + this.rand + ']: ');
            console.log.apply(console, args);
        }
    };

    BXmakerGeoIPDeliveryConstructor.prototype.logError = function () {
        if (this.baseParams.debug) {
            var args = Array.prototype.slice.call(arguments);
            args.unshift('bxmaker:geoip.delivery[' + this.rand + ']: ');
            console.error.apply(console, args);
        }
    };

    /**
     * ?????????/?????????? ?????? ???????
     * @param flag
     */
    BXmakerGeoIPDeliveryConstructor.prototype.setDebug = function (flag) {
        this.baseParams.debug = flag;
        if (flag) {
            this.cookie('debug', 'Y');
        }
        else {
            this.cookie('debug', 'N');
        }
    };

    /**
     * ????????? ??? ????????? ???????? ????
     * @returns {*}
     */
    BXmakerGeoIPDeliveryConstructor.prototype.cookie = function () {
        return window.BXmakerGeoIPCity.cookie.apply(window.BXmakerGeoIPCity, Array.prototype.slice.call(arguments));
    };

    /**
     * ????????? ?? ???????? ??????
     * @param hashBased
     * @returns {Array}
     */
    BXmakerGeoIPDeliveryConstructor.prototype.getJsonFromUrl = function (hashBased) {
        var query;
        if (hashBased) {
            var pos = location.href.indexOf("?");
            if (pos == -1) return [];
            query = location.href.substr(pos + 1);
        } else {
            query = location.search.substr(1);
        }
        var result = {};
        query.split("&").forEach(function (part) {
            if (!part) return;
            part = part.split("+").join(" "); // replace every + with space, regexp-free version
            var eq = part.indexOf("=");
            var key = eq > -1 ? part.substr(0, eq) : part;
            var val = eq > -1 ? decodeURIComponent(part.substr(eq + 1)) : "";
            var from = key.indexOf("[");
            if (from == -1) result[decodeURIComponent(key)] = val;
            else {
                var to = key.indexOf("]", from);
                var index = decodeURIComponent(key.substring(from + 1, to));
                key = decodeURIComponent(key.substring(0, from));
                if (!result[key]) result[key] = [];
                if (!index) result[key].push(val);
                else result[key][index] = val;
            }
        });
        return result;
    };


    /**
     * ????????? ??????????? ???????
     */
    BXmakerGeoIPDeliveryConstructor.prototype.initEvent = function () {
        var that = this;

        if(!that.isInitedEvent)
        {
            that.isInitedEvent = true;

            that.log('init event');

            that.box.on("click", '.js-bxmaker__geoip__delivery-city', function () {
                that.log('trigger: bxmaker.geoip.city.search.start');
                $(document).trigger('bxmaker.geoip.city.search.start');
            });

            $(document).on('bxmaker.geoip.city.show', function (event, data) {
                that.log('event: bxmaker.geoip.city.show');
                that.box.find('.js-bxmaker__geoip__delivery-city').text(data.city);

                if(that.params.location === undefined)
                {
                    return false;
                }

                if (that.params.location != data.location || that.params.city != data.city) {
                    that.params.location = data.location;
                    that.params.city = data.city;

                    that.reload();
                }
                else {
                    that.box.removeClass('preloader');
                }
            });
        }



    };

    /**
     * ?????????? ?????????? ???? ??????????
     * @returns {string}
     */
    BXmakerGeoIPDeliveryConstructor.prototype.getKey = function () {
        var that = this;
        return that.rand;
    };


    /**
     * ????????????? ID  ??????, ?????? ? ???????? ???????? ????? ????????, ????????????? ????????? ????? ??????????
     * @param productId
     */
    BXmakerGeoIPDeliveryConstructor.prototype.setProductId = function (productId) {
        var that = this;
        that.log('set product id - ' + productId);
        if(that.params.productId == productId)
        {
            return false;
        }

        that.params.productId = productId;
        that.reload();
    };


    BXmakerGeoIPDeliveryConstructor.prototype.reload = function () {
        var that = this;

        that.log('trigger:bxmaker.geoip.delivery.reload.before');
        $(document).trigger('bxmaker.geoip.delivery.reload.before');

        that.box.addClass('preloader');

        var urlparams = that.getJsonFromUrl();
        var data = {
            method: 'getDelivery',
            parameters: that.baseParams.parameters,
            template: that.baseParams.template,
            siteId: that.baseParams.siteId,

            productId: that.params.productId,
            location: that.params.location,
        };


        //?????? ?? ???????????? ???????? ?????????, ??? ??? ??? ??????? ?????????? ?????? ??? ????? ???????????,
        // ? ??? ??? ?? ?????? ????? ?????? ???? ??????, ?? ????? ????? ??????? ????? ????????
        // var key = [];
        // key.push(that.baseParams.template);
        // key.push(that.params.productId);
        // key.push(that.params.location);
        //

        // var r = window.BXmakerGeoIPCity.storageGet(key.join('|'));
        // if (!!r) {
        //     that.log(' getDelivery: success');
        //     that.box.find('.js-bxmaker__geoip__delivery-box').replaceWith(r.response.html);
        //
        //     that.box.find('.js-bxmaker__geoip__delivery-city').text(that.params.city);
        //     that.box.find('.js-bxmaker__geoip__delivery-box').attr('data-location', that.params.location).attr('data-city', that.params.city);
        //
        //     that.box.removeClass('preloader');
        //
        //     that.log('trigger:bxmaker.geoip.delivery.reload.after', r);
        //     $(document).trigger('bxmaker.geoip.delivery.reload.after', r);
        // }
        // else {
            $.ajax({
                type: 'POST',
                url: that.baseParams.ajaxUrl + (!!urlparams && !!urlparams.clear_cache ? '?clear_cache=' + urlparams.clear_cache : ''),
                dataType: 'json',
                data: data,
                complete: function(){
                    that.initEvent();
                },
                error: function (r) {

                    that.log(r, true);

                    that.box.removeClass('preloader');

                    var error = {
                        'error': {
                            code: 'ajax_error',
                            msg: 'Error  connection to server',
                            more: r
                        }
                    };

                    that.log('trigger:bxmaker.geoip.delivery.reload.after', error);
                    $(document).trigger('bxmaker.geoip.delivery.reload.after', error);
                },
                success: function (r) {

                    if (!!r.response) {

                        // window.BXmakerGeoIPCity.storageSet(key.join('|'), r);

                        that.log(' getDelivery: success');
                        that.box.find('.js-bxmaker__geoip__delivery-box').replaceWith(r.response.html);

                        that.box.find('.js-bxmaker__geoip__delivery-city').text(that.params.city);
                        that.box.find('.js-bxmaker__geoip__delivery-box').attr('data-location', that.params.location).attr('data-city', that.params.city);

                    }
                    else if (!!r.error) {
                        that.logError(' getDelivery: error', r);
                    }

                    that.box.removeClass('preloader');

                    that.log('trigger:bxmaker.geoip.delivery.reload.after', r);
                    $(document).trigger('bxmaker.geoip.delivery.reload.after', r);
                }
            });
        // }
    };

}


/**
 * ?????????? ????? ??????? ? ?????????? ???????? ?? ????????
  */
if (!!window.BXmakerGeoIPDeliveryManager === false) {
    (function () {

        /**
         * ????? ??? ?????? ????? ?? ????? ???????, ?????? ?????? ?? ???????
         * ??????? ????? ???? ???????? ?? ????? ??????????? = data-rand ?? ????????? ???? ??????????
         * @constructor
         */
        var BXmakerGeoIPDelivery = function () {
            var that = this;
            that.itemsKey = {};
        };

        BXmakerGeoIPDelivery.prototype.init = function () {
            var that = this;

            $('.js-bxmaker__geoip__delivery:not(.js-bxmaker__geoip__delivery--init)').each(function () {
                var item = new BXmakerGeoIPDeliveryConstructor($(this));

                that.itemsKey[item.getKey()] = item;
            });
        };

        BXmakerGeoIPDelivery.prototype.getItemByKey = function (code) {
            var that = this;
            return that.itemsKey[code] || false;
        };

        BXmakerGeoIPDelivery.prototype.setProductID = function (productId, code) {
            var that = this;
            if (!!code && !!that.itemsKey[code]) {
                that.itemsKey[code].setProductId(productId);
            }
            else {
                for (var i in that.itemsKey) {
                    that.itemsKey[i].setProductId(productId);
                }
            }
        };

        window.BXmakerGeoIPDeliveryManager = new BXmakerGeoIPDelivery();
    })();

}
