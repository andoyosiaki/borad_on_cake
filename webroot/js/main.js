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

  $(document).click(function(event) {
    if(!$(event.target).closest('#SerchFormTrigger,.TweetPostSection_SerchBox').length) {
      $('.TweetPostSection_SerchWrap').fadeOut();
    } else {
      $('.TweetPostSection_SerchWrap').fadeIn();
    }
  });

});
