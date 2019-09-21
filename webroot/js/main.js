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
