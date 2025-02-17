<ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fa-regular fa-fw fa-school"></i>
            {{-- <img src="{{asset('assets/img/E - VOTING (2).png')}}" height="40"> --}}
        </div>
        <div class="sidebar-brand-text mx-3">SMEA Juara</div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item {{ @$menu_type == 'dashboard' ? 'active' : '' }}">
        <a href="{{ route('admin.dashboard') }}" class="nav-link">
            <i class="fa-regular fa-fw fa-house"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">
    <div class="sidebar-heading">Kelola</div>

    <li class="nav-item {{ @$menu_type == 'kelola-kelas' ? 'active' : '' }}">
        <a href="{{ route('admin.kelola.kelas') }}" class="nav-link">
            <i class="fa-regular fa-fw fa-school"></i>
            <span>Kelola Kelas</span>
        </a>
    </li>
    <li class="nav-item {{ @$menu_type == 'kelola-siswa' ? 'active' : '' }}">
        <a href="{{ route('admin.kelola.siswa') }}" class="nav-link">
            <i class="fa-regular fa-fw fa-users"></i>
            <span>Kelola User</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
