<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Municipality of Cuyapo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ URL::to('assets/css/homepage.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-primary border-bottom border-body sticky-top px-4" data-bs-theme="dark">
        <div class="container-fluid d-flex align-self-center">
                <a class="navbar-brand" href="#"><img class="rounded-pill" src="img/logo.png" alt=""></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item mx-2">
                            <a class="nav-link active" href="#banner">Home</a>
                          </li>
                          <li class="nav-item mx-2">
                            <a class="nav-link active" href="#vision-mission">Vision/Mission</a>
                          </li>
                          <li class="nav-item mx-2">
                            <a class="nav-link active" href="#history">History</a>
                          </li>
                          <li class="nav-item mx-2">
                            <a class="nav-link active" href="#contact">Contact</a>
                          </li>
                          <li class="nav-item mx-2">
                            <a class="nav-link active" aria-current="page" href="login.html">Login</a>
                          </li>

                    </ul>
                  </div>
            </div>
    </nav>
    <section data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true" class="scrollspy-example bg-body-tertiary" tabindex="0">
    <div id="banner"> 
      <div id="carouselExampleDark" class="carousel slide">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active" data-bs-interval="10000">
            <img src="img/banner.jpg" class="d-block w-100" alt="...">
            <div class="carousel-caption">
              <h5>First slide label</h5>
              <p>Some representative placeholder content for the first slide.</p>
              <p><a href="#">Learn More</a></p>
            </div>
          </div>
          <div class="carousel-item" data-bs-interval="2000">
            <img src="img/banner1.jpg" class="d-block w-100" alt="...">
            <div class="carousel-caption">
              <h5>Second slide label</h5>
              <p>Some representative placeholder content for the second slide.</p>
              <p><a href="#">Learn More</a></p>
            </div>
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>
    <div id="vision-mission" class="section-p1"> 
        <div class="row">
            <div class="col-sm-6 mb-3 mb-sm-0">
              <div class="card">
                <div class="card-body">
                <i class="fa-regular fa-eye d-flex justify-content-center my-4"></i>
                  <h3 class="card-title text-center lh-base">Our Vision</h3>
                  <p class="card-text text-center lh-base my-4">Cuyapo is a premier agro-eco-tourism hub of Nueva Ecija, with God loving and empowered community, living in a well planned environment with progressive economy, governed by responsible leaders.</p>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="card">
                <div class="card-body">
                    <i class="fa-solid fa-flag d-flex justify-content-center my-4"></i>
                  <h3 class="card-title text-center lh-base">Our Mission</h3>
                  <p class="card-text text-center lh-base my-4">To effectively address the desire and needs of people by educating and empowering them through geniune public service and responsible local governance.</p>
                </div>
              </div>
            </div>
          </div>
    </div>
    <div id="history" class="section-p1">
        <h2 class="text-center">History</h2>
        <div class="history-card bg-primary">
            <div class="container">
                    <div class="row">
                        <div class="col-md-8 p-4">
                            <h2 class="text-white mb-4">Cuyapo</h2>
                            <h4 class="text-white lh-base text-justify">The name "Cuyapo" is derived from the Pangasinan word "kuyapo," referring to the aquatic plant Pistia stratiotes, known in Tagalog as "kiapo" or "quiapo." This plant was abundant in areas near present-day Rizal Street, close to the municipal cemetery. Early settlers included Pangasinenses from Paniqui, Tarlac; Ilocanos from Ilocos Sur and Ilocos Norte; and Tagalogs from Bulacan and southern Nueva Ecija. Many Ilocanos migrated to escape forced labor during the construction of the Catholic Church in Santa Maria, Ilocos Sur. </h4>
                        </div>
                    <div class="col-md-4 p-4">
                        <img src="img/logo.png" alt="">
                    </div>
                    </div>
                </div>
            </div>
    </div>
    <div id="contact" class="section-p1">
      <div class="container">
        <div class="row">
          <div class="col">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3839.478340044522!2d120.66396705000001!3d15.778712100000005!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33913100c36ddd2b%3A0x8076c80ea4eae5c9!2sCuyapo%20Town%20Hall%2C%20Cuyapo%2C%203117%20Nueva%20Ecija!5e0!3m2!1sen!2sph!4v1740123011386!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
          <div class="col">
              <p>Get In Touch</p>
              <h3 class="mb-4">Visit our municapal hall location or contact us today</h3>
              <h5 class="mb-1">Municipal Government of Cuyapo, Nueva Ecija</h5>
                <div class="d-flex flex-row my-4">
                  <i class="fa-solid fa-location-dot me-2"></i>
                  <p class="my-0">Cuyapo Town Hall, Cuyapo, 3117 Nueva Ecija</p>
                </div>
              <div class="d-flex flex-row my-4">
                <i class="fa-solid fa-envelope me-2"></i>
                <p class="my-0">cuyapo.nuevaecija@yahoo.com/lgucuyapo2016@gmail.com</p>
              </div>
              <div class="d-flex flex-row my-4">
                <i class="fa-solid fa-phone me-2"></i>
                <p class="my-0">951-55-97</p>
              </div>
              <div class="d-flex flex-row my-4">
                <i class="fa-solid fa-clock me-2"></i>
                <p class="my-0">Monday to Friday: 8am - 5pm</p>
              </div>
                
          </div>
        </div>
      </div>
    </div>
    <div class="b-divider"></div>
    
    <section id="footer">
      <div class="container">
        <footer class="py-5">
          <div class="row">
            <div class="col-6 col-md-2 mb-3">
              <h5>Section</h5>
              <ul class="nav flex-column">
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-light">Home</a></li>
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-light">Features</a></li>
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-light">Pricing</a></li>
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-light">FAQs</a></li>
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-light">About</a></li>
              </ul>
            </div>
      
            <div class="col-6 col-md-2 mb-3">
              <h5>Section</h5>
              <ul class="nav flex-column">
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-light">Home</a></li>
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-light">Features</a></li>
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-light">Pricing</a></li>
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-light">FAQs</a></li>
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-light">About</a></li>
              </ul>
            </div>
      
            <div class="col-6 col-md-2 mb-3">
              <h5>Section</h5>
              <ul class="nav flex-column">
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-light">Home</a></li>
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-light">Features</a></li>
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-light">Pricing</a></li>
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-light">FAQs</a></li>
                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-light">About</a></li>
              </ul>
            </div>
      
            <div class="col-md-5 offset-md-1 mb-3">
              <form>
                <h5>Subscribe to our newsletter</h5>
                <p>Monthly digest of what's new and exciting from us.</p>
                <div class="d-flex flex-column flex-sm-row w-100 gap-2">
                  <label for="newsletter1" class="visually-hidden">Email address</label>
                  <input id="newsletter1" type="text" class="form-control" placeholder="Email address">
                  <button class="btn btn-danger" type="button">Subscribe</button>
                </div>
              </form>
            </div>
          </div>
      
          <div class="d-flex flex-column flex-sm-row justify-content-between py-2 my-2 border-top">
            <p>© 2025 TEAM CUYAPO OLSHCO STUDENT INTERNS. All rights reserved.</p>
            <ul class="list-unstyled d-flex">
              <li class="ms-3"><a class="link-body-emphasis" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#twitter"></use></svg></a></li>
              <li class="ms-3"><a class="link-body-emphasis" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#instagram"></use></svg></a></li>
              <li class="ms-3"><a class="link-body-emphasis" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#facebook"></use></svg></a></li>
            </ul>
          </div>
        </footer>
      </div>
    </section>
    </section>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
      const navLinks = document.querySelectorAll(".nav-link");
      const navbarToggler = document.querySelector(".navbar-toggler");
      const navbarCollapse = document.querySelector(".navbar-collapse");

      navLinks.forEach(link => {
          link.addEventListener("click", function () {
              if (navbarCollapse.classList.contains("show")) {
                  navbarToggler.click();
              }
          });
      });
  });
</script>


</html>