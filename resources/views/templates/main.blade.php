<!DOCTYPE html>

<html lang="en">
  @include ('templates/html_head')
  <body>
    <div id="app">
      @include ('templates/title_nav')

      @yield ('content')

    </div>
    @include ('templates/footer_script')
  </body>
</html>
