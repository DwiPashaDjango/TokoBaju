<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user">
        @if (auth()->user()->image != 'default.png')
          <img class="app-sidebar__user-avatar" src="{{asset('storage/profile/' . auth()->user()->image)}}" alt="User Image">
        @else
          <img class="app-sidebar__user-avatar" width="40" src="https://st3.depositphotos.com/6672868/13701/v/600/depositphotos_137014128-stock-illustration-user-profile-icon.jpg" alt="User Image">
        @endif  
        <div>
          <p class="app-sidebar__user-name">{!! Str::limit(auth()->user()->name, 80, '...') !!}</p>
          <p class="app-sidebar__user-designation">{{auth()->user()->email}}</p>
        </div>
      </div>
      <ul class="app-menu">
        <li><a class="app-menu__item {{request()->is('admin/dashboard') ? 'active' : ''}}" href="{{url('/admin/dashboard')}}"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
        @if (auth()->user()->role == 'admin')
          <li class="treeview"><a class="app-menu__item {{request()->is('admin/karyawan*') ? 'active' : ''}}" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Karyawan</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
              <li><a class="treeview-item {{request()->is('admin/karyawan/add') ? 'active' : ''}}" href="{{url('/admin/karyawan/add')}}"><i class="icon fa fa-circle-o"></i> Tambah Karyawan</a></li>
              <li><a class="treeview-item {{request()->is('admin/karyawan') ? 'active' : ''}}" href="{{url('/admin/karyawan')}}" rel="noopener"><i class="icon fa fa-circle-o"></i> Data Karyawan</a></li>
            </ul>
          </li>
          @endif
          <li class="treeview"><a class="app-menu__item {{request()->is('admin/product*') ? 'active' : ''}}" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-arrow-right"></i><span class="app-menu__label">product</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
              <li><a class="treeview-item {{request()->is('admin/product/add') ? 'active' : ''}}" href="{{url('/admin/product/add')}}"><i class="icon fa fa-circle-o"></i> Tambah product</a></li>
              <li><a class="treeview-item {{request()->is('admin/product') ? 'active' : ''}}" href="{{url('/admin/product')}}" rel="noopener"><i class="icon fa fa-circle-o"></i> Data product</a></li>
            </ul>
          </li>
        <li><a class="app-menu__item {{request()->is('admin/kasir') ? 'active' : ''}}" href="{{url('/admin/kasir')}}"><i class="app-menu__icon fa fa-money"></i><span class="app-menu__label">Kasir</span></a></li>
      </ul>
    </aside>