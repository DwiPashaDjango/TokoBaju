@section('title')
    Login
@endsection
@include('layouts.head')
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
        <h1>BuLen (Butik Online)</h1>
      </div>
      <div class="login-box">
        <form class="login-form" action="{{url('/check')}}" method="POST">
            @csrf
            @if (session('errors'))
                <div class="alert alert-danger">
                    <strong>{{session('errors')}}</strong>
                </div>
            @endif
          <div class="form-group mt-4">
            <label class="control-label">Email</label>
            <input class="form-control" type="text" name="email" placeholder="Email" autofocus>
          </div>
          <div class="form-group">
            <label class="control-label">Password</label>
            <input class="form-control" type="password" name="password" placeholder="Password">
          </div>
          <div class="form-group">
            <div class="utility">
              <div class="animated-checkbox">
                <label>
                  <input type="checkbox" checked><span class="label-text">Check</span>
                </label>
              </div>
            </div>
          </div>
          <div class="form-group btn-container">
            <button class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>SIGN IN</button>
          </div>
        </form>
      </div>
    </section>
@include('layouts.foot')