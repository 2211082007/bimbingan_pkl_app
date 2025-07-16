<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="{{ url('/') }}" class="app-brand-link">
      <span class="app-brand-logo demo">
        <!-- Logo SVG -->
      </span>
      <span class="app-brand-text demo menu-text fw-bolder ms-2">Bimbingan PKL</span>
    </a>
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">

    @hasanyrole('superAdmin|admin|mahasiswa|dosen|mahasiswaPkl|kaprodi|pengujiPkl|pembimbingPkl')
    <li class="menu-item">
      <a class="menu-link" href="/dashboard">
        <i class="bx bx-home-circle menu-icon"></i>
        <div>Dashboard</div>
      </a>
    </li>
    @endhasanyrole

    @hasrole('admin')
    <li class="menu-item">
      <a class="menu-link menu-toggle" href="javascript:void(0);">
        <i class="bx bx-folder menu-icon"></i>
        <div>Data Master</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item"><a class="menu-link" href="/jurusan"><i class="bx bx-group"></i> <div>Jurusan</div></a></li>
        <li class="menu-item"><a class="menu-link" href="/prodi"><i class="bx bx-clipboard"></i> <div>Prodi</div></a></li>
        <li class="menu-item"><a class="menu-link" href="/mahasiswa"><i class="bx bx-user"></i> <div>Mahasiswa</div></a></li>
        <li class="menu-item"><a class="menu-link" href="/dosen"><i class="bx bx-id-card"></i> <div>Dosen</div></a></li>
        <li class="menu-item"><a class="menu-link" href="/ruang"><i class="bx bx-building-house"></i> <div>Ruangan</div></a></li>
        <li class="menu-item"><a class="menu-link" href="/sesi"><i class="bx bx-time"></i> <div>Sesi</div></a></li>
      </ul>
    </li>
    @endhasrole

    @hasanyrole('mahasiswa|mahasiswaPkl')
    <li class="menu-item">
      <a class="menu-link menu-toggle" href="javascript:void(0);">
        <i class="bx bx-briefcase-alt menu-icon"></i>
        <div>PKL</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item"><a class="menu-link" href="/usulanpkl"><i class="bx bx-send"></i> <div>Registrasi Tempat PKL</div></a></li>
        <li class="menu-item"><a class="menu-link" href="{{ route('logbook.view', auth()->user()->mahasiswa->id_mhs) }}"><i class="bx bx-book-content"></i> <div>Bimbingan PKL</div></a></li>
      </ul>
    </li>
    @endhasanyrole

    @hasrole('kaprodi')
    <li class="menu-item">
      <a class="menu-link menu-toggle" href="javascript:void(0);">
        <i class="bx bx-task menu-icon"></i>
        <div>PKL-Kaprodi</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item"><a class="menu-link" href="/verif_usulan_pkl"><i class="bx bx-check-double"></i> <div>Verifikasi Usulan PKL</div></a></li>
      </ul>
    </li>
    @endhasrole

    @hasrole('pembimbingPkl')
    <li class="menu-item">
      <a class="menu-link menu-toggle" href="javascript:void(0);">
        <i class="bx bx-user-check menu-icon"></i>
        <div>PKL-Pembimbing</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item"><a class="menu-link" href="/verif_bimbingan_pkl"><i class="bx bx-check"></i> <div>Verifikasi Bimbingan PKL</div></a></li>
        <li class="menu-item"><a class="menu-link" href="/bimbinganPkl"><i class="bx bx-book"></i> <div>Bimbingan PKL</div></a></li>
      </ul>
    </li>
    @endhasrole

  </ul>
</aside>
