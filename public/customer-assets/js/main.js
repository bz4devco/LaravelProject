//start search
$(document).ready(function () {
    $("#search")
        .focusin(function () {
            $(".search-result").removeClass("visually-hidden");
            $(".search-box").addClass("search-box-active");
        })
        .add(".search-result")
        .focusout(function () {
            if (!$(".search-result").is(":focus")) {
                $(".search-result").addClass("visually-hidden");
                $(".search-box").removeClass("search-box-active");
            }
        });
});
//end search

//start super navbar
$(document).ready(function () {
    $(".super-navbar-item").hover(
        function () {
            $(".sublist-item").removeClass("sublist-item-active");
            $(".sublist-item").first().addClass("sublist-item-active");
        },
        function () {
            $(".sublist-item").removeClass("sublist-item-active");
        }
    );

    $(".sublist-item-toggle").click(function () {
        $(".sublist-item").removeClass("sublist-item-active");
        $(this).parent().addClass("sublist-item-active");
    });

    $(".sublist-item-toggle").hover(function () {
        $(".sublist-item").removeClass("sublist-item-active");
        $(this).parent().addClass("sublist-item-active");
    });
});
//end super navbar

//start owlcarousel
$(document).ready(function () {
    $("#slideshow").owlCarousel({
        rtl: true,
        loop: true,
        margin: 0,
        nav: false,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        animateOut: "fadeOut",
        animateIn: "fadeIn",
        items: 1,
    });

    $(".lazyload").owlCarousel({
        rtl: true,
        loop: false,
        margin: 10,
        nav: true,
        dots: false,
        autoplay: false,
        autoHeight: false,
        responsive: {
            0: {
                items: 1,
            },
            425: {
                items: 2,
            },
            600: {
                items: 3,
            },
            1000: {
                items: 5,
            },
        },
    });

    $(".brands").owlCarousel({
        rtl: true,
        loop: true,
        margin: 10,
        nav: true,
        dots: false,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        animateOut: "fadeOut",
        animateIn: "fadeIn",
        items: 5,
    });

    // $(".owl-carousel").owlCarousel({
    //     rtl:true,
    //     loop:true,
    //     margin:0,
    //     nav:false,
    //     autoplay:true,
    //     autoplayTimeout:5000,
    //     autoplayHoverPause:true,
    //     animateOut: 'fadeOut',
    //     animateIn: 'fadeIn',
    //     items: 1
    // });
});
//end owlcarousel

//start tooltip
$(document).ready(function () {
    var tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
//end tooltip

//start cart
$(document).ready(function () {
    $(".cart-number-up").click(function () {
        var value = parseInt($(this).parent().find("input[type=number]").val()),
            max = parseInt(
                $(this).parent().find("input[type=number]").attr("max")
            ),
            step = parseInt(
                $(this).parent().find("input[type=number]").attr("step")
            );

        if (value < max) {
            $(this)
                .parent()
                .find("input[type=number]")
                .val(value + step);
        }
    });

    $(".cart-number-down").click(function () {
        var value = parseInt($(this).parent().find("input[type=number]").val()),
            min = parseInt(
                $(this).parent().find("input[type=number]").attr("min")
            ),
            step = parseInt(
                $(this).parent().find("input[type=number]").attr("step")
            );
        if (value > min) {
            $(this)
                .parent()
                .find("input[type=number]")
                .val(value - step);
        }
    });
});
//end cart

//start address
$(document).ready(function () {
    $('input[name="addaddress_idress"]').change(function () {
        var address = $('input[name="address_id"]').is(":checked");
        var delivery_type = $('input[name="delivery_id"]').is(":checked");

        if (address == true && delivery_type == true) {
            $("#address-button").removeClass("d-block");
            $("#address-button").addClass("d-none");
            $("#next-level").removeClass("d-none");
            $("#next-level").addClass("d-block");
        }
    });

    $('input[name="delivery_id"]').change(function () {
        var address = $('input[name="address_id"]').is(":checked");
        var delivery_type = $('input[name="delivery_id"]').is(":checked");

        if (address == true && delivery_type == true) {
            $("#address-button").removeClass("d-block");
            $("#address-button").addClass("d-none");
            $("#next-level").removeClass("d-none");
            $("#next-level").addClass("d-block");
        }
    });
});
//end address

//start payment
$(document).ready(function () {
    isCheckedPaymentType();
    $('input[name="payment_type"]').change(function () {
        isCheckedPaymentType();
    });
});
function isCheckedPaymentType() {
    var payment_type = $('input[name="payment_type"]').is(":checked");

    if (payment_type == true) {
        $("#payment-button").removeClass("d-block");
        $("#payment-button").addClass("d-none");
        $("#final-level").removeClass("d-none");
        $("#final-level").addClass("d-block");
    }
}
//end payment

//start filter
$(document).ready(function () {
    $(".sidebar-nav-item-title").click(function () {
        $header = $(this);
        $content = $header.next();

        $(".sidebar-nav-sub-sub-wrapper").slideUp();
        $(".sidebar-nav-sub-item-title i").removeClass(
            "rotate-angle-left-90-degrees"
        );
        if ($content.is(":visible")) {
            $header.find("i").removeClass("rotate-angle-left-90-degrees");
            $content.slideUp();
        } else {
            $(".sidebar-nav-item-title i").removeClass(
                "rotate-angle-left-90-degrees"
            );
            $(".sidebar-nav-sub-wrapper").slideUp();
            $header.find("i").addClass("rotate-angle-left-90-degrees");
            $content.slideToggle(400);
        }
    });

    $(".sidebar-nav-sub-item-title").click(function () {
        $subHeader = $(this);
        $subContent = $subHeader.next();

        if ($subContent.is(":visible")) {
            $subHeader.find("i").removeClass("rotate-angle-left-90-degrees");
            $subContent.slideUp();
        } else {
            $(".sidebar-nav-sub-item-title i").removeClass(
                "rotate-angle-left-90-degrees"
            );
            $(".sidebar-nav-sub-sub-wrapper").slideUp();
            $subHeader.find("i").addClass("rotate-angle-left-90-degrees");
            $subContent.slideToggle(400);
        }
    });
});
//end filter

//start filter
$(document).ready(function () {
    $(".product-gallery-selected-image img").css(
        "height",
        $(".product-gallery-selected-image img").css("width")
    );
    $(".product-gallery-thumb").click(function () {
        var selectedImageSrc = $(this).attr("data-input");
        $(".product-gallery-selected-image img").attr("src", selectedImageSrc);
        $(".product-gallery-selected-image img").css(
            "height",
            $(".product-gallery-selected-image img").css("width")
        );
    });
});
//end filter

//start product introduction, features and comment
$(document).ready(function () {
    var s = $("#introduction-features-comments");

    if (s.html() != undefined) {
        var pos = s.position();
        $(window).scroll(function () {
            var windowpos = $(window).scrollTop();

            if (windowpos >= pos.top) {
                s.addClass("stick");
            } else {
                s.removeClass("stick");
            }
        });
    }
});
//end product introduction, features and comment

//start scroll sticky header
$(document).ready(function () {
    let header = $("#header");

    if (header.html() != undefined) {
        $(window).scroll(function () {
            var windowpos = $(window).scrollTop();

            if (windowpos >= 120) {
                header.addClass("sticky");
            } else {
                header.removeClass("sticky");
            }
        });
    }
});
//end scroll sticky header
