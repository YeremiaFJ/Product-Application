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
  <ul class="navbar-nav" v-if="login == false">
    <li class="nav-item">
      <a class="nav-link" data-toggle="modal" data-target="#registerModal">Sign up</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="modal" data-target="#loginModal">Log in</a>
    </li>
  </ul>
  <ul class="navbar-nav" v-if="login">
    <li class="nav-item">
      <a class="nav-link">Welcome @{{ name }},</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" @click="onLogout">Log out</a>
    </li>
  </ul>
</nav>
<register-modal @register="onRegister"></register-modal>
<login-modal @login="onLogin"></login-modal>
