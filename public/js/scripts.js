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

function confirmDelete(name) {
    if (confirm("Вы подтверждаете удаление " + name + "?")) {
        return true;
    } else {
        return false;
    }
}

$(document).ready(function () {
    $('#mainmenu .menu li').hover(
        function () {
            $(this).find('ul:first').show();
            $(this).find('a:first').addClass("hover");
        },
        function () {
            $(this).find('ul:first').hide();
            $(this).find('a:first').removeClass("hover");
        }
    );
    // slider --

    StartSliderAuto();
    window.onblur = StopSliderAuto();
    window.onfocus = StartSliderAuto();


    var total = $("#img_box img").length;
    $("#img_box").css({
        "width": total * 598
    });

    $("#imglink_shape1").addClass('select');


    $("#imgthumb_shape a").click(function () {

        var imgnumber_shape = parseInt($(this).attr('id').replace("imglink_shape", ""));
        var move_shape = -(598 * (imgnumber_shape - 1));
        $(".thumblink_shape").removeClass('select');
        $("#navigate #linknext").css({
            "display": "none"

        });
        $("#navigate #linkprev").css({
            "display": "none"

        });
        $('#imglink_shape' + imgnumber_shape).addClass('select');
        $("#img_box").animate({
            left: move_shape
        }, 800);


        return false;
    });

    // -- slider
});


function StopSliderAuto() {
    // alert('sdff');
    $(document).stopTime('timer');
    //	$("#slider .arrr").stopTime('evrytimer2');

}

function StartSliderAuto() {
    var total = $("#img_box img").length;
    $("#img_box").css({
        "width": total * 598
    });

    /*
    $(document).everyTime(8500, 'timer', function () {


        var imgwidth = 598;
        var box_left = $("#img_box").css("left");

        var move, imgnumber, move_shape, imgnumber_shape, old_imgnumber;

        if (box_left == 'auto') {
            box_left = 0;
        } else {
            box_left = parseInt(box_left.replace("px", ""));
        }

        // Если нажата кнопка для перехода на предыдущее изображение

        // Если изображение последнее, то переходим на первую картинку
        if (-(box_left) == (imgwidth * (total - 1))) {
            move = 0;
            move_shape = 0;
        } else {
            move = box_left - imgwidth;
            move_shape = box_left - imgwidth;
        }

        imgnumber = Math.abs((box_left / imgwidth)) + 2;
        old_imgnumber = imgnumber - 1;
        if (imgnumber == (total + 1)) {
            imgnumber = 1;
            old_imgnumber = total;
        }

        imgnumber_shape = Math.abs((box_left / imgwidth)) + 2;
        if (imgnumber_shape == (total + 1)) {
            imgnumber_shape = 1;
        }


        $("#imglink_shape" + old_imgnumber).removeClass('select');
        $("#imglink_shape" + imgnumber).addClass('select');


        $("#img_box").animate({
            left: move + 'px'
        }, 800);


    });
    */
}

