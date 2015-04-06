/**
 * frontend.london js/portfolio.js
 * Created by Piotr Kołodziejczyk on 01.02.15.
 */

$(document).ready(function () {
  'use strict';

  var isMobileView = function () {
    return $(window).width() < 752;
  }

  var portfolioSlide = 1;

  /*  GLOBAL
      NAVIGATION
  */
  /* scroll event */
  $('.nav-top li a, .scroll-down, .scroll-up, .mobilenav a').click(function (event) {
    event.preventDefault();
    var id = $(this).attr('href');
    var position = $(id).offset().top;
    if (isMobileView()) {
      position += 96;
    }
    $('html,body').animate({ scrollTop: position },
      'slow');
  });

  /* active menu class */
  $('body').scrollspy({ target: '.scrollspy' })

  /* mobile menu */
  $('.icon, .mobilenav').click(function () {
    $('.mobilenav').fadeToggle(500);
    $('.top-menu').toggleClass('top-animate');
    $('.mid-menu').toggleClass('mid-animate');
    $('.bottom-menu').toggleClass('bottom-animate');
  });


  /*
  PAGE PORTFOLIO
   */

  var swapPortfolioSlide = function (number) {
    $('.thumbs').hide();
    $('#thumbs-' + number).fadeIn();
    $('.slides a').removeClass('active');
    $('#portfolio-slide-' + number).addClass('active');
    $(this).addClass('active');
    portfolioSlide = number;
  };

  $('#portfolio-slide-1').click(function (event) {
    event.preventDefault();
    swapPortfolioSlide('1');
  });

  $('#portfolio-slide-2').click(function (event) {
    event.preventDefault();
    swapPortfolioSlide('2');
  });

  $('#portfolio-slide-3').click(function (event) {
    event.preventDefault();
    swapPortfolioSlide('3');
  });

  $('.arrow-right').click(function (event) {
    event.preventDefault();
    if (portfolioSlide < 3) {
      portfolioSlide++;
    } else {
      portfolioSlide = 1;
    }
    $('#portfolio-slide-' + portfolioSlide).click();
  });

  $('.arrow-left').click(function (event) {
    event.preventDefault();
    if (portfolioSlide > 1) {
      portfolioSlide--;
    } else {
      portfolioSlide = 3;
    }
    $('#portfolio-slide-' + portfolioSlide).click();
  });

  $('.thumbs a').fancybox({
    afterLoad: function () {
      this.title += '<a href="#" title="' + this.title + '" class="see-details">see details</a>';
    },
    nextEffect: 'none',
    prevEffect: 'none',
    padding: 0,
    helpers: {
      title: {
        type: 'inside',
        position: 'top'
      },
      thumbs: {
        width: 100,
        height: 100
      }
    }
  });

  $('body').on('click', '.see-details', function (event) {
    var details,
      seeText = 'see details',
      hideText = 'hide details';
    event.preventDefault();

    if ($(this).text() == seeText) {
      details = $('#site-details > [title="' + this.title + '"]').clone().removeAttr('id').addClass('site-details');
      $('.fancybox-inner').append(details);
      $(this).text(hideText);
    } else {
      $('.fancybox-inner').find('.site-details').hide().remove();
      $(this).text(seeText);
    }
  });

  /*
  PAGE CONTACT
   */

  /* send message on contact page */
  $('#form-submit').click(function (event) {
    event.preventDefault();
    $(this).addClass('disabled').text('Sent !');

    $.ajax({
      method: 'POST',
      url: 'message.php',
      data: {
        title: $('#field-title').val(),
        message: $('#field-message').val(),
        email: $('#field-email').val(),
        name: $('#field-name').val()
      }
    });
  });
});
