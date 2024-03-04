<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Votre espace d'administration</title>
  <meta content="" name="description">
  <meta content="" name="keywords">


  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets-admin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets-admin/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets-admin/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets-admin/vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ asset('assets-admin/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
  <link href="{{ asset('assets-admin/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('assets-admin/vendor/simple-datatables/style.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
<link href="{{ asset('assets-admin/css/style.css') }}" rel="stylesheet">
<link href="{{ asset('assets-admin/css/main.css') }}" rel="stylesheet">
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="/dashboard" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">GestAdmin</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

     <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->





        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="assets-admin/img/profile-img.jpg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2" style="color: white;">@if (Session::has('prenom')){{ Session::get('prenom') }} @endif</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
             <h6> @if (Session::has('prenom')){{ Session::get('prenom') }} @endif</h6>

            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="/profile">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="/profile">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ route('deconnexion/admin') }}" style="color: black;">
                <i class="bi bi-box-arrow-right"></i>
                <span >Deconnecter</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="/dashboard">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

    <li class="nav-item">
        <a class="nav-link collapsed" href="/valider">
             <i class="bi bi-card-list"></i>
          <span>Valider des demandes</span>
        </a>
      </li><!-- End Register Page Nav -->

     <!-- End Register Page Nav -->
  <li class="nav-item">
        <a class="nav-link collapsed" href="/update-loane">
         <i class="bi bi-pencil-square"></i>
          <span>Mettre à jour dette</span>
        </a>
      </li>

       <li class="nav-item">
        <a class="nav-link collapsed" href="/profile">
          <i class="bi bi-person-fill"></i>
          <span>Profile</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed"  href="{{ route('deconnexion/admin') }}" style="color: black;">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Deconnecter</span>
        </a>
      </li><!-- End Login Page Nav -->




    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">
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
  <section class="section" style=" border-radius: 20px;  ">
      <div class="row">
        <div class="col-lg-12">

          <div class="card" >
            <div class="card-body">
              <h5 class="card-title">Liste des demandes en attentes</h5>

              <!-- Table with stripped rows -->
             <!-- Ajoutez le code HTML pour afficher la liste des clients et les options de validation/rejet -->
<table class="table datatable">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nom</th>
            <th scope="col">Prénom</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($clients as $client)
        <tr>
            <th scope="row">{{ $client->id }}</th>
            <td>{{ $client->nom }}</td>
            <td>{{ $client->prenom }}</td>
            <td>
                <div style="display: flex; flex-direction:row;">
                    <form action="{{ route('approuver', ['id_demande' => $client->demande_id]) }}" method="post">
                        @csrf
                        <button type="submit" class="badge bg-success" style="margin-right: 1%;">Valider</button>
                    </form>
                    <form action="{{ route('reject', ['id_demande' => $client->demande_id]) }}" method="post">
                        @csrf
                        <button type="submit" class="badge bg-danger">Rejeter</button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


              <!-- End Table with stripped rows -->

            </div>
          </div>

        </div>
      </div>
    </section>





  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>GestAdmin</span></strong>. All Rights Reserved
    </div>

  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets-admin/vendor/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets-admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets-admin/vendor/chart.js/chart.umd.js') }}"></script>
  <script src="{{ asset('assets-admin/vendor/echarts/echarts.min.js') }}"></script>
  <script src="{{ asset('assets-admin/vendor/quill/quill.min.js') }}"></script>
  <script src="{{ asset('assets-admin/vendor/simple-datatables/simple-datatables.js') }}"></script>
  <script src="{{ asset('assets-admin/vendor/tinymce/tinymce.min.js') }}"></script>
  <script src="{{ asset('assets-admin/vendor/php-email-form/validate.js') }}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('assets-admin/js/main.js') }}"></script>

</body>

</html>
