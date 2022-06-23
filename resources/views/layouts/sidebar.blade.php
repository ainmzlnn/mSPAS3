<aside class="main-sidebar sidebar-light-info elevation-4" style="background-color: #FFBB90;">
    <!-- Brand Logo -->
    <a href="/home" class="brand-link">
        <div class="text-center">
            <img src="{{ asset('img/logo2.png') }}" alt="AdminLTE Logo" class="brand-image-center img-circle elevation-3" style="width:20%;"><br>
            <span class="brand-text font-weight-light">mSPAS</span>
        </div>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if(auth()->user()->hasRole('teacher') || auth()->user()->hasRole('parent'))
                <img src="{{ asset(auth()->user()->picture) }}" class="img-circle elevation-2" alt="User Image">
                @elseif(auth()->user()->hasRole('admin'))
                <img src="{{ asset('img/me10.jpeg') }}" class="img-circle elevation-2" alt="User Image">
                @endif
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}
                    | {{ucfirst(auth()->user()->roles[0]->name ?? 'user') }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="{{route('home')}}" class="{{ Request::is('home') ? 'nav-link bg-info active' : 'nav-link' }}">
                        <i class="nav-icon fas fa-home"></i>&nbsp;<p>Dashboard</p>
                    </a>
                </li>

                @if(auth()->user()->hasRole('admin'))
                <li class="nav-item">
                    <a href="{{route('users.index') }}" class="{{  str_starts_with(Request::route()->getName(), 'users') ? 'nav-link bg-info active' : 'nav-link' }}">
                        <i class="nav-icon fas fa-user-alt"></i>&nbsp;<p>Account List</p>
                    </a>
                </li>
                @endif
                @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('parent'))
                <li class="nav-item">
                    <a href="{{ route('students.index') }}" class="{{ str_starts_with(Request::route()->getName(), 'students') ? 'nav-link bg-info active' : 'nav-link' }}">
                        <i class="nav-icon fas fa-address-book"></i>&nbsp;<p>Student Information</p>
                    </a>
                </li>
                @endif
                @if(auth()->user()->hasRole('teacher') || auth()->user()->hasRole('parent'))
                <li class="nav-item">
                    <a href="{{ route('homeworks.index') }}" class="{{ str_starts_with(Request::route()->getName(), 'homeworks') ? 'nav-link bg-info active' :'nav-link'}}">
                        <i class="nav-icon fas fa-clipboard-list"></i>&nbsp;<p>Homework List</p>
                    </a>
                </li>
                @endif
                <li class="nav-item">
                    <a href="{{ route('modules.index') }}" class="{{ str_starts_with(Request::route()->getName(), 'modules') ? 'nav-link bg-info active' : 'nav-link'}}">
                        <i class="nav-icon fas fa-poll-h"></i><p>Academic&nbsp;{{ auth()->user()->hasRole('admin') ? "Module" : "Progress" }}</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>