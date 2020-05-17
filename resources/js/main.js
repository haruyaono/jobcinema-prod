$(function() {
  var topBtn = $('.to-top');
  //ボタンを非表示にする
  topBtn.hide();
  //スクロールしてページトップから100に達したらボタンを表示
  $(window).scroll(function () {
      if ($(this).scrollTop() > 500) {
        //フェードインで表示
          topBtn.fadeIn();
      } else {
      //フェードアウトで非表示
          topBtn.fadeOut();
      }
  });
  //スクロールしてトップへ戻る
  topBtn.click(function () {
      $('body,html').animate({
          scrollTop: 0
      }, 200);
      return false;
  });

  var t = 200;
    var $element = $('#js-favorite-fixed-nav');
    var isTransform  = typeof $('body').css('transform') === 'string';

    if (isTransform) {
        $element.show();
    }

    $(window).scroll(function() {
      st = $(window).scrollTop();
      if (st > t) {
        isTransform ? $element.addClass('is-nav-show') : $element.show();
      } else {
        isTransform ? $element.removeClass('is-nav-show') : $element.hide();
      }
    });

});

(function ($, window, undefined) {
  'use strict';
  jQuery(function ($) {
    $('.fullHeaderMenu, .prefectureTopHeaderMenu, .fullHeaderNoShadowMenu').click(function (t) {
      if ($('.hamburgerLogin').length) {
        $('.hamburgerLoginlayer').addClass('on');
      } else if ($('.hamburgerLogout').length) {
        $('.hamburgerLogoutlayer').addClass('on');
      } else if ($('.hamburgerUnknow').length) {
        $('.hamburgerUnknowlayer').addClass('on');
      }
      $('.hamburgerLoginlayer, .hamburgerLogoutlayer, .hamburgerUnknowlayer').css("height", $(document).height());
      $('.hamburgerLoginWrap, .hamburgerLogoutWrap, .hamburgerUnknowWrap').css("top", $(document).scrollTop());
    });
    $('.hamburgerLoginHeaderClossInner').click(function (t) {
      t.preventDefault();
      $('.hamburgerLoginlayer').removeClass('on');
    });
    $('.hamburgerLogoutHeaderClossInner').click(function (t) {
      t.preventDefault();
      $('.hamburgerLogoutlayer').removeClass('on');
    });
    $('.hamburgerUnknowHeaderClossInner').click(function (t) {
      t.preventDefault();
      $('.hamburgerUnknowlayer').removeClass('on');
    });
    $('.hamburgerLoginlayer').click(function (t) {
      t.preventDefault();
      $('.hamburgerLoginlayer').removeClass('on');
    });
    $('.hamburgerLoginInner').click(function (t) {
      t.stopPropagation();
    });
    $('.hamburgerLogoutlayer').click(function (t) {
      t.preventDefault();
      $('.hamburgerLogoutlayer').removeClass('on');
    });
    $('.hamburgerLogoutInner').click(function (t) {
      t.stopPropagation();
    });
    $('.hamburgerUnknowlayer').click(function (t) {
      t.preventDefault();
      $('.hamburgerUnknowlayer').removeClass('on');
    });
    $('.hamburgerUnknowInner').click(function (t) {
      t.stopPropagation();
    });
  });
})(jQuery, window);

