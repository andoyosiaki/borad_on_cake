$(function(){

  $('.ProfileEditTrigger').on('click',function(){
    $('.ProfileEditBox').fadeToggle();
  });

  $('.slider').slick({
    arrows:true,
    dots:true,
    infinite: true,
    slidesToShow: 4,
    slidesToScroll:4
  });

  $('.slider-5-thum').slick({
  arrows:true,
  asNavFor:'.slider-5-nav',
  });
  $('.slider-5-nav').slick({
  asNavFor:'.slider-5-thum',
  focusOnSelect: true,
  slidesToShow:4,
  slidesToScroll:1,
  dots: true,
  arrows:false,
  });

  $(function(){
    setTimeout("$('.message').fadeOut()", 4000)
  })

  $(document).click(function(event) {
    if(!$(event.target).closest('#HowToPostYoutubeTrigger').length) {
      $('.HowToPostYoutubeBox').fadeOut();
    } else {
      $('.HowToPostYoutubeBox').fadeIn();
    }
  });

  $('#SerchFormTrigger').on('click',function(){
    $('.TweetPostSection_SerchWrap').fadeToggle();
  });

});
