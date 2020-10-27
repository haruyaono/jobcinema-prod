(function ($) {
    'use strict';

    $.fn.setBaseImageUrlAndSetEnvName = function () {

        var array = [];

        if ($('#env_name').length) {
            var env_name = $('#env_name').attr('value');
            if (env_name == 'production') {
                var base_image_url = 'https://s3.job-cinema.com/img/uploads/JobSheet/';
            } else {
                var base_image_url = 'https://job-cinema-dev.s3-ap-northeast-1.amazonaws.com/img/uploads/JobSheet/';
            }
        } else {
            var base_image_url = '';
            var env_name = '';
        }

        array = {
            base_image_url: base_image_url,
            env_name: env_name
        }

        return array;
    }

    $.fn.setBaseMovieUrlAndSetEnvName = function () {

        var array = [];

        if ($('#env_name').length) {
            var env_name = $('#env_name').attr('value');
            if (env_name == 'production') {
                var base_movie_url = 'https://s3.job-cinema.com/mov/uploads/JobSheet/';
            } else {
                var base_movie_url = 'https://job-cinema-dev.s3-ap-northeast-1.amazonaws.com/mov/uploads/JobSheet/';
            }
        } else {
            var base_movie_url = '';
            var env_name = '';
        }

        array = {
            base_movie_url: base_movie_url,
            env_name: env_name
        }

        return array;
    }

})(jQuery);
