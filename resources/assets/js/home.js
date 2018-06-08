(function ($) {
    let landing_src = $(".home-cover-img", "#home-cover-slideshow").first().attr("data-src");

    function showHomeCover() {
        $("body").addClass("load");
        $(".home-cover-img", "#home-cover-slideshow").first().css("background-image", "url(" + landing_src + ")").addClass("animate-in--alt").removeAttr("data-src");
        setTimeout(function () {
            $("body").addClass("loaded");
            setTimeout(function () {
                showHomeSlideshow();
            }, 7000);
        }, 400 * 1.5);
    }

    let showHomeSlideshowInterval = function () {
        setTimeout(function () {
            showHomeSlideshow();
        }, 8000);
    };

    function showHomeSlideshow() {
        let $image = $(".home-cover-img[data-src]", "#home-cover-slideshow").first();
        let $images = $(".home-cover-img", "#home-cover-slideshow");
        if ($image.length == 0) {
            if ($images.length == 1)
                return;
            $images.first().removeClass("animate-in");
            $("#home-cover-slideshow").append($images.first());
            setTimeout(function () {
                $(".home-cover-img:last", "#home-cover-slideshow").addClass("animate-in");
            }, 20);
            setTimeout(function () {
                $(".home-cover-img:not(:last)", "#home-cover-slideshow").removeClass("animate-in");
            }, 4000);
            showHomeSlideshowInterval();
        } else {
            let src = $image.attr("data-src");
            $("<img/>").attr("src", src).on("load error", function () {
                $(this).remove();
                $image.css("background-image", "url(" + src + ")").addClass("animate-in").removeAttr("data-src");
                setTimeout(function () {
                    $(".home-cover-img:not(:last)", "#home-cover-slideshow").removeClass("animate-end animate-in--alt");
                }, 2000);
                showHomeSlideshowInterval();
            });
        }
    }

    if (landing_src) {
        $("<img/>").attr("src", landing_src).on("load error", function () {
            $(this).remove();
            showHomeCover();
        });
    }
})(jQuery);