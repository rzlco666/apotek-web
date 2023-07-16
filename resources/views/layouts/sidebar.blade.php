<div class="sidebar-wrapper">
    <div>
      <div class="logo-wrapper"><a href="{{ route('dashboard') }}"><img class="img-fluid for-light" src="{{ asset('assets/images/logo/logo.png') }}" alt=""></a>
        <div class="back-btn"><i data-feather="grid"></i></div>
        <div class="toggle-sidebar icon-box-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
      </div>
      <div class="logo-icon-wrapper"><a href="{{ route('dashboard') }}">
          <div class="icon-box-sidebar"><i data-feather="grid"></i></div></a></div>
      <nav class="sidebar-main">
        <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
        <div id="sidebar-menu">
          <ul class="sidebar-links" id="simple-bar">
            <li class="back-btn">
              <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
            </li>
            <li class="pin-title sidebar-list">
              <h6>Pinned</h6>
            </li>
            <hr>
            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title link-nav" href="{{ route('dashboard') }}"><i data-feather="home"> </i><span>Dashboard</span></a></li>
            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title link-nav" href="{{ route('data-faktur') }}"><i data-feather="inbox"> </i><span>Data Faktur</span></a></li>
            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title link-nav" href="{{ route('supplier') }}"><i data-feather="truck"> </i><span>Distributor</span></a></li>
              <li class="sidebar-list">
                  <i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="javascript:void(0)"><i data-feather="box"></i><span>Obat</span></a>
              <ul class="sidebar-submenu">
                  <li><a href="{{ route('data-obat') }}">Data Obat</a></li>
                  <li><a href="{{ route('in-obat') }}">Obat Masuk</a></li>
                  <li><a href="{{ route('out-obat') }}">Obat Keluar</a></li>
                  <li><a href="{{ route('exp-obat') }}">Obat Kadaluwarsa</a></li>
                  <li><a href="{{ route('stok-obat') }}">Stok Obat</a></li>
                  <li><a href="{{ route('kategori-obat') }}">Kategori Obat</a></li>
                  <li><a href="{{ route('satuan') }}">Satuan</a></li>
                  <li><a href="{{ route('golongan') }}">Golongan</a></li>
              </ul>
              </li>
              <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title link-nav" href="{{ route('surat-pesanan') }}"><i data-feather="file-text"> </i><span>Surat Pesanan</span></a></li>
              <li class="sidebar-list">
                  <i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="javascript:void(0)"><i data-feather="layout"></i><span>Kelola User</span></a>
                  <ul class="sidebar-submenu">
                      <li><a href="{{ route('user') }}">User</a></li>
                      <li><a href="{{ route('role') }}">Role</a></li>
                      <li><a href="{{ route('permission') }}">Permission</a></li>
                  </ul>
              </li>
          </ul>
        </div>
        <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
      </nav>
    </div>
  </div>
