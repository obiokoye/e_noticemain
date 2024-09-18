<div class="page-wrapper-inner">

    <!-- Navbar Custom Menu -->
    <div class="navbar-custom-menu">
        
        <div class="container-fluid">
            <div id="navigation">
                <!-- Navigation Menu-->
                <ul class="navigation-menu list-unstyled">
                    @php
                        $permissionsUser = App\Models\PermissionRole::getPermission('User', Auth::user()->role_id);
                        $permissionsRole = App\Models\PermissionRole::getPermission('Role', Auth::user()->role_id);
                        $permissionsCategory = App\Models\PermissionRole::getPermission('Category', Auth::user()->role_id);
                        $permissionsDashboard = App\Models\PermissionRole::getPermission('Dashboard', Auth::user()->role_id);
                        $permissionsDepartment = App\Models\PermissionRole::getPermission('Department', Auth::user()->role_id);
                        $permissionsSystemSetup = App\Models\PermissionRole::getPermission('System Setup', Auth::user()->role_id);
                        $permissionsSubscription = App\Models\PermissionRole::getPermission('Subscription', Auth::user()->role_id);
                        $permissionsPaymentCycle = App\Models\PermissionRole::getPermission('Payment Cycle', Auth::user()->role_id);
                        $permissionsAdministration = App\Models\PermissionRole::getPermission('Administration', Auth::user()->role_id);
                    @endphp

                    <li class="has-submenu">
                        <a href="{{ route('dashboard') }}">
                            <i class="mdi mdi-monitor"></i>
                            Dashboard
                        </a>
                    </li>
                    @if(!empty($permissionsAdministration))
                    <li class="has-submenu">
                        <a href="#"><i class="mdi mdi-account"></i>Administration</a>
                        <ul class="submenu">
                            @if (!empty($permissionsUser))
                               <li><a href="{{ route('user.index') }}">Users</a></li>
                            @endif
                            @if (!empty($permissionsRole))
                              <li><a href="{{route('userrole.index')}}">User Role</a></li> 
                            @endif
                        </ul>
                    </li> 
                    @endif

                    @if (!empty($permissionsSystemSetup))
                        <li class="has-submenu">
                            <a href="#"><i class="mdi mdi-settings"></i>System Setup</a>
                            <ul class="submenu">
                                @if (!empty($permissionsDepartment))
                                  <li><a href="{{ route('department.index') }}">Department</a></li>
                                @endif
                                @if (!empty($permissionsCategory))
                                   <li><a href="{{ route('category.index') }}">Category</a></li> 
                                @endif
                                @if (!empty($permissionsPaymentCycle))
                                   <li><a href="{{ route('paymentcycle.index') }}">Payment Cycle</a></li> 
                                @endif
                                @if (!empty($permissionsSubscription))
                                   <li><a href="{{ route('subscription.index') }}">Subscription</a></li>
                                @endif 
                               

                                
                            </ul>
                        </li>
                    @endif
                    
                    <li><a href="{{ route('subscription.renew') }}"><i class="mdi mdi-bank"></i>Subscription Renewal</a></li>
                    <li><a href="{{ route('reports.index') }}"><i class="mdi mdi-file-chart"></i>Reports</a></li>
                 

                 
                </ul>
                <!-- End navigation menu -->
            </div> <!-- end navigation -->
        </div> <!-- end container-fluid -->
    </div>
    <!-- end left-sidenav-->
</div>
{{-- @include('partials.message')         --}}
<!--end page-wrapper-inner -->