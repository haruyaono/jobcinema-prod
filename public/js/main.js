$(function() {
    'use strict';
    if($('#start_specified_date').length && $('#end_specified_date').length) {

        var start_specified_date = $('#start_specified_date'),
            end_specified_date = $('#end_specified_date');

        if(start_specified_date.val() == false) {
            start_specified_date.prop('disabled', true);
        } else {
            start_specified_date.prop('disabled', false);
        }
        if(end_specified_date.val() == false) {
            end_specified_date.prop('disabled', true);
        } else {
            end_specified_date.prop('disabled', false);
        }

        $('#shortest').click(function(){
            if ($("#shortest").prop("checked") == true) {
                start_specified_date.prop('disabled', true);
                start_specified_date.val('');
            } else {
                start_specified_date.prop('disabled', false);
            }
        });

        $('#start_specified').click(function(){
            if ($("#start_specified").prop("checked") == true) {
                start_specified_date.prop('disabled', false);
            } else {
                start_specified_date.prop('disabled', true);
            }
        });

        $('#not_specified').click(function(){
            if ($("#not_specified").prop("checked") == true) {
                end_specified_date.prop('disabled', true);
                end_specified_date.val('');
            } else {
                end_specified_date.prop('disabled', false);
            }
        });

        $('#end_specified').click(function(){
            if ($("#end_specified").prop("checked") == true) {
                end_specified_date.prop('disabled', false);
            } else {
                end_specified_date.prop('disabled', true);
            }
        });
    }
});

   


if(document.getElementById('jobsheet-create-form') != null ) {
    var jobSheetCountText = {
        txt1 : document.getElementById('job_title'),
        txt2 : document.getElementById('job_intro'),
        txt3 : document.getElementById('job_desc'),
        txt4 : document.getElementById('remarks'),
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
            charaCount1: function() {
                return this.typedText1.length;
            },
            charaCount2: function() {
                return this.typedText2.length;
            },
            charaCount3: function() {
                return this.typedText3.length;
            },
            charaCount4: function() {
                return this.typedText4.length;
            },
        },
    });
}




$(function() {

    $(".tab_label").on("click",function(){
        var $th = $(this).index();
        $(".tab_label").removeClass("active");
        $(".tab_panel").removeClass("active");
        $(this).addClass("active");
        $(".tab_panel").eq($th).addClass("active");
    });

    $('#composite-form').change(function(){
        
        var status_val = 0,
            type_val = 0,
            area_val = 0,
            hourly_salary_val = 0,
            date_val = 0,
            text_val = '';

        if( $('#search-status').val()) {
            status_val = $('#search-status').val();
        } else {
            status_val = 0;
        }
        if($('#search-type').val()) {
            type_val = $('#search-type').val()
        } else {
            type_val = 0;
        }
        if($('#search-area').val()) {
            area_val = $('#search-area').val()
        } else {
            area_val = 0;
        }
        if($('#search-hourly-salary').val()) {
            hourly_salary_val = $('#search-hourly-salary').val()
        } else {
            hourly_salary_val = 0;
        }
        if($('#search-date').val()) {
            date_val = $('#search-date').val()
        } else {
            date_val = 0;
        }
        if($('#search-text').val()) {
            text_val = $('#search-text').val()
        } else {
            text_val = '';
        }

        var request = $.ajax({
            type: 'GET',
            url: '/status/' + status_val + '/type/' + type_val + '/area/' + area_val + '/hourly_salary/' + hourly_salary_val + '/date/' + date_val + '/text/' + text_val,
            cache: false,
            dataType: 'json',
            timeout: 3000
        })
        .then(
            function (data) {
                $('#job-count').text(data);
            },
            error => console.log("通信に失敗しました")
    
        );

    });


    // window.opener.execBeforeUnload = false;
    // window.opener.refresh();

    $('#close_button').click(function() {
        window.close();
    });

        
});



