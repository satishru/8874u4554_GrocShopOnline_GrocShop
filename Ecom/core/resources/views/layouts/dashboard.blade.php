<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'GroceryShoppingOnline') }}</title>
    <!-- Favicon-->
    <link href="{{ asset('assets/favicon.ico') }}" rel="icon">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    {{-- 
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    --}}
    <!-- Bootstrap Core Css -->
    <link href="{{ asset('assets/admin/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <!-- Waves Effect Css -->
    <link href="{{ asset('assets/admin/plugins/node-waves/waves.css') }}" rel="stylesheet">
    <!-- Animation Css -->
    <link href="{{ asset('assets/admin/plugins/animate-css/animate.css') }}" rel="stylesheet">

     <!-- Bootstrap Select Css -->
     <link href="{{ asset('assets/admin/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet">

    <!-- Custom Css -->
    <link href="{{ asset('assets/admin/css/style.css') }}" rel="stylesheet">

    <!-- JQuery DataTable Css -->
    <link href="{{ asset('assets/admin/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{ asset('assets/admin/css/themes/all-themes.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/admin/css/custom.css') }}" rel="stylesheet">


  </head>
  <body class="theme-green">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
      <div class="loader">
        <div class="preloader">
          <div class="spinner-layer pl-green">
            <div class="circle-clipper left">
              <div class="circle"></div>
            </div>
            <div class="circle-clipper right">
              <div class="circle"></div>
            </div>
          </div>
        </div>
        <p>Please wait...</p>
      </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Top Bar -->
    <nav class="navbar">
      <div class="container-fluid">
        <div class="navbar-header">
          <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
          <a href="javascript:void(0);" class="bars"></a>
          <a class="navbar-brand" href="{{ url('admin-panel/home') }}">GroceryShoppingOnline</a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
            <li>
              <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" title="Sign Out">
                <i class="material-icons">input</i>
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                 @csrf
              </form>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- #Top Bar -->
    <section>
      <!-- Left Sidebar -->
      <aside id="leftsidebar" class="ls-closed sidebar">
        <!-- User Info -->
        <div class="user-info">
          <div class="image">
            <img src="{{ asset('assets/admin/images/user.png')}}" width="48" height="48" alt="User" />
          </div>
          <div class="info-container">
            <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              {{ Auth::user()->name }}
            </div>
            <div class="email"> {{ Auth::user()->email }}</div>
            <div class="btn-group user-helper-dropdown">
              <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
              <ul class="dropdown-menu pull-right">
                <li>
                  <a href="javascript:void(0);"><i class="material-icons">person</i>Profile</a>
                </li>
                <li role="seperator" class="divider"></li>
                <li>
                  <a href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    <i class="material-icons">input</i>Sign Out
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <!-- #User Info -->

        <!-- Menu -->
        @include('layouts.admin_menu')
        <!-- #Menu -->
      </aside>
      <!-- #END# Left Sidebar -->
    </section>

    @yield('content')

    <!-- Jquery Core Js -->
    <script src="{{ asset('assets/admin/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap Core Js -->
    <script src="{{ asset('assets/admin/plugins/bootstrap/js/bootstrap.js') }}"></script>
    <!-- Select Plugin Js -->
    <script src="{{ asset('assets/admin/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
    <!-- Slimscroll Plugin Js -->
    <script src="{{ asset('assets/admin/plugins/jquery-slimscroll/jquery.slimscroll.js') }}"></script>
    <!-- Waves Effect Plugin Js -->
    <script src="{{ asset('assets/admin/plugins/node-waves/waves.js') }}"></script>
    <!-- TinyMCE -->
    <script src="{{ asset('assets/admin/plugins/tinymce/tinymce.js') }}"></script>
    <script src="{{ asset('assets/admin/js/pages/forms/editors.js') }}"></script>
    <!-- Custom Js -->
    <script src="{{ asset('assets/admin/js/admin.js') }}"></script>

    <!-- Jquery DataTable Plugin Js -->
    <script src="{{ asset('assets/admin/plugins/jquery-datatable/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('assets/admin/js/pages/tables/jquery-datatable.js') }}"></script>
    <!-- Demo Js -->
    <script src="{{ asset('assets/admin/js/demo.js') }}"></script>
  
    <!-- Bootstrap Colorpicker Js -->
    <script src="{{ asset('assets/admin/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}"></script>
    <!-- Dropzone Plugin Js -->
    <script src="{{ asset('assets/admin/plugins/dropzone/dropzone.js') }}"></script>
    <!-- Multi Select Plugin Js -->
    <script src="{{ asset('assets/admin/plugins/multi-select/js/jquery.multi-select.js') }}"></script>
    <!-- Input Mask Plugin Js -->
    <script src="{{ asset('assets/admin/plugins/jquery-inputmask/jquery.inputmask.bundle.js') }}"></script>
    <!-- noUISlider Plugin Js -->
    <script src="{{ asset('assets/admin/plugins/nouislider/nouislider.js') }}"></script>
    <!-- Jquery CountTo Plugin Js -->
    <script src="{{ asset('assets/admin/plugins/jquery-countto/jquery.countTo.js') }}"></script>
    <!-- Sparkline Chart Plugin Js -->
    <script src="{{ asset('assets/admin/plugins/jquery-sparkline/jquery.sparkline.js') }}"></script>
    <script src="{{ asset('assets/admin/js/pages/widgets/infobox/infobox-1.js') }}"></script>
    <!-- Bootstrap Notify Plugin Js -->
    <script src="{{ asset('assets/admin/plugins/bootstrap-notify/bootstrap-notify.js') }}"></script>
    <script src="{{ asset('assets/admin/js/pages/ui/notifications.js') }}"></script>
    <!-- JQuery Steps Plugin Js -->
    <script src="{{ asset('assets/admin/plugins/jquery-steps/jquery.steps.js') }}"></script>
    <!-- Validation Plugin Js -->
    <script src="{{ asset('assets/admin/plugins/jquery-validation/jquery.validate.js') }}"></script>
    <!--Form Validation Js -->
    <script src="{{ asset('assets/admin/js/pages/forms/form-validation.js') }}"></script>
    <!-- Advanced Form Elements Js -->
    <script src="{{ asset('assets/admin/js/pages/forms/advanced-form-elements.js') }}"></script>
    <script src="{{ asset('assets/admin/js/pages/forms/form-wizard.js') }}"></script>

    <script src="{{ asset('assets/admin/js/pages/ui/tooltips-popovers.js') }}"></script>
    <script type="text/javascript">
      $(document).ready(function() {
          $('.selectPick').selectpicker('refresh');
      });
    </script>

    @yield('scripts')

  </body>
</html>