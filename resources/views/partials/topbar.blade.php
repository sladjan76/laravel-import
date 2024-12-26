<header class="main-header">
    <!-- Logo -->
    <a href="{{ url('/') }}" class="logo"
       style="font-size: 16px; color: #333; font-weight: bold;">
        <span class="logo-mini">
        </span>
        <span class="logo-lg">
            <h3 style="margin-top: 10px; color: #333; font-weight: bold;">@lang('global.global_title')</h3>
        </span>
    </a>
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="pull-right" style="padding-top:15px;padding-right:15px;color: #333;font-weight: bold;">
        <i class="fa fa-user"></i>&nbsp;&nbsp;{{ Auth::user()->name }}
        </div>

    </nav>
</header>


