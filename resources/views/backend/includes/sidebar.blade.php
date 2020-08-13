<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
<!--            <li class="header">{{ trans('menus.backend.sidebar.general') }}</li>-->

            <li class="{{ active_class(Active::checkUriPattern('admin/dashboard')) }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-dashboard"></i>
                    <span>{{ trans('menus.backend.sidebar.dashboard') }}</span>
                </a>
            </li>

<!--            <li class="header">{{ trans('menus.backend.sidebar.system') }}</li>-->

            @permission('view-access-management')
            <li class="{{ active_class(Active::checkUriPattern('admin/access/*')) }} treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>{{ trans('menus.backend.access.title') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/access/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/access/*'), 'display: block;') }}">
                    @permission('view-user-management')
                    <li class="{{ active_class(Active::checkUriPattern('admin/access/user*')) }}">
                        <a href="{{ route('admin.access.user.index') }}">
                            <span>{{ trans('labels.backend.access.users.management') }}</span>
                        </a>
                    </li>
                    @endauth
                    @permission('view-role-management')
                    <li class="{{ active_class(Active::checkUriPattern('admin/access/role*')) }}">
                        <a href="{{ route('admin.access.role.index') }}">
                            <span>{{ trans('labels.backend.access.roles.management') }}</span>
                        </a>
                    </li>
                    @endauth
                    @permission('view-permission-management')
                    <li class="{{ active_class(Active::checkUriPattern('admin/access/permission*')) }}">
                        <a href="{{ route('admin.access.permission.index') }}">
                            <span>{{ trans('labels.backend.access.permissions.management') }}</span>
                        </a>
                    </li>
                    @endauth
                </ul>
            </li>
            @endauth

            @permission('view-partners-management')
            <li class="{{ active_class(Active::checkUriPattern('admin/partners/*')) }} treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>On-Boarding (Partners)</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/partners/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/partners*'), 'display: block;') }}">
                    @permission('view-partners-management')
                    <li class="{{ active_class(Active::checkUriPattern('admin/partners')) }}">
                        <a href="{{ route('admin.partners.index') }}">
                            <span>New</span>
                        </a>
                    </li>
                    @endauth
                    @permission('view-partnerspending-management')
                    <li class="{{ active_class(Active::checkUriPattern('admin/partners/pending*')) }}">
                        <a href="{{ route('admin.partners.pending') }}">
                            <span>Pending</span>
                        </a>
                    </li>
                    @endauth
                    @permission('view-partnersconfirm-management')
                    <li class="{{ active_class(Active::checkUriPattern('admin/partners/confirm*')) }}">
                        <a href="{{ route('admin.partners.confirm') }}">
                            <span>Confirmed</span>
                        </a>
                    </li>
                    @endauth
                    @permission('view-partnershistory-management')
                    <li class="{{ active_class(Active::checkUriPattern('admin/partners/history*')) }}">
                        <a href="{{ route('admin.partners.history') }}">
                            <span>History</span>
                        </a>
                    </li>
                    @endauth
                </ul>
            </li>
            @endauth

            
            @permission('view-partnersinformation-management')
            <li class="{{ active_class(Active::checkUriPattern('admin/userlists*')) }} treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>Users & Partners Information</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/userlists*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/userlists*'), 'display: block;') }}">
                    @permission('view-userlists-management')
                    <li class="{{ active_class(Active::checkUriPattern('admin/userlists')) }}">
                        <a href="{{ route('admin.userlists.index') }}">
                            <span>User List</span>
                        </a>
                    </li>
                    @endauth
                    @permission('view-partnerlists-management')
                    <li class="{{ active_class(Active::checkUriPattern('admin/partnerlists')) }}">
                        <a href="{{ route('admin.partnerlists.index') }}">
                            <span>Partner List</span>
                        </a>
                    </li>
                    @endauth
                </ul>
            </li>
            @endauth


            @permission('view-logistics-management')
            <li class="{{ active_class(Active::checkUriPattern('admin/partnerredemption/*')) }} treeview">
                <a href="#">
                    <i class="fa fa-truck"></i>
                    <span>Logistics</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/partnerredemption/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/partnerredemption*'), 'display: block;') }}">
                @permission('view-partnerredemption-management')
                    <li class="{{ active_class(Active::checkUriPattern('admin/partnerredemption/*')) }} treeview">
                    <a href="#">
                        <i class="fa fa-users"></i>
                        <span>Partner Redemption</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                        <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/partnerredemption/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/partnerredemption*'), 'display: block;') }}">
                            
                            @permission('view-partnerredemption-management')
                            <li class="{{ active_class(Active::checkUriPattern('admin/partnerredemptions/*')) }}">
                                <a href="{{ route('admin.partnerredemptions.index') }}">
                                    <span>Pending List</span>
                                </a>
                            </li>
                            @endauth
                            @permission('view-partnerredemption-management')
                            <li class="{{ active_class(Active::checkUriPattern('admin/partnerlists')) }}">
                                <a href="{{ route('admin.partnerredemptions.history') }}">
                                    <span>History List</span>
                                </a>
                            </li>
                            @endauth
                        </ul>
                    </li>
                @endauth
                </ul>
                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/access/*'), 'menu-open') }}" style=" {{ active_class(Active::checkUriPattern('admin/partners*'), 'display: block;') }}">
                @permission('view-access-management')
                    <li class="{{ active_class(Active::checkUriPattern('admin/access/*')) }} treeview">
                    <a href="#">
                        <i class="fa fa-users"></i>
                        <span>Partner On-Boarding</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                        <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/access/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/partners*'), 'display: block;') }}">
                            
                            @permission('view-user-management')
                            <li class="{{ active_class(Active::checkUriPattern('admin/userlists')) }}">
                                <a href="{{ route('admin.partnerredemptions.onbording') }}">
                                    <span>Pending List</span>
                                </a>
                            </li>
                            @endauth
                            @permission('view-role-management')
                            <li class="{{ active_class(Active::checkUriPattern('admin/partnerlists')) }}">
                                <a href="{{ route('admin.partnerredemptions.onbordinghistory') }}">
                                    <span>History List</span>
                                </a>
                            </li>
                            @endauth
                        </ul>
                    </li>
                @endauth
                </ul>
            </li>
            @endauth

            @permission('view-access-management')
            <li class="{{ active_class(Active::checkUriPattern('admin/loudhailers*')) }} treeview">
                <a href="#">
                    <i class="fa fa-bell"></i>
                    <span>Loud Hailer / Marketing</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/loudhailers*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/loudhailers*'), 'display: block;') }}">
                    @permission('view-user-management')
                    <li class="{{ active_class(Active::checkUriPattern('admin/loudhailers')) }}">
                        <a href="{{ route('admin.loudhailers.index') }}">
                            <span>Notifications</span>
                        </a>
                    </li>
                    @endauth
                    @permission('view-role-management')
                    <li class="{{ active_class(Active::checkUriPattern('admin/loudhailers/sendmail')) }}">
                        <a href="{{ route('admin.loudhailers.sendmail') }}">
                            <span>E-Mail</span>
                        </a>
                    </li>
                    @endauth
                </ul>
            </li>
            @endauth

            @permission('view-access-management')
            <li class="{{ active_class(Active::checkUriPattern('admin/revenues*')) }} treeview">
                <a href="#">
                    <i class="fa fa-dollar"></i>
                    <span>Finance & Procurement</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/revenues*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/revenues*'), 'display: block;') }}">
                    @permission('view-access-management')
                    <li class="{{ active_class(Active::checkUriPattern('admin/revenues*')) }} treeview">
                    <a href="#">
                        <i class="fa fa-money"></i>
                        <span>Revenue</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                        <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/revenues/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/revenues*'), 'display: block;') }}">
                          
                            @permission('view-role-management')
                            <li class="{{ active_class(Active::checkUriPattern('admin/revenues')) }}">
                                <a href="{{ route('admin.revenues.index') }}">
                                    <span>Partner On-boarding</span>
                                </a>
                            </li>
                            @endauth
                            @permission('view-role-management')
                            <li class="{{ active_class(Active::checkUriPattern('admin/revenues/userbooking')) }}">
                                <a href="{{ route('admin.revenues.userbooking') }}">
                                    <span>User Bookings</span>
                                </a>
                            </li>
                            @endauth
                           
                        </ul>
                    </li>
                @endauth
                </ul>
                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/liabilities*'), 'menu-open') }}" style="{{ active_class(Active::checkUriPattern('admin/liabilities*'), 'display: block;') }}">
                    @permission('view-access-management')
                    <li class="{{ active_class(Active::checkUriPattern('admin/revenues*')) }} treeview">
                    <a href="#">
                        <i class="fa fa-money"></i>
                        <span>Liability</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                        <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/liabilities/*'), 'menu-open') }}" style="{{ active_class(Active::checkUriPattern('admin/liabilities*'), 'display: block;') }}">
                          
                            @permission('view-role-management')
                            <li class="{{ active_class(Active::checkUriPattern('admin/liabilities')) }}">
                                <a href="{{ route('admin.liabilities.index') }}">
                                    <span>Partner Earnings</span>
                                </a>
                            </li>
                            @endauth
                            <!-- @permission('view-role-management')
                            <li class="{{ active_class(Active::checkUriPattern('admin/liabilities/userbooking')) }}">
                                <a href="{{ route('admin.revenues.userbooking') }}">
                                    <span>Refunded List</span>
                                </a>
                            </li>
                            @endauth -->
                           
                        </ul>
                    </li>
                @endauth
                </ul>
                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/expenditures*'), 'menu-open') }}" style="{{ active_class(Active::checkUriPattern('admin/expenditures*'), 'display: block;') }}">
                    @permission('view-access-management')
                    <li class="{{ active_class(Active::checkUriPattern('admin/expenditures*')) }} treeview">
                    <a href="#">
                        <i class="fa fa-money"></i>
                        <span>expenditures</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                        <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/expenditures/*'), 'menu-open') }}" style="{{ active_class(Active::checkUriPattern('admin/expenditures*'), 'display: block;') }}">
                            @permission('view-role-management')
                            <li class="{{ active_class(Active::checkUriPattern('admin/expenditures')) }}">
                                <a href="{{ route('admin.expenditures.index') }}">
                                    <span>Promo Codes</span>
                                </a>
                            </li>
                            @endauth
                            @permission('view-role-management')
                            <li class="{{ active_class(Active::checkUriPattern('admin/expenditures/*')) }}">
                                <a href="{{ route('admin.expenditures.userreward') }}">
                                    <span>User Rewards</span>
                                </a>
                            </li>
                            @endauth
                            @permission('view-role-management')
                            <li class="{{ active_class(Active::checkUriPattern('admin/expenditures/*')) }}">
                                <a href="{{ route('admin.expenditures.partnerredemptions') }}">
                                    <span>Partner Redemptions</span>
                                </a>
                            </li>
                            @endauth
                           
                        </ul>
                    </li>
                @endauth
                </ul>
            </li>
            @endauth

            @permission('view-access-management')
            <li class="{{ active_class(Active::checkUriPattern('admin/system*')) }} treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>IT / System</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/system//*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/system*'), 'display: block;') }}">
                    @permission('view-user-management')
                    <li class="{{ active_class(Active::checkUriPattern('admin/system/promocodes')) }}">
                        <a href="{{ route('admin.promocodes.index') }}">
                            <span>Promo codes</span>
                        </a>
                    </li>
                    @endauth
                    @permission('view-user-management')
                    <li class="{{ active_class(Active::checkUriPattern('admin/system/promocodes')) }}">
                        <a href="{{ route('admin.userpricings.index') }}">
                            <span>UserPricing</span>
                        </a>
                    </li>
                    @endauth
                    @permission('view-user-management')
                    <li class="{{ active_class(Active::checkUriPattern('admin/system/promocodes')) }}">
                        <a href="{{ route('admin.partnerpricings.index') }}">
                            <span>Partner Earnings Pricing</span>
                        </a>
                    </li>
                    @endauth
                    @permission('view-access-management')
                    <li class="{{ active_class(Active::checkUriPattern('admin/system/vehicles*')) }} treeview">
                    <a href="#">
                        <i class="fa fa-truck"></i>
                        <span>Vehicle Database & Pricing</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    
                        <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/system/vehicles*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/system/vehicles*'), 'display: block;') }}">
                            
                            @permission('view-user-management')
                            <li class="{{ active_class(Active::checkUriPattern('admin/system/vehicles/brand*')) }}">
                                <a href="{{ route('admin.vehicles.brand') }}">
                                    <span>Add Brand</span>
                                </a>
                            </li>
                            @endauth
                            @permission('view-role-management')
                            <li class="{{ active_class(Active::checkUriPattern('admin/system/vehicles/create')) }}">
                                <a href="{{ route('admin.vehicles.create') }}">
                                    <span>Add Model</span>
                                </a>
                            </li>
                            @endauth
                            @permission('view-role-management')
                            <li class="{{ active_class(Active::checkUriPattern('admin/system/vehicles/vehicaltype')) }}">
                                <a href="{{ route('admin.vehicles.vehicaltype') }}">
                                    <span>Add Vehicle Type</span>
                                </a>
                            </li>
                            @endauth
                            @permission('view-role-management')
                            <li class="{{ active_class(Active::checkUriPattern('admin/system/vehicles')) }}">
                                <a href="{{ route('admin.vehicles.index') }}">
                                    <span>Vehicle List</span>
                                </a>
                            </li>
                            @endauth
                        </ul>
                    </li>
                @endauth


                </ul>
            </li>
            @endauth


            @permission('view-access-management')
            <li class="{{ active_class(Active::checkUriPattern('admin/system*')) }} treeview">
                <a href="#">
                    <i class="fa fa-question-circle"></i>
                    <span>Policies and FAQs</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/system//*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/system*'), 'display: block;') }}">
                    
                    @permission('view-access-management')
                    <li class="{{ active_class(Active::checkUriPattern('admin/system/vehicles*')) }} treeview">
                    <a href="#">
                        <i class="fa fa-truck"></i>
                        <span>T&C and Policies</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    
                        <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/system/vehicles*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/system/vehicles*'), 'display: block;') }}">
                            
                            @permission('view-user-management')
                            <li class="{{ active_class(Active::checkUriPattern('admin/system/vehicles/brand*')) }}">
                                <a href="{{ url('admin/policies/1') }}">
                                    <span>Terms & Conditions</span>
                                </a>
                            </li>
                            @endauth
                            @permission('view-role-management')
                            <li class="{{ active_class(Active::checkUriPattern('admin/system/vehicles/create')) }}">
                                <a href="{{ url('admin/policies/2') }}">
                                    <span>Privacy Policy</span>
                                </a>
                            </li>
                            @endauth
                            @permission('view-role-management')
                            <li class="{{ active_class(Active::checkUriPattern('admin/system/vehicles/vehicaltype')) }}">
                                <a href="{{ url('admin/policies/3') }}">
                                    <span>Partner Code of Conduct</span>
                                </a>
                            </li>
                            @endauth
                            @permission('view-role-management')
                            <li class="{{ active_class(Active::checkUriPattern('admin/system/vehicles')) }}">
                                <a href="{{ route('admin.rewardstcs.index') }}">
                                    <span>User Rewards T&amp;C</span>
                                </a>
                            </li>
                            @endauth
                        </ul>
                    </li>
                @endauth
                    @permission('view-access-management')
                    <li class="{{ active_class(Active::checkUriPattern('admin/system/vehicles*')) }} treeview">
                    <a href="#">
                        <i class="fa fa-question"></i>
                        <span>Frequently Asked Questions (FAQ)</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    
                        <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/system/vehicles*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/system/vehicles*'), 'display: block;') }}">
                            
                            @permission('view-user-management')
                            <li class="{{ active_class(Active::checkUriPattern('admin/system/vehicles/brand*')) }}">
                                <a href="{{ route('admin.faqs.index') }}">
                                    <span>User Help Centre (FAQ)</span>
                                </a>
                            </li>
                            @endauth
                            @permission('view-role-management')
                            <li class="{{ active_class(Active::checkUriPattern('admin/system/vehicles/create')) }}">
                                <a href="{{ route('admin.partnerfaqs.index') }}">
                                    <span>Partner Support (FAQ)</span>
                                </a>
                            </li>
                            @endauth
                        </ul>
                    </li>
                @endauth


                </ul>
            </li>
            @endauth
        </ul><!-- /.sidebar-menu -->
    </section><!-- /.sidebar -->
</aside>