$(document).ready(function () {

    $("#mainmenu .menu li a").bind("click", function () {

        $(this).next('ul').slideToggle();

        var src = $(this).prevAll('img').attr("src");
        if (src === "images/menu_icon.png" || src === "/images/menu_icon.png")
            src = "/images/menu_icon2.png";
        else
            src = "/images/menu_icon.png";

        $(this).prevAll('img').attr("src", src);


    });
});

$(document).ready(function () {
    $(".datepicker").datepicker();
});

function checkAccept(object) {
    if ($(object).is(":checked")) {
        $('#save').attr('disabled', false);
    } else {
        $('#save').attr('disabled', true);
    }
}
