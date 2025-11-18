<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand" style="margin-bottom:20px;">
            <a href="{{ route('admin.dashboard') }}">Klinik Antrian-Pasien Admin</a>
        </div>

        <ul class="sidebar-menu mt-3">
            <li class="menu-header">Main Navigation</li>

            {{-- Dashboard --}}
            <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-home"></i><span>Dashboard</span>
                </a>
            </li>

            {{-- Antrian Pasien --}}
            <li class="{{ request()->routeIs('admin.antrian.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.antrian.index') }}">
                    <i class="fas fa-list-ol"></i><span>Antrian Pasien</span>
                </a>
            </li>

            {{-- Data Poli (nanti tinggal bikin CRUD Poli + route "admin.poli.*") --}}
            <li class="{{ request()->routeIs('admin.poli.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.poli.index') }}">
                    <i class="fas fa-hospital"></i><span>Data Poli</span>
                </a>
            </li>

            {{-- (Opsional) Bisa tambahin menu lain di bawah sini, misal laporan dsb --}}
            {{--
            <li class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.reports.index') }}">
                    <i class="fas fa-chart-bar"></i><span>Laporan</span>
                </a>
            </li>
            --}}
        </ul>
    </aside>
</div>
