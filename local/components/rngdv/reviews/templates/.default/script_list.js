var reviewRateIsSent = false;

function rateReview(sender) {
    var activeClass = "active";

    if (reviewRateIsSent) return;

    var $this = $(sender);
    var $container = $this.closest("[data-review-id]");
    var id = $container.data("review-id");
    var target = $container.data("target");

    var currRate = $this.data("make");
    var opstRate = currRate === "good" ? "bad" : "good";

    // opposite
    var $opst = $container.find("[data-make=" + opstRate + "]");


    var currIsActive = $this.hasClass(activeClass);
    var opstIsActive = $opst.hasClass(activeClass);

    var $currCntWrap = $this.find(".js-review-rate");
    var $opstCntWrap = $opst.find(".js-review-rate");


    var cnt = parseInt($currCntWrap.html());
    if (currIsActive) {
        $this.removeClass(activeClass);
        $currCntWrap.html(cnt - 1);
    } else {
        $this.addClass(activeClass);
        $currCntWrap.html(cnt + 1);
    }


    if (opstIsActive) {
        cnt = parseInt($opstCntWrap.html());
        $opstCntWrap.html(cnt - 1);
        $opst.removeClass(activeClass);
    }


    reviewRateIsSent = true;
    $(".loading").show();
    $.ajax({
        url: reviewsAjaxUrl,
        data: {
            id: id,
            rate: currRate,
            active: currIsActive ? "n" : "y",
            target: target,
            action: "rate"
        },
        dataType: "json",
        success: function (data) {
            $container.find("[data-make=good] .js-review-rate").html(data.rates.good);
            $container.find("[data-make=bad] .js-review-rate").html(data.rates.bad);

            if (data.err) {
                $opst.addClass(activeClass);
            }
        },
        complete: function () {
            $(".loading").hide();
            reviewRateIsSent = false;
        }
    });
}