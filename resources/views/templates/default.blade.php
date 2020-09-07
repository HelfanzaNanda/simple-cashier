<!DOCTYPE html>
<html lang="en">
@include('templates.partials._head')

<body class="layout-3">
  <div id="app">
    <div class="main-wrapper container">
      <div class="navbar-bg"></div>
      @include('templates.partials._navbar')

      @include('templates.partials._sidebar')

      <!-- Main Content -->
      <div class="main-content">
        @yield('content')
        
      </div>
      
      @include('templates.partials._footer')
    </div>
  </div>

  @include('templates.partials._script')
</body>
</html>
