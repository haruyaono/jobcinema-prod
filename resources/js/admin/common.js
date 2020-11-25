(function () {

    jQuery(function () {
        jQuery.extend(jQuery.fn.dataTable.defaults, {
            language: {
                url: "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Japanese.json"
            }
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

        // フィルター表示・非表示
        let target = $('.filter-btn');
        if (target.length > 0) {
            target.unbind('click');
            target.click(function (e) {
                if ($('#filter-box').is(':visible')) {
                    $('#filter-box').addClass('d-none');
                } else {
                    if (''.length > 0) {
                        if (target.attr('disabled')) {
                            return;
                        }
                        if (target.hasClass('loaded')) {
                            $('#filter-box').removeClass('d-none');
                            return;
                        }
                        var spinner = target.attr('disabled', true).data('loading-text');
                        target.append(spinner);
                        $.ajax({
                            url: '',
                            type: "GET",
                            contentType: 'application/json;charset=utf-8',
                            success: function (data) {
                                $('#filter-box').html($(data.html).children('form'));
                                eval(data.script);
                                target.attr('disabled', false).addClass('loaded');
                                target.find('.fa-spinner').remove();
                                $('#filter-box').removeClass('d-none');
                            }
                        });
                    } else {
                        $('#filter-box').removeClass('d-none');
                    }
                }
            });
        }


    });
}());
