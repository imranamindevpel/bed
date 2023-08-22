<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <img src="assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image" style="opacity: .8">
          <p href="#" class="d-block">{{ config('app.name') }}</p>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ Auth::user()->name }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="/" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/users" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Users
              </p>
            </a>
          </li>
          {{-- <li class="nav-item">
            <a href="/permissions" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Permissions
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/roles" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Roles
              </p>
            </a>
          </li> --}}
          <li class="nav-item">
            <a href="/tenants" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Tenants
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/agents" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Agents
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/bookings" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
               Bookings
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/transactions" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
               Transactions
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Logout
              </p>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>