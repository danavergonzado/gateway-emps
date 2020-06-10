 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/home') }}" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Menu</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="{{ url('home') }}" class="nav-link">
              <i class="nav-icon fas fa-user-circle"></i>
              <p>Account</p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="{{ url('/security') }}" class="nav-link">
              <i class="nav-icon fas fa-user-lock"></i>
              <p>Security</p>
            </a>
          </li>
          <li class="nav-item">
              <a href="{{ url('timelogs') }}" class="nav-link">
                <i class="nav-icon fas fa-clock"></i>
                <p>Time Logs</p>
              </a>
            </li>
          
            
          @if(Auth::user()->role == 'hr')
            <li class="nav-item">
              <a href="{{ url('report') }}" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>Users</p>
              </a>
            </li>

          
          @endif

          <li class="nav-item">
            <a href="{{ url('task') }}" class="nav-link">
              <i class="nav-icon fas fa-tasks"></i>
              <p>Task</p>
            </a>
          </li>

          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>