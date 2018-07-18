<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  @include ('templates/html_head')
  <body>
    <div id="app">
      <div class="container-fluid bg-info py-3">
        <h4 class="display-4 text-white w-50 mx-auto mx-lg-1 text-center">My Product</h4>
      </div>
      <nav class="navbar navbar-expand-sm bg-light navbar-light shadow-sm sticky-top" v-cloak>
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="{{ env('APP_URL') }}">Home</a>
          </li>
          <li class="nav-item" v-if="login == true">
            <a class="nav-link" href="{{ env('APP_URL') }}new-products/">Add Product</a>
          </li>
        </ul>
        <ul class="navbar-nav">
          <li v-if="login == false"><a class="nav-link" href="{{ env('APP_URL') }}retrieve_api">{{ __('Login') }}</a></li>
          <!-- <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li> -->
          <li v-if="login" class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span>@{{ name }}</span> <span class="caret"></span>
            </a>

            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a href="{{ env('APP_URL') }}profile/" class="dropdown-item">Profile</a>
              <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            </div>
          </li>
        </ul>
      </nav>

      <main class="py-4">
        @yield('content')
      </main>

    </div>
    @include ('templates/footer_script')
  </body>
</html>
