<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="icon" href="/images/tut wuri handayani.ico">
  {{-- Bootstrap --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="/css/sidebars.css">
  {{-- Custom CSS --}}
  <link rel="stylesheet" href="/css/base_layout.css">
  <title>{{$title}}</title>
</head>
<body>
  {{-- Fixed Navbar --}}
  <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom fixed-top" id="main-navbar">
    <div class="container-fluid">
      <button class="btn btn-outline-secondary d-lg-none" type="button" id="sidebar-toggle">
        <i class="bi bi-list"></i>
      </button>
      <a class="navbar-brand mx-auto d-lg-none" href="#">Buku Induk Siswa</a>
      <div class="d-none d-lg-block">
        <span class="navbar-text">Buku Induk Siswa</span>
      </div>
      <div class="d-flex align-items-center">
        <i class="bi bi-person-circle fs-4"></i>
      </div>
    </div>
  </nav>

  {{-- Sidebar Drawer --}}
  <div class="sidebar-drawer" id="sidebar-drawer">
    @if (auth()->user()->status === 'admin')
        @include('layouts.admin_sidebar')
    @else
        @include('layouts.siswa_sidebar')
    @endif
  </div>

  {{-- Overlay --}}
  <div class="sidebar-overlay" id="sidebar-overlay"></div>

  {{-- Main Content --}}
  <div class="main-content" id="main-content">
    <div class="container-fluid" id="konten">
      @yield('content')
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="/js/sidebars.js"></script>
  <script>
    // Sidebar toggle functionality
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebarDrawer = document.getElementById('sidebar-drawer');
    const sidebarOverlay = document.getElementById('sidebar-overlay');

    sidebarToggle.addEventListener('click', function() {
      sidebarDrawer.classList.toggle('open');
      sidebarOverlay.classList.toggle('active');
    });

    sidebarOverlay.addEventListener('click', function() {
      sidebarDrawer.classList.remove('open');
      sidebarOverlay.classList.remove('active');
    });

    // Auto-close on resize if screen > 768px
    window.addEventListener('resize', function() {
      if (window.innerWidth > 768) {
        sidebarDrawer.classList.remove('open');
        sidebarOverlay.classList.remove('active');
      }
    });

    // Close sidebar when clicking on sidebar links (mobile)
    document.querySelectorAll('.sidebar-content a').forEach(link => {
      link.addEventListener('click', function() {
        if (window.innerWidth <= 768) {
          sidebarDrawer.classList.remove('open');
          sidebarOverlay.classList.remove('active');
        }
      });
    });

    // Set min height
    var winHeight = window.innerHeight;
    var navbarHeight = window.innerWidth < 768 ? 56 : 0;
    var sidebarTop = window.innerWidth >= 769 ? 0 : navbarHeight;
    document.getElementById('konten').style.minHeight = (winHeight - sidebarTop) + 'px'; // Subtract navbar height if visible
  </script>
</body>
</html>
