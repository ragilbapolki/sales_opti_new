<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">


        <li class="nav-item">
            <a class="nav-link" href="{{ route('home', 'cdi') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('page_listharga_erp') }}">
                <i class="bi bi-currency-dollar"></i>
                <span>Price List</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('pagesales_stok_erp') }}">
                <i class="bi bi-box"></i>
                <span>Stok ERP</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('page_peritems_erp') }}">
                <i class="bi bi-diagram-2"></i>
                <span>Stok Item ERP</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('page_custrank_area') }}">
                <i class="bi bi-wifi"></i>
                <span>Cust Rank</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('page_targetarea') }}">
                <i class="bi bi-fingerprint"></i>
                <span>Target Presensi</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{!! route('pindahcabang') !!}">
                <i class="bi bi-arrow-left-right"></i>
                <span>Pindah Cabang</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('page_historypesan') }}">
                <i class="bi bi-postcard"></i>
                <span>History Pesan</span>
            </a>
        </li><!-- End Dashboard Nav -->

    </ul>
</aside>
