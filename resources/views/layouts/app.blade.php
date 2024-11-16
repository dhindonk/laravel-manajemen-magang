<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', 'Sistem Magang')</title>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Remix Icon -->
        <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
        
        <!-- SweetAlert2 -->
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <style>
            :root {
                --primary-font: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            }

            * {
                font-family: var(--primary-font) !important;
                letter-spacing: -0.1px;
            }

            body {
                background-color: #f8f9fa;
                line-height: 1.5;
            }

            .auth-card {
                max-width: 400px;
                margin: 2rem auto;
                padding: 2rem;
                border-radius: 8px;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                background-color: white;
            }

            .auth-title {
                text-align: center;
                margin-bottom: 2rem;
            }

            .form-control:focus {
                border-color: #0d6efd;
                box-shadow: 0 0 0 2px rgba(13, 110, 253, .15);
            }

            .btn-auth {
                width: 100%;
                padding: 0.7rem;
                margin-top: 1rem;
                font-weight: 500;
            }

            .auth-link {
                text-align: center;
                margin-top: 1rem;
            }

            .btn-primary {
                transition: all 0.2s ease;
                font-weight: 500;
            }

            .btn-primary:hover {
                background-color: #0056b3;
                transform: translateY(-1px);
            }

            /* Custom Typography */
            h1, h2, h3, h4, h5, h6 {
                font-weight: 600;
                line-height: 1.3;
            }

            .text-sm {
                font-size: 0.875rem;
            }

            .text-xs {
                font-size: 0.75rem;
            }

            /* Navbar Styling */
            .navbar {
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            }

            .navbar-brand {
                font-weight: 600;
                font-size: 1.25rem;
            }

            .nav-link {
                font-weight: 500;
                font-size: 0.9375rem;
            }
        </style>

        @stack('css')
    </head>

    <body>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom fixed-top">
            <div class="container-fluid px-3">
                <a class="navbar-brand d-flex align-items-center" href="{{ route('admin.dashboard') }}">
                    <i class="ri-building-4-line text-primary me-2"></i>
                    <span>SIPEKA</span>
                </a>
                
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <i class="ri-menu-line"></i>
                </button>

                @auth
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav me-auto">
                            @role('admin')
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('admin/dashboard*') ? 'active' : '' }}" 
                                       href="{{ route('admin.dashboard') }}">
                                        <i class="ri-dashboard-line me-1"></i>
                                        Dashboard
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('admin/verify*') ? 'active' : '' }}" 
                                       href="{{ route('admin.verify.users') }}">
                                        <i class="ri-user-follow-line me-1"></i>
                                        Verifikasi User
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('admin/absens*') ? 'active' : '' }}" 
                                       href="{{ route('admin.absens.index') }}">
                                        <i class="ri-calendar-check-line me-1"></i>
                                        Verifikasi Absensi
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('admin/suratselesai*') ? 'active' : '' }}" 
                                       href="{{ route('admin.suratselesai.index') }}">
                                        <i class="ri-file-paper-2-line me-1"></i>
                                        Surat Selesai
                                    </a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('dashboard*') ? 'active' : '' }}" 
                                       href="{{ route('dashboard') }}">
                                        <i class="ri-dashboard-line me-1"></i>
                                        Dashboard
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('absens*') ? 'active' : '' }}" 
                                       href="{{ route('absens.index') }}">
                                        <i class="ri-calendar-check-line me-1"></i>
                                        Absensi
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('laporans*') ? 'active' : '' }}" 
                                       href="{{ route('laporans.index') }}">
                                        <i class="ri-file-list-3-line me-1"></i>
                                        Laporan
                                    </a>
                                </li>
                                @if(Auth::user()->suratBalasan)
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle {{ Request::is('surat*') ? 'active' : '' }}" 
                                       href="#" 
                                       id="suratDropdown" 
                                       role="button" 
                                       data-bs-toggle="dropdown">
                                        <i class="ri-file-paper-2-line me-1"></i>
                                        Surat Balasan
                                    </a>
                                    <ul class="dropdown-menu border-0 shadow-sm">
                                        <li>
                                            <a class="dropdown-item" 
                                               href="{{ Storage::url(Auth::user()->suratBalasan->surat) }}" 
                                               target="_blank">
                                                <i class="ri-eye-line me-2"></i>
                                                Preview Surat
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" 
                                               href="{{ Storage::url(Auth::user()->suratBalasan->surat) }}" 
                                               download="Surat_Balasan_{{ Auth::user()->name }}.pdf">
                                                <i class="ri-download-line me-2"></i>
                                                Download Surat
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                @endif
                            @endrole
                        </ul>

                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" 
                               href="#" 
                               id="navbarDropdown" 
                               role="button" 
                               data-bs-toggle="dropdown">
                                <div class="avatar-sm bg-light rounded-circle">
                                    <i class="ri-user-line text-primary"></i>
                                </div>
                                <span>{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm">
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item d-flex align-items-center">
                                            <i class="ri-logout-box-line me-2"></i>
                                            Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endauth
            </div>
        </nav>

        <!-- Main Content with padding-top to account for fixed navbar -->
        <main style="padding-top: 4.5rem;">
            @yield('content')
        </main>

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <style>
            /* Navbar Styles */
            .navbar {
                backdrop-filter: blur(10px);
                background-color: rgba(255, 255, 255, 0.95) !important;
            }

            .navbar-brand {
                font-size: 1.25rem;
                font-weight: 600;
            }

            .nav-link {
                color: #4B5563;
                font-size: 0.9375rem;
                font-weight: 500;
                padding: 0.5rem 0.75rem;
                transition: all 0.2s ease;
            }

            .nav-link:hover {
                color: var(--bs-primary);
            }

            .nav-link.active {
                color: var(--bs-primary);
                background-color: rgba(13, 110, 253, 0.1);
                border-radius: 6px;
            }

            .avatar-sm {
                width: 32px;
                height: 32px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .dropdown-item {
                font-size: 0.9375rem;
                padding: 0.5rem 1rem;
            }

            .dropdown-item:hover {
                background-color: rgba(13, 110, 253, 0.1);
                color: var(--bs-primary);
            }

            @media (max-width: 991.98px) {
                .navbar-collapse {
                    padding: 1rem 0;
                }

                .nav-link {
                    padding: 0.5rem 0;
                }

                .nav-link.active {
                    background-color: transparent;
                    padding-left: 0.75rem;
                }
            }
        </style>

        @stack('scripts')
    </body>

</html>
