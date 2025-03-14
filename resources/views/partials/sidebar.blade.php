<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

<div class="d-flex align-items-center justify-content-center p-3 border-bottom">
    <a href="/" class="logo d-flex flex-column justify-content-center text-decoration-none">
<!-- <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" style="height: 40px; margin-bottom: 10px;"> -->
    <span class="d-none d-lg-block text-white justify-content-center" style="font-size: 30px; font-family: 'Poppins', sans-serif;">Sierra Collection</span>
<!-- <i class="bi bi-list toggle-sidebar-btn text-white mt-2 fs-4" style="cursor: pointer;"></i> -->
    </a>
</div>

<!-- Navigation Item -->
<ul class="nav flex-column mt-3 border-bottom">
  <li class="nav-item">
  <a class="nav-link collapsed d-flex align-items-center text-decoration-none text-dark py-2 px-3" href="/">
      <i class="bi bi-grid"></i>
      <span class="d-none d-lg-block text-white justify-content-center" style="font-size: 12px; font-family: 'Poppins', sans-serif;">Dashboard</span>
    </a>
  </li>
  </ul>
  <!-- End Dashboard Nav -->
    <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="components-alerts.html">
          <i class="bi bi-circle"></i><span>Alerts</span>
        </a>
      </li>
      <li>
        <a href="components-accordion.html">
          <i class="bi bi-circle"></i><span>Accordion</span>
        </a>
      </li>
      <li>
        <a href="components-badges.html">
          <i class="bi bi-circle"></i><span>Badges</span>
        </a>
      </li>
      <li>
        <a href="components-breadcrumbs.html">
          <i class="bi bi-circle"></i><span>Breadcrumbs</span>
        </a>
      </li>
      <li>
        <a href="components-buttons.html">
          <i class="bi bi-circle"></i><span>Buttons</span>
        </a>
      </li>
      <li>
        <a href="components-cards.html">
          <i class="bi bi-circle"></i><span>Cards</span>
        </a>
      </li>
      <li>
        <a href="components-carousel.html">
          <i class="bi bi-circle"></i><span>Carousel</span>
        </a>
      </li>
      <li>
        <a href="components-list-group.html">
          <i class="bi bi-circle"></i><span>List group</span>
        </a>
      </li>
      <li>
        <a href="components-modal.html">
          <i class="bi bi-circle"></i><span>Modal</span>
        </a>
      </li>
      <li>
        <a href="components-tabs.html">
          <i class="bi bi-circle"></i><span>Tabs</span>
        </a>
      </li>
      <li>
        <a href="components-pagination.html">
          <i class="bi bi-circle"></i><span>Pagination</span>
        </a>
      </li>
      <li>
        <a href="components-progress.html">
          <i class="bi bi-circle"></i><span>Progress</span>
        </a>
      </li>
      <li>
        <a href="components-spinners.html">
          <i class="bi bi-circle"></i><span>Spinners</span>
        </a>
      </li>
      <li>
        <a href="components-tooltips.html">
          <i class="bi bi-circle"></i><span>Tooltips</span>
        </a>
      </li>
    </ul>
  <!-- </li> -->
    <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="forms-elements.html">
          <i class="bi bi-circle"></i><span>Form Elements</span>
        </a>
      </li>
      <li>
        <a href="forms-layouts.html">
          <i class="bi bi-circle"></i><span>Form Layouts</span>
        </a>
      </li>
      <li>
        <a href="forms-editors.html">
          <i class="bi bi-circle"></i><span>Form Editors</span>
        </a>
      </li>
      <li>
        <a href="forms-validation.html">
          <i class="bi bi-circle"></i><span>Form Validation</span>
        </a>
      </li>
    </ul>
  </li><!-- End Forms Nav -->

  @if(auth()->user() && in_array(auth()->user()->role->name, ['Owner', 'Admin Keuangan', 'Management']))
  <li class="nav-heading ">Transaksi</li>

  <li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('{{ route('pemasukan.index') }}.index') }}">
      <i class="bi bi-arrow-up"></i>
      <span style="font-size: 12px; font-family: 'Poppins', sans-serif;">Pendapatan</span>
    </a>
  </li><!-- End Profile Page Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('{{ route('pengeluaran.index') }}.index') }}">
      <i class="bi bi-arrow-down"></i>
      <span style="font-size: 12px; font-family: 'Poppins', sans-serif;">Pengeluaran</span>
    </a>
  </li><!-- End F.A.Q Page Nav -->
  <ul class="nav flex-column mt-3 border-bottom"></ul>
  @endif

  @if(auth()->user() && in_array(auth()->user()->role->name, ['Owner', 'Admin Stok Barang', 'Management']))
  <li class="nav-heading ">Barang</li>
  <li class="nav-item">
    <a class="nav-link collapsed" href="stok_barang">
      <i class="bi bi-bag-check-fill"></i>
      <span style="font-size: 12px; font-family: 'Poppins', sans-serif;">Stok Barang</span>
    </a>
  </li><!-- End Login Page Nav -->
  <ul class="nav flex-column mt-3 border-bottom"></ul>
  @endif
  

  @if(auth()->user() && in_array(auth()->user()->role->name, ['Owner']))
  <li class="nav-heading ">KARYAWAN</li>

  <li class="nav-item">
    <a class="nav-link collapsed" href="karyawan">
      <i class="bi bi-people-fill"></i>
      <span style="font-size: 12px; font-family: 'Poppins', sans-serif;">Karyawan</span>
    </a>
  </li><!-- End Contact Page Nav -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="admin">
      <i class="bi bi-person-fill"></i>
      <span style="font-size: 12px; font-family: 'Poppins', sans-serif;">Akun</span>
    </a>
  </li><!-- End Contact Page Nav -->
  <ul class="nav flex-column mt-3 border-bottom"></ul>
  @endif

  <li class="nav-heading ">LAPORAN</li>
  @if(auth()->user() && in_array(auth()->user()->role->name, ['Owner', 'Admin Keuangan', 'Management']))
  <li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('hutang.index') }}">
      <i class="bi bi-bar-chart-fill"></i>
      <span style="font-size: 12px; font-family: 'Poppins', sans-serif;">Hutang</span>
    </a>
  </li><!-- End Register Page Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('laporan.index') }}">
      <i class="bi bi-table"></i>
      <span style="font-size: 12px; font-family: 'Poppins', sans-serif;">Laporan Keuangan</span>
    </a>
  </li><!-- End Login Page Nav -->
  @endif
  @if(auth()->user() && in_array(auth()->user()->role->name, ['Owner', 'Admin Stok Barang', 'Management']))
  <li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('laporan.stok.index') }}">
      <i class="bi bi-clipboard-data"></i>
      <span style="font-size: 12px; font-family: 'Poppins', sans-serif;">Laporan Stok Barang</span>
    </a>
  </li><!-- End Login Page Nav -->
  @endif
  <ul class="nav flex-column mt-3 border-bottom"></ul>

  <li class="nav-heading ">Barang</li>

  <li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('stok_barang.index') }}">
      <i class="bi bi-bag-check-fill"></i>
      <span style="font-size: 12px; font-family: 'Poppins', sans-serif;">Stok Barang</span>
    </a>
  </li><!-- End Login Page Nav -->

  <div class="toggle-sidebar-btn" id="sidebarToggle">
<i class="bi bi-chevron-left" id="sidebarToggle"></i>
</div>

</ul>
</aside><!-- End Sidebar-->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.getElementById("sidebar");
    const sidebarToggle = document.getElementById("sidebarToggle");

    sidebarToggle.addEventListener("click", function () {
      sidebar.classList.toggle("collapsed");
    });
  });
</script>

