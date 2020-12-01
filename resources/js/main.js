$(function () {

  (function () {
    const topBtn = $('.to-top');
    let isSp = false,
      isDetali = topBtn.hasClass('isDetail'),
      displayFlag = false;

    detailFollowingArea = $('#js-detailFollowingArea');

    topBtn.hide();
    detailFollowingArea.hide();

    topBtn.click(function () {
      $('body,html').animate({
        scrollTop: 0
      }, 200);
      return false;
    });

    // 画面下位置を取得
    let bottomPos = $(document).height() - $(window).height() - 500;
    $(window).scroll(function () {
      if ($(this).scrollTop() >= bottomPos) {
        if (displayFlag == true) {
          displayFlag = false;
        }
      } else {
        if (!displayFlag) {
          displayFlag = true;
        }
      }
    });

    $(window).on('load resize', function () {
      let windowWidth = $(window).width();
      if (windowWidth >= 768) {
        isSp = false;
      } else {
        isSp = true;
      }

      $(window).scroll(function () {

        if ($(this).scrollTop() > 500) {
          if (isDetali && isSp) {
            topBtn.fadeOut();
          } else {
            topBtn.fadeIn();
          }
        } else {
          topBtn.fadeOut();
        }

        if ($(this).scrollTop() > 300) {
          if (displayFlag) {
            detailFollowingArea.fadeIn();
          } else {
            detailFollowingArea.fadeOut();
          }
        } else {
          detailFollowingArea.fadeOut();
        }
      });
    });

  })();

  let t = 200;
  let $element = $('#js-favorite-fixed-nav');
  let isTransform = typeof $('body').css('transform') === 'string';

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

  // 求人詳細の画像スライダー
  if ($('.job-detail-image-slider-container').length) {
    let imageSliderSelector = '.job-detail-image-slider-container',
      options = {
        init: false,
        loop: true,
        speed: 800,
        spaceBetween: 10,
        pagination: {
          el: '.swiper-pagination',
          clickable: true
        },
        on: {
        }
      },
      jobDetailImageSwiper = new Swiper(imageSliderSelector, options);

    jobDetailImageSwiper.init();
  }

  if ($('.job-detail-movie-slider-container').length) {

    // 求人詳細の動画スライダー
    let sliderSelector = '.job-detail-movie-slider-container',
      isMove = false,
      options = {
        init: false,
        // loop: true,
        speed: 800,
        // autoplay: {
        //   delay: 3000
        // },
        effect: 'cube', // 'cube', 'fade', 'coverflow',
        cubeEffect: {
          shadow: true,
          slideShadows: true,
          shadowOffset: 40,
          shadowScale: 0.94,
        },
        grabCursor: true,
        pagination: {
          el: '.swiper-pagination',
          clickable: true
        },
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev'
        },
        // Events
        on: {
          init: function () {
            this.autoplay.stop();
          },
          touchMove: function (event) {
            if (!isMove) {
              this.el.classList.remove('scale-in');
              this.el.classList.add('scale-out');
              isMove = true;
            }
          },
          touchEnd: function (event) {
            this.el.classList.remove('scale-out');
            this.el.classList.add('scale-in');
            setTimeout(function () {
              isMove = false;
            }, 300);
          },
          slideChangeTransitionStart: function () {
            console.log('slideChangeTransitionStart ' + this.activeIndex);
            if (!isMove) {
              this.el.classList.remove('scale-in');
              this.el.classList.add('scale-out');
            }
          },
          slideChangeTransitionEnd: function () {
            console.log('slideChangeTransitionEnd ' + this.activeIndex);
            if (!isMove) {
              this.el.classList.remove('scale-out');
              this.el.classList.add('scale-in');
            }
          },
          transitionStart: function () {
            console.log('transitionStart ' + this.activeIndex);
          },
          transitionEnd: function () {
            console.log('transitionEnd ' + this.activeIndex);
          },
          slideChange: function () {
            console.log('slideChange ' + this.activeIndex);
            console.log(this);
          }
        }
      },
      mySwiper = new Swiper(sliderSelector, options);

    // Initialize slider
    mySwiper.init();
  }

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

