<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link" href="{{ route('home', 'cdi') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->



        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('page_pemesanan_cust') }}">
                <i class="bi bi-view-list"></i>
                <span>Pemesanan</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('page_historypesan_cust') }}">
                <i class="bi bi-postcard"></i>
                <span>History Pesan</span>
            </a>
        </li><!-- End Dashboard Nav -->

    </ul>
</aside>
