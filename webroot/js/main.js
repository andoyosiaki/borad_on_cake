$(function(){

  // $(document).click(function(event) {
  //   if(!$(event.target).closest('.ProfileEditTrigger,.ProfileEditBox').length) {
  //     $('.ProfileEditBox').fadeOut();
  //   } else {
  //     $('.ProfileEditBox').fadeIn();
  //   }
  // });
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

});
