<style>
    .sb-sidenav {
        background-color: #212529;
        color: rgba(255, 255, 255, 0.5);
    }

    .nav-link {
        color: rgba(255, 255, 255, 0.5);
        padding: 0.75rem 1rem;
        display: flex;
        align-items: center;
        transition: all 0.2s ease-in-out;
    }

    .nav-link:hover {
        color: #ffffff;
        background-color: #0d6efd;
        text-decoration: none;
    }

    .nav-link.active {
        color: #ffffff;
        background-color: #0d6efd;
    }

    .sb-nav-link-icon {
        margin-right: 0.5rem;
    }

    .sb-sidenav-menu-heading {
        padding: 1.75rem 1rem 0.75rem;
        font-size: 0.75rem;
        font-weight: bold;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.5);
    }

    .sb-sidenav-footer {
        padding: 0.75rem;
        background-color: #343a40;
    }

    .small {
        font-size: 0.875rem;
        color: rgba(255, 255, 255, 0.5);
    }
</style>

<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">Beranda</div>
            <a class="nav-link" href="{{route('admin.dashboard')}}">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Dashboard
            </a>

            @if (Auth::user()->level == 'admin')
            <div class="sb-sidenav-menu-heading">Data</div>
            <a class="nav-link" href="{{route('kecamatan.index')}}">
                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                Daftar Kecamatan
            </a>
            @endif

            @if (Auth::user()->level == 'kecamatan')
            <div class="sb-sidenav-menu-heading">Data</div>
            <a class="nav-link" href="{{route('desa.index')}}">
                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                Daftar Desa
            </a>
            <a class="nav-link" href="{{route('dai.index')}}">
                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                Daftar Dai
            </a>
            <a class="nav-link" href="{{route('reports.index')}}">
                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                Laporan
            </a>
            @endif
            
            @if (Auth::user()->level == 'desa')
            <div class="sb-sidenav-menu-heading">Data</div>
            <a class="nav-link" href="{{route('dai.index')}}">
                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                Daftar Dai
            </a>
            <a class="nav-link" href="{{route('reports.index')}}">
                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                Laporan
            </a>
            @endif    
        </div>
    </div>
    <div class="sb-sidenav-footer">
        <div class="small">Logged in as:</div>
        {{ Auth::user()->name}}
    </div>
</nav>

