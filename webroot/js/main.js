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
    if(!$(event.target).closest('#SerchFormTrigger,.FormLabel').length) {
      $('.TweetPostSection_SerchWrap').fadeOut();
    } else {
      $('.TweetPostSection_SerchWrap').fadeIn();
    }
  });

  // $('#SerchFormTrigger,.TweetPostSection_SerchBox').on('click',function(){
  //   $('.TweetPostSection_SerchWrap').fadeToggle();
  // });


  var userAgent = window.navigator.userAgent.toLowerCase();

  if(userAgent.indexOf('iphone') != -1) {
      $('.ProfileEditTrigger').on('click',function(){
        $('.ProfileEditBox').fadeToggle();
      });
  } else if(userAgent.indexOf('ipad') != -1) {
      $('.ProfileEditTrigger').on('click',function(){
        $('.ProfileEditBox').fadeToggle();
      });
  } else if(userAgent.indexOf('android') != -1) {
      if(userAgent.indexOf('mobile') != -1) {
          $('.ProfileEditTrigger').on('click',function(){
            $('.ProfileEditBox').fadeToggle();
          });
      } else {
          $('.ProfileEditTrigger').on('click',function(){
            $('.ProfileEditBox').fadeToggle();
          });
      }
  }


});
