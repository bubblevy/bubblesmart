@can('admin')
<li class="menu-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
  <a class="menu-link cursor-pointer" onclick="window.location.href='/admin/dashboard'">
    <i class="menu-icon tf-icons bx bx-desktop"></i>
    <div>Dashboard</div>
  </a>
</li>
<li class="menu-item {{ Request::is('admin/data-materi*') ? 'active' : '' }}">
  <a class="menu-link cursor-pointer" onclick="window.location.href='/admin/data-materi'">
    <i class="menu-icon tf-icons bx bx-book-content"></i>
    <div>Data Materi</div>
  </a>
</li>
@endcan
@can('user')
<li class="menu-item {{ Request::is('materi') ? 'active' : '' }}">
  <a class="menu-link cursor-pointer" onclick="window.location.href='/materi'">
    <i class="menu-icon tf-icons bx bx-book-content"></i>
    <div>Materi</div>
  </a>
</li>
<li class="menu-item {{ Request::is('quiz*') ? 'active' : '' }}">
  <a class="menu-link cursor-pointer" onclick="window.location.href='/quiz'">
    <i class="menu-icon tf-icons bx bx-joystick"></i>
    <div>Quiz</div>
  </a>
</li>
@endcan
@can('admin')
<li class="menu-item {{ Request::is('admin/data-quiz*') ? 'active' : '' }}">
  <a class="menu-link cursor-pointer" onclick="window.location.href='/admin/data-quiz'">
    <i class="menu-icon tf-icons bx bx-joystick"></i>
    <div>Data Quiz</div>
  </a>
</li>
@endcan
<li class="menu-item {{ Request::is('view/discuss*') ? 'active' : '' }}">
  <a class="menu-link cursor-pointer" onclick="window.location.href='/view/discuss'">
    <i class="menu-icon tf-icons bx bx-message-dots"></i>
    <div>Forum</div>
  </a>
</li>
@can('user')
<li class="menu-item {{ Request::is('nilai*') ? 'active' : '' }}">
  <a class="menu-link cursor-pointer" onclick="window.location.href='/nilai'">
    <i class="menu-icon tf-icons bx bx-receipt"></i>
    <div>Nilai</div>
  </a>
</li>
@endcan
@can('admin')
<li class="menu-item {{ Request::is('admin/laporan*') ? 'active' : '' }}">
  <a class="menu-link cursor-pointer" onclick="window.location.href='/admin/laporan'">
    <i class="menu-icon tf-icons bx bx-bar-chart-alt-2"></i>
    <div>Laporan</div>
  </a>
</li>
<li class="menu-item {{ Request::is('admin/pengguna*') ? 'active' : '' }}">
  <a class="menu-link cursor-pointer" onclick="window.location.href='/admin/pengguna'">
    <i class="menu-icon tf-icons bx bx-group"></i>
    <div>Pengguna</div>
  </a>
</li>
<li class="menu-item {{ Request::is('admin/ubah-teks*') ? 'active' : '' }}">
  <a class="menu-link cursor-pointer" onclick="window.location.href='/admin/ubah-teks'">
    <i class="menu-icon tf-icons bx bx-transfer-alt"></i>
    <div>Teks to Aksara</div>
  </a>
</li>
<li class="menu-item {{ Request::is('admin/pengaturan') ? 'active' : '' }}">
  <a class="menu-link cursor-pointer" onclick="window.location.href='/admin/pengaturan'">
    <i class="menu-icon tf-icons bx bx-cog"></i>
    <div>Pengaturan</div>
  </a>
</li>
@endcan
@can('user')
<li class="menu-item {{ Request::is('pengaturan') ? 'active' : '' }}">
  <a class="menu-link cursor-pointer" onclick="window.location.href='/pengaturan'">
    <i class="menu-icon tf-icons bx bx-cog"></i>
    <div>Pengaturan</div>
  </a>
</li>
<li class="menu-item">
  <a class="menu-link cursor-pointer" onclick="window.location.href='/docs/v1'">
    <i class="menu-icon tf-icons bx bx-support"></i>
    <div>Dokumentasi</div>
  </a>
</li>
@endcan