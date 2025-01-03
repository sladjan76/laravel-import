@inject('request', 'Illuminate\Http\Request')
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="{{ $request->segment(2) == 'home' ? 'active' : '' }}">
                <a href="{{ url('/dashboard') }}">
                    <i class="fa fa-wrench"></i>
                    <span class="title">@lang('global.app_dashboard')</span>
                </a>
            </li>
            @can('users_manage')
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-users"></i>
                        <span class="title">@lang('global.user-management.title')</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ $request->segment(2) == 'permissions' ? 'active active-sub' : '' }}">
                            <a href="{{ route('admin.permissions.index') }}">
                                <i class="fa fa-briefcase"></i>
                                <span class="title">
                                    @lang('global.permissions.title')
                                </span>
                            </a>
                        </li>
                        <li class="{{ $request->segment(2) == 'roles' ? 'active active-sub' : '' }}">
                            <a href="{{ route('admin.roles.index') }}">
                                <i class="fa fa-briefcase"></i>
                                <span class="title">
                                    @lang('global.roles.title')
                                </span>
                            </a>
                        </li>
                        <li class="{{ $request->segment(2) == 'users' ? 'active active-sub' : '' }}">
                            <a href="{{ route('admin.users.index') }}">
                                <i class="fa fa-user"></i>
                                <span class="title">
                                    @lang('global.users.title')
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-table"></i>
                    <span class="title">@lang('global.data.title')</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ $request->segment(2) == 'import' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.imports.index') }}">
                            <i class="fa fa-file"></i>
                            <span class="title">
                                @lang('global.import_form.title')
                            </span>
                        </a>
                    </li>
                    <li class="{{ $request->segment(2) == 'import_history' ? 'active active-sub' : '' }}">
                        <a href="{{ route('admin.import_history.index') }}">
                            <i class="fa fa-list"></i>
                            <span class="title">
                                @lang('global.imports.title')
                            </span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#logout" onclick="$('#logout').submit();">
                    <i class="fa fa-arrow-left"></i>
                    <span class="title">@lang('global.app_logout')</span>
                </a>
            </li>
        </ul>
    </section>
</aside>
{!! Form::open(['route' => 'auth.logout', 'style' => 'display:none;', 'id' => 'logout']) !!}
<button type="submit">@lang('global.logout')</button>
{!! Form::close() !!}
