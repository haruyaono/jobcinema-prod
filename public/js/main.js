'use strict';

if(document.getElementById("start_specified_date") && document.getElementById("end_specified_date")) {

    var start_specified_date = document.getElementById("start_specified_date"),
        end_specified_date = document.getElementById("end_specified_date")

    if(start_specified_date.value == false) {
        start_specified_date.disabled = true;
    } else {
        start_specified_date.disabled = false;
    }
    if(end_specified_date.value == false) {
        end_specified_date.disabled = true;
    } else {
        end_specified_date.disabled = false;
    }

    function pubstartflg0(ischecked){
        if(ischecked == true){
            start_specified_date.disabled = true;
            start_specified_date.value = "";
        } else {
            start_specified_date.disabled = false;
        }
    }

    function pubstartflg1(ischecked){
        if(ischecked == true){
            start_specified_date.disabled = false;
        } else {
            start_specified_date.disabled = true;
        }
    }

    function pubendflg0(ischecked){
        if(ischecked == true){
            end_specified_date.disabled = true;
            end_specified_date.value = "";
        } else {
            end_specified_date.disabled = false;
        }
    }

    function pubendflg1(ischecked){
        if(ischecked == true){
            end_specified_date.disabled = false;
        } else {
            end_specified_date.disabled = true;
        }
    }
}


window.onpageshow = function(event) {
    if (event.persisted) {
            window.location.reload();
    }
};

const app = new Vue({
    el: '#app',
    data: {
        typedText1: '',
        typedText2: '',
        typedText3: '',
        typedText4: '',
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
    }
});



$(function() {

    $(".tab_label").on("click",function(){
        var $th = $(this).index();
        $(".tab_label").removeClass("active");
        $(".tab_panel").removeClass("active");
        $(this).addClass("active");
        $(".tab_panel").eq($th).addClass("active");
    });

    $('#composite-form').change(function(){
        
        var status_val = 0
            type_val = 0,
            area_val = 0,
            hourly_salary_val = 0,
            date_val = 0,
            text_val = ''

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
            function () {
                alert("通信に失敗しました");
    
        });

    });


    // window.opener.execBeforeUnload = false;
    // window.opener.refresh();

    $('#close_button').click(function() {
        window.close();
    });

        
});



