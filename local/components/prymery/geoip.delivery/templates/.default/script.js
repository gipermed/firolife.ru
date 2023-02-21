BX.ready(function () {
    PrymeryGeoIPDeliveryManager.init();
});



// ���������� ������ � ���������� ��������
if (!!window.PrymeryGeoIPDeliveryConstructor === false) {

    /**
     * �������� ����� ��� ����������� ���������� ������ � ����� � ��������� ��������
     * @param box
     * @constructor
     */
    var PrymeryGeoIPDeliveryConstructor = function (box) {
        var that = this;
        that.baseParams = {}; //������� ���������
        that.params = {};
        that.box = box;
        that.box.addClass('js-prymery__geoip__delivery--init');
        that.value = that.box.find('.js-prymery__geoip__delivery-box');
        that.rand = that.box.attr('data-rand');


        //������� ��������� ------
        if (!window.PrymeryGeoipDeliveryDataBase || !window.PrymeryGeoipDeliveryDataBase[that.rand]) {
            return false;
        }
        that.baseParams = window.PrymeryGeoipDeliveryDataBase[that.rand];

        //���� ��������� ������������� ��������� ��������� Prymery:geoip.city
        if (!!window.PrymeryGeoIPCity && window.PrymeryGeoIPCity.isInit()) {
            that.execute();
        }
        else {
            $(document).on('prymery.geoip.city.inited', $.proxy(that.execute, that));
        }

    };

    /**
     * ���������� �������� ������
     */
    PrymeryGeoIPDeliveryConstructor.prototype.execute = function () {
        var that = this;

        //���� ������� �������� �� ��������� ���������
        that.log('debug is on');


        //����������� �����
        that.box.find('.js-prymery__geoip__delivery-city').text(window.PrymeryGeoIPCity.getCity());

        // �������� � ����� ������ �������� ��������
        if (window.frameCacheVars !== undefined && !window.frameCacheVars.AUTO_UPDATE) {

            // ���� ��� �������� ajax  ����, �� ������� ������ ������
            that.reload();
        }
        else
        {
            // ��������, ���� �� ������ ��� ������ ����������
            if (!window.PrymeryGeoipDeliveryData && !window.PrymeryGeoipDeliveryData[that.rand]) {
                return false;
            }
            that.params = window.PrymeryGeoipDeliveryData[that.rand];

            if (that.params.location != window.PrymeryGeoIPCity.getLocation() || that.params.city != window.PrymeryGeoIPCity.getCity()) {
                that.params.location = window.PrymeryGeoIPCity.getLocation();
                that.params.city = window.PrymeryGeoIPCity.getCity();

                that.reload();
            }
            else {

                that.box.removeClass('preloader');

                // �����������
                that.initEvent();
            }
        }
    };


    PrymeryGeoIPDeliveryConstructor.prototype.log = function () {
        if (this.baseParams.debug) {
            var args = Array.prototype.slice.call(arguments);
            args.unshift('prymery:geoip.delivery[' + this.rand + ']: ');
            console.log.apply(console, args);
        }
    };

    PrymeryGeoIPDeliveryConstructor.prototype.logError = function () {
        if (this.baseParams.debug) {
            var args = Array.prototype.slice.call(arguments);
            args.unshift('prymery:geoip.delivery[' + this.rand + ']: ');
            console.error.apply(console, args);
        }
    };

    /**
     * ���������/���������� ������ �������
     * @param flag
     */
    PrymeryGeoIPDeliveryConstructor.prototype.setDebug = function (flag) {
        this.baseParams.debug = flag;
        if (flag) {
            this.cookie('debug', 'Y');
        }
        else {
            this.cookie('debug', 'N');
        }
    };

    /**
     * ��������� ��� ��������� �������� ����
     * @returns {*}
     */
    PrymeryGeoIPDeliveryConstructor.prototype.cookie = function () {
        return window.PrymeryGeoIPCity.cookie.apply(window.PrymeryGeoIPCity, Array.prototype.slice.call(arguments));
    };

    /**
     * ��������� �� �������� ������
     * @param hashBased
     * @returns {Array}
     */
    PrymeryGeoIPDeliveryConstructor.prototype.getJsonFromUrl = function (hashBased) {
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
     * ��������� ����������� �������
     */
    PrymeryGeoIPDeliveryConstructor.prototype.initEvent = function () {
        var that = this;

        if(!that.isInitedEvent)
        {
            that.isInitedEvent = true;

            that.log('init event');

            that.box.on("click", '.js-prymery__geoip__delivery-city', function () {
                that.log('trigger: prymery.geoip.city.search.start');
                $(document).trigger('prymery.geoip.city.search.start');
            });

            $(document).on('prymery.geoip.city.show', function (event, data) {
                that.log('event: prymery.geoip.city.show');
                that.box.find('.js-prymery__geoip__delivery-city').text(data.city);

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
     * ���������� ���������� ���� ����������
     * @returns {string}
     */
    PrymeryGeoIPDeliveryConstructor.prototype.getKey = function () {
        var that = this;
        return that.rand;
    };


    /**
     * ������������� ID  ������, ������ � �������� �������� ����� ��������, ������������� ��������� ����� ����������
     * @param productId
     */
    PrymeryGeoIPDeliveryConstructor.prototype.setProductId = function (productId) {
        var that = this;
        that.log('set product id - ' + productId);
        if(that.params.productId == productId)
        {
            return false;
        }

        that.params.productId = productId;
        that.reload();
    };


    PrymeryGeoIPDeliveryConstructor.prototype.reload = function () {
        var that = this;

        that.log('trigger:prymery.geoip.delivery.reload.before');
        $(document).trigger('prymery.geoip.delivery.reload.before');

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


        //������ �� ������������ �������� ���������, ��� ��� ��� ������� ���������� ������ ��� ����� �����������,
        // � ��� ��� �� ������ ����� ������ ���� ������, �� ����� ����� ������� ����� ��������
        // var key = [];
        // key.push(that.baseParams.template);
        // key.push(that.params.productId);
        // key.push(that.params.location);
        //

        // var r = window.prymeryGeoIPCity.storageGet(key.join('|'));
        // if (!!r) {
        //     that.log(' getDelivery: success');
        //     that.box.find('.js-prymery__geoip__delivery-box').replaceWith(r.response.html);
        //
        //     that.box.find('.js-prymery__geoip__delivery-city').text(that.params.city);
        //     that.box.find('.js-prymery__geoip__delivery-box').attr('data-location', that.params.location).attr('data-city', that.params.city);
        //
        //     that.box.removeClass('preloader');
        //
        //     that.log('trigger:prymery.geoip.delivery.reload.after', r);
        //     $(document).trigger('prymery.geoip.delivery.reload.after', r);
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

                    that.log('trigger:prymery.geoip.delivery.reload.after', error);
                    $(document).trigger('prymery.geoip.delivery.reload.after', error);
                },
                success: function (r) {

                    if (!!r.response) {

                        // window.prymeryGeoIPCity.storageSet(key.join('|'), r);

                        that.log(' getDelivery: success');
                        that.box.find('.js-prymery__geoip__delivery-box').replaceWith(r.response.html);

                        that.box.find('.js-prymery__geoip__delivery-city').text(that.params.city);
                        that.box.find('.js-prymery__geoip__delivery-box').attr('data-location', that.params.location).attr('data-city', that.params.city);

                    }
                    else if (!!r.error) {
                        that.logError(' getDelivery: error', r);
                    }

                    that.box.removeClass('preloader');

                    that.log('trigger:prymery.geoip.delivery.reload.after', r);
                    $(document).trigger('prymery.geoip.delivery.reload.after', r);
                }
            });
        // }
    };

}


/**
 * ���������� ����� ������� � ���������� �������� �� ��������
  */
if (!!window.PrymeryGeoIPDeliveryManager === false) {
    (function () {

        /**
         * ����� ��� ������ ����� �� ����� �������, ������ ������ �� �������
         * ������� ����� ���� �������� �� ����� ����������� = data-rand �� ��������� ���� ����������
         * @constructor
         */
        var PrymeryGeoIPDelivery = function () {
            var that = this;
            that.itemsKey = {};
        };

        PrymeryGeoIPDelivery.prototype.init = function () {
            var that = this;

            $('.js-prymery__geoip__delivery:not(.js-prymery__geoip__delivery--init)').each(function () {
                var item = new PrymeryGeoIPDeliveryConstructor($(this));

                that.itemsKey[item.getKey()] = item;
            });
        };

        PrymeryGeoIPDelivery.prototype.getItemByKey = function (code) {
            var that = this;
            return that.itemsKey[code] || false;
        };

        PrymeryGeoIPDelivery.prototype.setProductID = function (productId, code) {
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

        window.PrymeryGeoIPDeliveryManager = new PrymeryGeoIPDelivery();
    })();

}
