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
  <link
    href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Roboto:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Work+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet">

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

      <a href="/welcome" class="logo d-flex align-items-center">
       <h1 style=" text-transform:uppercase;">SociáIní Půjčka</h1><span style="color: white; padding-left:11px;"> a.s</span><span>.</span>

      </a>

      <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
      <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
      <nav id="navbar" class="navbar">
        <ul>
          <li><a href="/welcome" class="active">Domů</a></li>
          <li><a href="/mes-demandes">Poptávky</a></li>
          <li><a href="{{ route('deconnexion') }}">Odhlásit se</a></li>
        </ul>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <div class="breadcrumbs d-flex align-items-center" style="background-image: url('assets/img/defile5.jpg');">
      <div class="container position-relative d-flex flex-column align-items-center" data-aos="fade">

        <h2>Poptávky</h2>
        <ol>
          <li><a href="/">Domů</a></li>
          <li>Moje žádosti</li>
        </ol>

      </div>
    </div><!-- End Breadcrumbs -->
<!-- ======= Services Section ======= -->
<section id="services" class="services section-bg">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="container" data-aos="fade-up">
        <div class="row gy-4">
            @forelse($demandes as $demande)
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                    <div class="service-item position-relative">
                        <h2 style="border-bottom: 4px solid #ebebed; font-weight: 700; margin: 0 0 20px 0; padding-bottom: 8px; font-size: 22px;">   Titul: {{ $demande->projet }}</h2></h2>
                        <p>{{ $demande->description }}</p>

                        @if($demande->statut == 'pending')
                            <div style="display:flex; flex-direction: row;">
                                <button class="btn readmore" style="color:white; background-color:darkblue;  border: 1px solid darkblue; margin-right: 2%;">Čekající</button>
                                <form action="{{ route('reject_client_demande', ['id_demande' => $demande->id]) }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn bg-danger btn readmore" style="color: white;">Odmítnout</button>
                                </form>
                            </div>
                        @elseif($demande->statut == 'valide')
                            <button class="btn readmore stretched-link" style="color:white; background-color:forestgreen; border: 1px solid forestgreen;">Ověřit</button>
                            @if($demande->montant_restant > 0 )
                                <button class="btn readmore stretched-link" style="color:white; background-color:darkblue; border: 1px solid forestgreen;">Zůstaňte:
 {{ $demande->montant_restant }} Kč</button>
                            @elseif($demande->montant_restant <0 || $demande->montant_restant==0 )
                                <button class="btn readmore stretched-link" style="color:white; background-color:crimson; border: 1px solid crimson;">sleva</button>
                            @endif
                        @elseif($demande->statut == 'rejeter')
                            <!-- Le bouton "Rejeter" ici ne semble pas être associé à une action ou à une logique particulière -->
                            <button type="button" class="btn bg-danger stretched-link" style="color: white;">Odmítnout</button>
                        @endif
                    </div>
                </div><!-- End Service Item -->
            @empty
                <!-- Afficher un message lorsque la liste des demandes est vide -->
                <div class="col-lg-12 text-center">
                    <div class="service-item position-relative">
                       <p>Aktuálně nejsou žádné žádosti.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section><!-- End Services Section -->


  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">

        <div class="footer-content position-relative">
            <div class="container">
                <div class="row">

                    <div class="col-lg-4 col-md-6">
                        <div class="footer-info">
                           <div style="display: flex; flex-direction: rows;"> <h3>SociáIní Půjčka </h3> <span style="margin:1%;">a.s</span></div>
                            <p>
                                Dominikánské nám. 196/1 <br>
                                602 00 Brno<br><br>
                                Czech Republic

                            </p>
                            <div class="social-links d-flex mt-3">
                                <a href="#" class="d-flex align-items-center justify-content-center"><i
                                        class="bi bi-twitter"></i></a>
                                <a href="#" class="d-flex align-items-center justify-content-center"><i
                                        class="bi bi-facebook"></i></a>
                                <a href="#" class="d-flex align-items-center justify-content-center"><i
                                        class="bi bi-instagram"></i></a>
                                <a href="#" class="d-flex align-items-center justify-content-center"><i
                                        class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                    </div><!-- End footer info column-->

                    <div class="col-lg-2 col-md-3 footer-links">
                        <h4>Useful Links</h4>
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
                    &copy; Copyright <strong><span>SociáIní Půjčka a.s.</span></strong>. All Rights Reserved
                </div>
            </div>
        </div>

    </footer>
  <!-- End Footer -->


  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/form-line/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>
