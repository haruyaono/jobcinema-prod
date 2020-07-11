(function( $ ) {
'use strict';

    $.fn.setBaseImageUrlAndSetEnvName = function(){

        var array = [];

        if($('#env_name').length) {
            var env_name = $('#env_name').attr('value');
            if(env_name == 'production') {
                var base_image_url = 'https://s3.job-cinema.com';
            } else {
                var base_image_url = '';
            }
        } else {
            var base_image_url = '';
            var env_name = '';
        }

        array = {
            base_image_url : base_image_url,
            env_name : env_name
        }

        return array;
    }

})( jQuery );