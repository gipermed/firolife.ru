window.rngdv = window.rngdv || {};


window.rngdv.favorites = function (settings) {
    var self = this.favorites;
    var defaultSettings = {
        // from component
        COMPONENT: "",
        ACTION_ADD: "",
        ACTION_DEL: "",
        ITEMS: [],

        classAdded: "rngdvfav--added",
        selectorAdd: ".rngdvfav",
        selectorDelete: ".rngdvfav-delete",
        selectorRestore: ".rngdvfav-restore"
    };

    self.settings = $.extend({}, defaultSettings, settings);

    self.init = function () {
        self.setFavCnt(self.settings.ITEMS.length);

        try {
            cartApp.updateFav();
        } catch (e) {
        }

        $(self.settings.selectorDelete).each(function () {
            var $item = $(this);

            $item.on("click", function () {
                var $sender = $(this);
                var itemId = $sender.data("id");

                self.delFromFav($sender, itemId);

                $(".fav-item[data-id=" + itemId + "]").hide();
                $(".fav-item-deleted[data-id=" + itemId + "]").show();
                return false;
            });
        });

        $(self.settings.selectorRestore).each(function () {
            var $item = $(this);
            var itemId = $item.data("id");

            $item.on("click", function () {
                var $sender = $(this);
                var itemId = $sender.data("id");

                self.restore($sender, itemId);

                $(".fav-item[data-id=" + itemId + "]").show();
                $(".fav-item-deleted[data-id=" + itemId + "]").hide();
                return false;
            });
        });

        $(self.settings.selectorAdd).each(function () {
            var $item = $(this);
            var itemId = $item.data("id");

            if (self.settings.ITEMS.indexOf(itemId) !== -1) {
                $item.addClass(self.settings.classAdded);
            }


            $item.on("click", function () {
                var $sender = $(this);
                var itemId = $sender.data("id");

                if ($sender.hasClass(self.settings.classAdded)) {
                    //self.delFromFav( $sender, itemId );
                    window.location.href = "/personal/favorites/";
                } else {
                    self.addToFav($sender, itemId);
                }

                return false;
            });
        });
    };

    self.setFavCnt = function () {
        var cnt = self.settings.ITEMS.length;

        cnt = (cnt && cnt > 0)
            ? "(" + cnt + ")"
            : "(0)";

        $(".fav-cnt").html(cnt);
    };

    self.markAsFav = function ($item, isAdded /*= true/**/) {
        if (!$item) return;

        if (isAdded) {
            $item.addClass(self.settings.classAdded);
        } else {
            $item.removeClass(self.settings.classAdded);
        }
    };

    self.restore = function ($sender, id) {
        $.ajax({
            url: "/local/components/rngdv/favorites/ajax.php",
            dataType: "json",
            data: {
                component: self.settings.COMPONENT,
                action: self.settings.ACTION_ADD,
                id: id
            },
            success: function (data) {
                self.settings.ITEMS = data;
                self.setFavCnt();
            }
        });

    };

    self.addToFav = function ($sender, id, callback /*= false/**/) {
        $.ajax({
            url: "/local/components/rngdv/favorites/ajax.php",
            dataType: "json",
            data: {
                component: this.settings.COMPONENT,
                action: this.settings.ACTION_ADD,
                id: id
            },
            success: function (data) {
                self.settings.ITEMS = data;
                self.setFavCnt();
                self.markAsFav($sender, true);

                if (callback) callback();
            }
        });
    };

    self.delFromFav = function ($sender, id, callback /*= false/**/) {
        $.ajax({
            url: "/local/components/rngdv/favorites/ajax.php",
            dataType: "json",
            data: {
                component: self.settings.COMPONENT,
                action: self.settings.ACTION_DEL,
                id: id
            },
            success: function (data) {
                self.settings.ITEMS = data;
                self.setFavCnt();
                self.markAsFav($sender, false);

                if (callback) callback();
            }
        });
    };

    $(function () {
        self.init();
    });
}