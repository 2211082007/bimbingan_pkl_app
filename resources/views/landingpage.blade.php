@extends('layouts.frontend.template')

@section('content')
<!-- Hero Section -->
<section id="hero" class="hero section">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6">
        <div class="hero-content">
          <div class="company-badge mb-4">
            <i class="bi bi-gear-fill me-2"></i>
            Bimbingan PKL dengan Mudah
          </div>
          <h1 class="mb-4">
            Mudah Mengajukan, <br>
            Memonitor, <br>
            <span class="accent-text">Dan Melaporkan kegiatan secara online</span>
          </h1>
          <p class="mb-4 mb-md-5">
            Temukan tempat magang anda sesuai dengan bidang dan keinginan anda agar bisa
            mengimplementasikan ilmu di dunia kerja
          </p>
          <div class="hero-buttons">
            <a href="#about" class="btn btn-primary me-0 me-sm-2 mx-1">Get Started</a>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="hero-image">
          <img src="{{ asset('frontend/assets/img/illustration-1.webp') }}" alt="Hero Image" class="img-fluid">
        </div>
      </div>
    </div>
  </div>
</section><!-- /Hero Section -->

<!-- About Section -->
<section id="about" class="about section">
  <div class="container">
    <div class="row">
      <div class="col-lg-6">
        <h2>Tentang Kami</h2>
        <p>
          Kami adalah platform yang dirancang untuk mempermudah proses bimbingan PKL (Praktik Kerja Lapangan). Dengan sistem online, siswa dan pengajar dapat mengajukan, memantau, dan melaporkan kegiatan PKL secara efisien. Kami berkomitmen untuk mendukung pengembangan keterampilan praktis di dunia kerja.
        </p>
      </div>
      <div class="col-lg-6">
        <img src="{{ asset('frontend/assets/img/features-illustration-3.webp') }}" alt="About Image" class="img-fluid">
      </div>
    </div>
  </div>
</section><!-- /About Section -->

<section id="features" class="features">
  <div class="container">
    <h2 class="text-center mb-5">Cara Kerja & Fitur Utama</h2>
    <div class="row text-center">
      <div class="col-md-3">
        <i class="bi bi-person-plus display-4 text-primary mb-3"></i>
        <h5>Daftar Akun</h5>
        <p>Admin mendaftarkan akun mahasiswa ke sistem.</p>
      </div>
      <div class="col-md-3">
        <i class="bi bi-check-circle display-4 text-success mb-3"></i>
        <h5>Pendaftaran PKL</h5>
        <p>Ajukan tempat magang sesuai bidang Anda.</p>
      </div>
      <div class="col-md-3">
        <i class="bi bi-clock display-4 text-warning mb-3"></i>
        <h5>Monitoring Aktivitas</h5>
        <p>Lacak aktivitas PKL dan dapatkan bimbingan.</p>
      </div>
      <div class="col-md-3">
        <i class="bi bi-file-check display-4 text-danger mb-3"></i>
        <h5>Laporan Akhir</h5>
        <p>Upload laporan akhir PKL Anda.</p>
      </div>
    </div>
  </div>
</section>

<section id="call-to-action" class="call-to-action text-center bg-primary text-white py-5">
  <div class="container">
    <h2>Siap Memulai Bimbingan PKL Anda?</h2>
    <p>Daftarkan diri Anda sekarang dan mulai perjalanan karir Anda dari sini.</p>
    <a href="/login" class="btn btn-light">Login Sekarang</a>
  </div>
</section>



@endsection
