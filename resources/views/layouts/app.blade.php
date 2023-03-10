@include('layouts.head')
    <!-- Navbar-->
    @include('layouts.nav')
    <!-- Sidebar menu-->
    @include('layouts.side')
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1> @yield('title')</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="#">@yield('title')</a></li>
        </ul>
      </div>
      @yield('content')
    </main>
@include('layouts.foot')