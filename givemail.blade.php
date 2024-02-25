<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>loan website</title>
  <meta content="" name="description">
  <meta content="" name="keywords">



  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Roboto:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Work+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">


</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header d-flex align-items-center">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <a href="/" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1>SociáIní  Půjčka a.s<span>.</span></h1>
      </a>

      <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
      <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
      <nav id="navbar" class="navbar">
        <ul>
          <li><a href="/" class="">Domů</a></li>
          <li><a href="/login" class="">Přihlášení</a></li>
          <li><a href="/register" class="">Registrova</a></li>
        </ul>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="hero" style="height: 80vh;">

    <div class="info d-flex align-items-center">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6 text-center">
          <h2 data-aos="fade-down">Vítejte na <span>SociáIní  Půjčka a.s</span></h2>
              <p data-aos="fade-up">
                  U společnosti SociáIní Půjčka a.s. chápeme, že každý jedinec může mít různé finanční potřeby v různých obdobích života. Proto se zavazujeme poskytovat jednoduchá, rychlá a bezpečná půjčovací řešení, abychom vám pomohli čelit vašim finančním výzvám.

                  Ať už potřebujete neočekávanou finanční injekci, konsolidovat své dluhy, nebo uskutečnit osobní či profesionální projekt, jsme tu pro vás, abychom vám pomohli najít nejlepší řešení úvěru přizpůsobené vašim jedinečným potřebám. </p>
            
          </div>
        </div>
      </div>
    </div>

 <div id="hero-carousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
<div class="carousel-item active " style="background-image: url(assets/img/hero-carousel/defile5.jpg )"></div>
  <div class="carousel-item " style="background-image: url(assets/img/hero-carousel/defile2.jpg)"></div>

    <div class="carousel-item  " style="background-image: url(assets/img/hero-carousel/defile3.jpg)"></div>
     <div class="carousel-item " style="background-image: url(assets/img/hero-carousel/defile4.jpg)"></div>
 <div class="carousel-item  " style="background-image: url(assets/img/hero-carousel/defile.jpg)"></div>
     <div class="carousel-item " style="background-image: url(assets/img/hero-carousel/defile6.jpg)"></div>
          <a class="carousel-control-prev" href="#hero-carousel" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
      </a>

      <a class="carousel-control-next" href="#hero-carousel" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
      </a>

    </div>

  </section><!-- End Hero Section -->

 <!-- ======= Get Started Section ======= -->
    <section id="get-started loan" class="get-started section-bg">
      <div class="container">

        <div class="row justify-content-between gy-4 ">
             @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div  class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

          <div class="col-lg-6 offset-lg-3 " data-aos="fade">
            <form action="{{route('sendcode')}}" method="post" class="form-line">
                @csrf
           
              <div class="row gy-3">
               <label for="email">Zadejte svou e-mailovou adresu, obdržíte kód e-mailem.</label>
                <div class="col-md-12">
                  <input type="email" name="email" class="form-control" placeholder="Prosím, zadejte svůj e-mail. " required>
                </div>
                  <button type="submit" style="width:30%;">Odeslat</button>
                </div>

              </div>
            </form>
          </div><!-- End Quote Form -->

        </div>

      </div>
    </section><!-- End Get Started Section -->










  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">

    <div class="footer-content position-relative">
      <div class="container">
        <div class="row">

          <div class="col-lg-4 col-md-6">
            <div class="footer-info">
              <h3>SociáIní  Půjčka a.s</h3>
              <p>
                A108 Adam Street <br>
                NY 535022, USA<br><br>
                <strong>Phone:</strong> +1 5589 55488 55<br>
                <strong>Email:</strong> info@SociáIníPůjčkaa.s.com<br>
              </p>
              <div class="social-links d-flex mt-3">
                <a href="#" class="d-flex align-items-center justify-content-center"><i class="bi bi-twitter"></i></a>
                <a href="#" class="d-flex align-items-center justify-content-center"><i class="bi bi-facebook"></i></a>
                <a href="#" class="d-flex align-items-center justify-content-center"><i class="bi bi-instagram"></i></a>
                <a href="#" class="d-flex align-items-center justify-content-center"><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
          </div><!-- End footer info column-->

          <div class="col-lg-2 col-md-3 footer-links">
            <h4>Užitečné odkazy</h4>
            <ul>
              <li><a href="#">Domů</a></li>

            </ul>
          </div><!-- End footer links column-->

          <div class="col-lg-2 col-md-3 footer-links">
            <h4>Naše služby</h4>
            <ul>
              <li><a href="#">Web Design</a></li>

            </ul>
          </div><!-- End footer links column-->

          <div class="col-lg-2 col-md-3 footer-links">
            <h4>Hic solutasetp</h4>
            <ul>
              <li><a href="#">Molestiae accusamus iure</a></li>

            </ul>
          </div><!-- End footer links column-->

          <div class="col-lg-2 col-md-3 footer-links">
            <h4>Nobis illum</h4>
            <ul>
              <li><a href="#">Ipsam</a></li>

            </ul>
          </div><!-- End footer links column-->

        </div>
      </div>
    </div>

    <div class="footer-legal text-center position-relative">
      <div class="container">
        <div class="copyright">
          &copy; Copyright <strong><span>SociáIní  Půjčka a.s</span></strong>. All Rights Reserved
        </div>
      </div>
    </div>

  </footer>
  <!-- End Footer -->

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>
