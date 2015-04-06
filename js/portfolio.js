/**
 * frontend.london portfolio.js
 * Created by Piotr Kołodziejczyk on 01.02.15.
 */

$(document).ready(function () {
  'use strict';

  var isMobileView = function () {
    return $(window).width() < 752;
  }

  var activeSlide = 1;

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

  $('body').scrollspy({ target: '.scrollspy' })


  var swapSlide = function (number) {
    $('.thumbs').hide();
    $('#thumbs-' + number).fadeIn();
    $('.slides a').removeClass('active');
    $('#slide-' + number).addClass('active');
    $(this).addClass('active');
    activeSlide = number;
  };

  $('#slide-1').click(function (event) {
    event.preventDefault();
    swapSlide('1');
  });

  $('#slide-2').click(function (event) {
    event.preventDefault();
    swapSlide('2');
  });

  $('#slide-3').click(function (event) {
    event.preventDefault();
    swapSlide('3');
  });

  $('.arrow-right').click(function (event) {
    event.preventDefault();
    if (activeSlide < 3) {
      activeSlide++;
    } else {
      activeSlide = 1;
    }
    $('#slide-' + activeSlide).click();
  });

  $('.arrow-left').click(function (event) {
    event.preventDefault();
    if (activeSlide > 1) {
      activeSlide--;
    } else {
      activeSlide = 3;
    }
    $('#slide-' + activeSlide).click();
  });

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

  $('.icon, .mobilenav').click(function () {
    $('.mobilenav').fadeToggle(500);
    $('.top-menu').toggleClass('top-animate');
    $('.mid-menu').toggleClass('mid-animate');
    $('.bottom-menu').toggleClass('bottom-animate');
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
});
