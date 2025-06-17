<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- Place this tag where you want the button to render. -->

            <!-- User -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ auth()->user()->foto ? url(auth()->user()->foto) : asset('image/user.jpg') }}" alt="Profile" class="rounded-circle me-2"
                        style="width: 32px; height: 32px; object-fit: cover;">
                    <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li class="dropdown-item-text">
                        <div class="d-flex align-items-center">
                            <img src="{{ auth()->user()->foto ? url(auth()->user()->foto) : asset('image/user.jpg') }}" alt="Profile" class="rounded-circle me-2"
                                style="width: 40px; height: 40px; object-fit: cover;">
                            <div>
                                <div class="fw-semibold">{{ auth()->user()->name }}</div>
                                <small class="text-muted">{{ auth()->user()->email }}</small>
                            </div>
                        </div>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('user.profil') }}">
                            <i class="bx bx-user me-2"></i> My Profile
                        </a>
                    </li>
                    @if (auth()->user()->level == 1)
                        <li>
                            <a class="dropdown-item" href="{{ route('setting.index') }}">
                                <i class="bx bx-cog me-2"></i> Settings
                            </a>
                        </li>
                    @endif
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="bx bx-power-off me-2"></i> Log Out
                            </button>
                        </form>
                    </li>
                </ul>
            </li>

            <!--/ User -->
        </ul>
    </div>
</nav>
