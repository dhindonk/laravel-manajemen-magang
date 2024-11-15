<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="{{ asset('Atlantis-Lite/assets/img/zzz.webp') }}" alt="..."
                        class="avatar-img rounded-circle">
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            {{ Auth::user()->name }}
                            <span class="user-level">Admin</span>
                        </span>
                    </a>
                </div>
            </div>
            <ul class="nav nav-primary">
                <li class="nav-item active">
                    <a href="{{ route('admin.dashboard') }}" class="collapsed">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Feature</h4>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.verify.users') }}">
                        <i class="fas fa-user-check"></i>
                        <p>Verifikasi User</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.absens.index') }}">
                        <i class="fas fa-calendar-check"></i>
                        <p>Verifikasi Absensi</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.laporans.index') }}">
                        <i class="fas fa-file-alt"></i>
                        <p>Laporan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.suratselesai.index') }}">
                        <i class="fas fa-file-signature"></i>
                        <p>Surat Selesai</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
