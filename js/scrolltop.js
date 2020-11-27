$(document).ready(function(){
//Get the button:
//var mybutton = $("#ScrollTopButton");

// When the user scrolls down 20px from the top of the document, show the button
$(function()  {
  $(window).scroll(function() {
    if ($(window).scrollTop() > 20)
    {
      $("#ScrollTopButton").show();
    }
    else
    {
      $("#ScrollTopButton").hide();
    }
  });

  $("#ScrollTopButton").click(function()  {
    $('body').animate({scrollTop: 0}, 800);
  });
});
});
