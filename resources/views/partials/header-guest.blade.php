<header class="main-header">
  <!-- Logo -->
  <a href="{{ route('guest')}}" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini">
      <img src="{{ asset('images/logo-small.png')}}" width="45" style="margin-top: 5px;">
    </span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>PHU QUOC LUX</b></span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  @if(!isset($codeUser))

  @else
  <div style="clear:both;"></div>
   @endif

</header>