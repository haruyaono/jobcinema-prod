$(function () {

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
  var isTransform = typeof $('body').css('transform') === 'string';

  if (isTransform) {
    $element.show();
  }

  $(window).scroll(function () {
    st = $(window).scrollTop();
    if (st > t) {
      isTransform ? $element.addClass('is-nav-show') : $element.show();
    } else {
      isTransform ? $element.removeClass('is-nav-show') : $element.hide();
    }
  });

});
