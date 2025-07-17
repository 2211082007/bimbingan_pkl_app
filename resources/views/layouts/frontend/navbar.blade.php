<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
        <a href="index.html" class="logo d-flex align-items-center me-auto me-xl-0">
            <span class="app-brand-logo demo">
                <img src="{{ asset('frontend/assets/img/logo-pkl.png') }}" alt="Logo" width="200" height="60">
            </span>
        </a>
        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="#hero" class="active">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#features">Features</a></li>
                <li><a href="#call-to-action">Action</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
        <a class="btn-getstarted" href="{{ url('/login') }}">Get Started</a>
    </div>
</header>
