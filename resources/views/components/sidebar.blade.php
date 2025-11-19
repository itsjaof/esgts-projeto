<div class="sidebar">
    <div class="logo">
        <i class="fas fa-clock"></i> PointSystem
    </div>

    <nav>
        <a class="nav-item" href="">
            <i class="fas fa-home"></i> Dashboard
        </a>
        <a class="nav-item" href="">
            <i class="fas fa-fingerprint"></i> Registar Picagem
        </a>
        <a class="nav-item {{ request()->routeIs('empregados') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Empregados
        </a>
        <a class="nav-item" href="">
            <i class="fas fa-list-alt"></i> Picagens
        </a>
    </nav>

    <div class="bottom-menu">
        <a class="nav-item" id="theme-toggle">
            <i class="fas fa-palette"></i> <span class="theme-text">Tema</span>
        </a>
        <a class="nav-item">
            <i class="fas fa-sign-out-alt"></i> Sair
        </a>
    </div>
</div>
