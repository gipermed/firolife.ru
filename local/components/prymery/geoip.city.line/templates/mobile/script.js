BX.ready(function () {
    if (!window.PrymeryGeoIPCityLineCheck) {
        window.PrymeryGeoIPCityLineCheck = true;
        $('.js-prymery__geoip__city__line:not(.js-prymery__geoip__city__line--init)').each(function () {
            new PrymeryGeoIPCityLineConstructor($(this));
        });
    }
});


if (!!window.PrymeryGeoIPCityLineConstructor === false) {

    var PrymeryGeoIPCityLineConstructor = function (box) {
        var that = this;
        that.params = {};
        that.box = box;
        that.box.addClass('js-prymery__geoip__city__line--init');
        that.rand = that.box.attr('data-rand');

        // ��������, ���� �� ������ ��� ������ ����������
        if (!window.PrymeryGeoipCityLineData || !window.PrymeryGeoipCityLineData[that.rand]) {
            return false;
        }
        that.params = window.PrymeryGeoipCityLineData[that.rand];


        if (!!window.PrymeryGeoIPCity && window.PrymeryGeoIPCity.isInit()) {
            that.execute();
        }
        else {
            $(document).on('prymery.geoip.city.inited', $.proxy(that.execute, that));
        }
    };

    /**
     * �������� �� ������� � ������������ ��������
     */
    PrymeryGeoIPCityLineConstructor.prototype.execute = function () {
        var that = this;

        // �������� �������� �� ������� �������
        if (that.cookie('debug') == 'Y') {
            that.params.debug = true;
        }

        if (that.params.debug) {
            that.log('debug is on');
        }

        that.initEvent();
    };


    PrymeryGeoIPCityLineConstructor.prototype.cookie = function () {
        return window.PrymeryGeoIPCity.cookie.apply(window.PrymeryGeoIPCity, Array.prototype.slice.call(arguments));
    };

    /**
     * ���������/���������� ������ �������
     * @param flag
     */
    PrymeryGeoIPCityLineConstructor.prototype.setDebug = function (flag) {
        this.params.debug = flag;
        if (flag) {
            this.cookie('debug', 'Y');
        }
        else {
            this.cookie('debug', 'N');
        }
    };

    PrymeryGeoIPCityLineConstructor.prototype.log = function () {
        var that = this;
        if (that.params.debug) {
            var args = Array.prototype.slice.call(arguments);
            args.unshift('prymery:geoip.city.line: ');
            console.log.apply(console, args);
        }
    };

    PrymeryGeoIPCityLineConstructor.prototype.initEvent = function () {
        var that = this;

        var bQuestionShow = false;
        var timeout = false;

        that.log('init event');

        // ����� �� ���������� ������
        if (that.params.questionShow) {
            that.log('question tooltip is on');
            if (that.cookie('location_confirm') == 'Y') {
                that.log('question tooltip is hide');
                bQuestionShow = false;
            }
            else {
                that.log('question tooltip not hide');
                that.tooltipQuestionShow();
                bQuestionShow = true;
            }
        }
        else
        {
            //����� ����� ��������� ������������� ������ �������������
            that.cookie('location_confirm', 'Y');
        }

        that.box
            .on("mouseenter", '.js-prymery__geoip__city__line-context', function () {

                if (!!timeout) clearTimeout(timeout);

                that.log('mouseenter');

                if (bQuestionShow) {
                    that.tooltipQuestionShow();
                }
                else {
                    that.tooltipInfoShow();
                }
            })
            .on("mouseleave", '.js-prymery__geoip__city__line-context', function () {

                if (!!timeout) clearTimeout(timeout);
                that.log('mouseleave');
                if (bQuestionShow) {
                    timeout = setTimeout($.proxy(that.tooltipQuestionHide, that), that.params.tooltipTimeout);
                }
                else {
                    timeout = setTimeout($.proxy(that.tooltipInfoHide, that), that.params.tooltipTimeout);
                }
            })
            .on("click", '.js-prymery__geoip__city__line-question-btn-no', function () {
                that.log('question answer no');
                that.tooltipQuestionHide();
                that.log('trigger: prymery.geoip.city.search.start');
                $(document).trigger('prymery.geoip.city.search.start');

                bQuestionShow = false;
            })
            .on("click", '.js-prymery__geoip__city__line-question-btn-yes', function () {
                that.log('question answer yes');
                that.tooltipQuestionHide();
                that.cookie('location_confirm', 'Y');
                window.PrymeryGeoIPCity.checkRedirect();
                bQuestionShow = false;
            })
            .on("click", '.js-prymery__geoip__city__line-info-btn', function () {
                that.log('info need city change');
                that.tooltipInfoHide();
                that.log('trigger: prymery.geoip.city.search.start');
                $(document).trigger('prymery.geoip.city.search.start');
            })
            .on("click", '.js-prymery__geoip__city__line-name', function () {
                that.log('click by city name');
                that.cookie('location_confirm', 'Y');
                that.tooltipQuestionHide();
                that.tooltipInfoHide();
                that.log('trigger: prymery.geoip.city.search.start');
                $(document).trigger('prymery.geoip.city.search.start');
            });

        $(document).on('prymery.geoip.city.show', function (event, data) {
            that.log('event: prymery.geoip.city.show');
            that.showCity(data.city);
        });

        that.showCity(window.PrymeryGeoIPCity.getCity());

    };

    PrymeryGeoIPCityLineConstructor.prototype.tooltipQuestionShow = function () {
        var that = this;
        that.log('tooltip question show');
        that.box.find('.js-prymery__geoip__city__line-question').stop().fadeIn(that.params.animateTimeout);
    };
    PrymeryGeoIPCityLineConstructor.prototype.tooltipQuestionHide = function () {
        var that = this;
        that.log('tooltip question hide');
        that.box.find('.js-prymery__geoip__city__line-question').stop().fadeOut(that.params.animateTimeout);
    };
    PrymeryGeoIPCityLineConstructor.prototype.tooltipInfoShow = function () {
        var that = this;
        if (that.params.infoShow) {
            that.log('tooltip info show');
            that.box.find('.js-prymery__geoip__city__line-info').stop().fadeIn(that.params.animateTimeout);
        }
    };
    PrymeryGeoIPCityLineConstructor.prototype.tooltipInfoHide = function () {
        var that = this;
        that.log('tooltip info hide');
        that.box.find('.js-prymery__geoip__city__line-info').stop().fadeOut(that.params.animateTimeout);
    };

    PrymeryGeoIPCityLineConstructor.prototype.showCity = function (city) {
        var that = this;
        that.log('show city');
        that.box.find('.js-prymery__geoip__city__line-city').text(city);
    };
}