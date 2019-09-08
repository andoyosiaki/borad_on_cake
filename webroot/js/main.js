$(function(){
  $('.ProfileEditTrigger').on('click',function(){
    $('.ProfileEditBox').fadeToggle();
  });

  $('.slider').slick({
    arrows:true,
    dots:true,
    infinite: true,
    slidesToShow: 4,
    slidesToScroll:1
  });

});
