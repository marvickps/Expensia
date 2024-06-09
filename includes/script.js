window.addEventListener('scroll', function() {
    var navbar = document.getElementById('navbar');
    var firstHeader = document.querySelector('.firstHeader');

    if (window.scrollY > firstHeader.offsetHeight) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
  });
  