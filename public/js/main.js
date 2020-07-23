$(function () {
    'use strict';
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

if (document.getElementById('jobsheet-create-form') != null) {
    var jobSheetCountText = {
        txt1: document.getElementById('job_title'),
        txt2: document.getElementById('job_intro'),
        txt3: document.getElementById('job_desc'),
        txt4: document.getElementById('remarks'),
    };

    new Vue({

        el: '#jobsheet-create-form',
        data: {
            typedText1: jobSheetCountText.txt1 != null ? jobSheetCountText.txt1.value : '',
            typedText2: jobSheetCountText.txt2 != null ? jobSheetCountText.txt2.value : '',
            typedText3: jobSheetCountText.txt3 != null ? jobSheetCountText.txt3.value : '',
            typedText4: jobSheetCountText.txt4 != null ? jobSheetCountText.txt4.value : '',
        },
        computed: {
            charaCount1: function () {
                return this.typedText1.length;
            },
            charaCount2: function () {
                return this.typedText2.length;
            },
            charaCount3: function () {
                return this.typedText3.length;
            },
            charaCount4: function () {
                return this.typedText4.length;
            },
        },
    });
}

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

        } else {
            select.prop('disabled', true);
            select.val(0);
        }
    });

    // 閉じるボタン
    $('#close_button').click(function () {
        window.close();
    });

    // サブミットボタン
    function submitAction(url) {
        $('form').attr('action', url);
        $('form').submit();
    };

});
