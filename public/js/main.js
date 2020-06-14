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

        var statusVal = $('#search-status').val() != '' ? Number($('#search-status').val()) : null,
            typeVal = $('#search-type').val() != '' ? Number($('#search-type').val()) : null,
            areaVal = $('#search-area').val() != '' ? Number($('#search-area').val()) : null,
            hourlySalaryVal = $('#search-hourly-salary').val() != '' ? Number($('#search-hourly-salary').val()) : null,
            dateVal = $('#search-date').val() != '' ? Number($('#search-date').val()) : null,
            textVal = $('#search-text').val() != '' ? Number($('#search-text').val()) : null;

        
        var searchParam = {
            "status_cat_id" : statusVal,
            "type_cat_id" : typeVal,
            "area_cat_id" : areaVal,
            "hourly_salary_cat_id" : hourlySalaryVal,
            "date_cat_id" : dateVal,
            "title" : textVal
        }
        console.log(JSON.stringify(searchParam));
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });
        $.ajax({
            type: 'post',
            contentType: 'application/json',
            url: 'http://localhost/search/SearchJobItemAjaxAction',
            cache: false,
            data: JSON.stringify(searchParam),
            dataType: 'json',
            timeout: 3000
        })
        .done(function (res, textStatus,jqXHR) {
                $('#job-count').text(res);
                console.log(jqXHR.status);
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log("通信に失敗しました");
            console.log(jqXHR.status);
            console.log(textStatus);
            console.log(errorThrown);
        }).always(function(){
		});
    

    });


    // window.opener.execBeforeUnload = false;
    // window.opener.refresh();

    $('#close_button').click(function() {
        window.close();
    });

    function submitAction(url) {
        $('form').attr('action', url);
        $('form').submit();
    };
        
});



