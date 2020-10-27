$(function () {
    'use strict';

    $("form").submit(function () {
        var self = this;
        $(":submit", self).prop("disabled", true);
        setTimeout(function () {
            $(":submit", self).prop("disabled", false);
        }, 10000);
    });

    if ($('#start_specified_date').length && $('#end_specified_date').length) {

        var start_specified_date = $('#start_specified_date'),
            end_specified_date = $('#end_specified_date');

        if (start_specified_date.val() == false) {
            start_specified_date.prop('disabled', true);
        } else {
            start_specified_date.prop('disabled', false);
        }
        if (end_specified_date.val() == false) {
            end_specified_date.prop('disabled', true);
        } else {
            end_specified_date.prop('disabled', false);
        }

        $('#shortest').click(function () {
            if ($("#shortest").prop("checked") == true) {
                start_specified_date.prop('disabled', true);
                start_specified_date.val('');
            } else {
                start_specified_date.prop('disabled', false);
            }
        });

        $('#start_specified').click(function () {
            if ($("#start_specified").prop("checked") == true) {
                start_specified_date.prop('disabled', false);
            } else {
                start_specified_date.prop('disabled', true);
            }
        });

        $('#not_specified').click(function () {
            if ($("#not_specified").prop("checked") == true) {
                end_specified_date.prop('disabled', true);
                end_specified_date.val('');
            } else {
                end_specified_date.prop('disabled', false);
            }
        });

        $('#end_specified').click(function () {
            if ($("#end_specified").prop("checked") == true) {
                end_specified_date.prop('disabled', false);
            } else {
                end_specified_date.prop('disabled', true);
            }
        });
    }
});

$(function () {
    // タブ
    $(".tab_label").on("click", function () {
        var $th = $(this).index();
        $(".tab_label").removeClass("active");
        $(".tab_panel").removeClass("active");
        $(this).addClass("active");
        $(".tab_panel").eq($th).addClass("active");
    });

    // 求人作成画面の給与カテゴリのセレクト操作
    var salaryCats = $(".jc-jsc-salary-money-selectfield");
    salaryCats.each(function (index, element) {
        var select = $(element).parent().next();
        if (!$(element).prop('checked')) {
            select.prop('disabled', true)
        }
    })

    salaryCats.on('click', function () {
        var select = $(this).parent().next();
        if ($(this).prop('checked')) {
            var select = $(this).parent().next();
            select.prop('disabled', false);
            select.prop("selectedIndex", 0);

        } else {
            select.prop('disabled', true);
            select.val(0);
        }
    });

    // 閉じるボタン
    $('#close_button').click(function () {
        window.close();
    });

});
