var scrolltop = document.getElementById("ScrollTopButton");

window.onscroll = function () {scrollFunction()};

function scrollFunction()
{
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop >20) {
    scrolltop.style.display = "block";
  }
  else {
    scrolltop.style.display = "none";
  }
};

function topFunction() {
  document.body.scroll({top: 0, left: 0, behavior: 'smooth' });
  document.documentElement.scroll({top: 0, left: 0, behavior: 'smooth' });
};
