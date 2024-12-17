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