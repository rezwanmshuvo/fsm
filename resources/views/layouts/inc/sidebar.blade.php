<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md custom-secondery-bg">

    <!-- Sidebar mobile toggler -->
    <div class="sidebar-mobile-toggler text-center">
        <a href="#" class="sidebar-mobile-main-toggle">
            <i class="icon-arrow-left8"></i>
        </a>
        Navigation
        <a href="#" class="sidebar-mobile-expand">
            <i class="icon-screen-full"></i>
            <i class="icon-screen-normal"></i>
        </a>
    </div>
    <!-- /sidebar mobile toggler -->


    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-user">
            <div class="card-body">
                <div class="media">
                    <div class="mr-3">
                        <a href="#"><img src="{{ asset('assets/global_assets/images/demo/users/face11.jpg') }}" width="38" height="38" class="rounded-circle" alt=""></a>
                    </div>

                    <div class="media-body">
                        <div class="media-title font-weight-semibold">Admin</div>
                        <div class="font-size-xs opacity-50">
                            <i class="icon-pin font-size-sm"></i> &nbsp;Dhaka, Bangladesh
                        </div>
                    </div>

                    <div class="ml-3 align-self-center">
                        <a href="#" class="text-white"><i class="icon-cog3"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /user menu -->


        <!-- Main navigation -->
        <div class="card card-sidebar-mobile">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <!-- Basic Structure -->
                <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Basic Structure</div> <i class="icon-menu" title="Main"></i></li>
                <li class="nav-item nav-item-submenu {{ (request()->is('form') || request()->is('table') || request()->is('report-table')) ? 'nav-item-open' : ''}}">
                    <a href="#" class="nav-link"><i class="icon-grid6"></i> <span>Basic</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="Level One" style="{{ (request()->is('form') || request()->is('table') || request()->is('report-table')) ? 'display:block' : ''}}">
                        <li class="nav-item">
                            <a href="{{ route('form') }}" class="nav-link {{ (request()->is('form')) ? 'active' : ''}}">
                                <i class="icon-width"></i>
                                <span>Basic Form</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('table') }}" class="nav-link {{ (request()->is('table')) ? 'active' : ''}}">
                                <i class="icon-width"></i>
                                <span>Basic Data Table</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('report-table') }}" class="nav-link {{ (request()->is('report-table')) ? 'active' : ''}}">
                                <i class="icon-width"></i>
                                <span>Report Table</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ (request()->is('dashboard')) ? 'active' : ''}}">
                        <i class="icon-home4"></i>
                        <span>
                            Dashboard
                        </span>
                    </a>
                </li>
                <!-- /main -->

                <!-- Page kits -->
                <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">System Menus</div> <i class="icon-menu" title="System Menus"></i></li>
                {{-- @include('layouts.inc.disabled') --}}

                <!-- People -->
                <li class="nav-item nav-item-submenu {{ (request()->is('customer*') || request()->is('supplier*')) ? 'nav-item-open':'' }}">
                    <a href="#" class="nav-link"><i class="icon-users"></i> <span>People</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="Level One" {{ (request()->is('customer*') || request()->is('supplier*')) ? 'style=display:block;':'' }}>
                        <li class="nav-item">
                            <a href="{{ route('customer.index') }}" class="nav-link {{ (request()->is('customer*')) ? 'active':'' }}">
                                <i class="icon-arrow-right22"></i>
                                <i class="icon-arrow-right22 sidebar-icon-custom-margin"></i>
                                <span>Customers</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('supplier.index') }}" class="nav-link {{ (request()->is('supplier*')) ? 'active':'' }}">
                                <i class="icon-arrow-right22"></i>
                                <i class="icon-arrow-right22 sidebar-icon-custom-margin"></i>
                                <span>Suppliers</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Product -->
                <li class="nav-item nav-item-submenu {{ (request()->is('item_category*') || request()->is('item*')) ? 'nav-item-open':'' }}">
                    <a href="#" class="nav-link"><i class="icon-box"></i> <span>Product</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="Level One" {{ (request()->is('item_category*') || request()->is('item*')) ? 'style=display:block;':'' }}>
{{--                        <li class="nav-item">--}}
{{--                            <a href="#" class="nav-link {{ (request()->is('item_category*')) ? 'active':'' }}">--}}
{{--                                <i class="icon-arrow-right22"></i>--}}
{{--                                <i class="icon-arrow-right22 sidebar-icon-custom-margin"></i>--}}
{{--                                <span>Item Category</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
                        <li class="nav-item">
                            <a href="{{ route('item.index') }}" class="nav-link {{ (request()->is('item*')) ? 'active':'' }}">
                                <i class="icon-arrow-right22"></i>
                                <i class="icon-arrow-right22 sidebar-icon-custom-margin"></i>
                                <span>Items</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- PUMP Master -->
                <li class="nav-item nav-item-submenu {{ (request()->is('shift*') || request()->is('tank*')) || (request()->is('machine*')) || (request()->is('nozzle*')) ? 'nav-item-open':'' }}">
                    <a href="#" class="nav-link"><i class="icon-gas"></i> <span>Pump Master</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="Level One" {{ (request()->is('shift*') || request()->is('tank*')) || (request()->is('machine*')) || (request()->is('nozzle*')) ? 'style=display:block;':'' }}>
                        <li class="nav-item">
                            <a href="{{route('shift.index')}}" class="nav-link {{ (request()->is('shift*')) ? 'active':'' }}">
                                <i class="icon-arrow-right22"></i>
                                <i class="icon-arrow-right22 sidebar-icon-custom-margin"></i>
                                <span>Shift</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('tank.index')}}" class="nav-link {{ (request()->is('tank*')) ? 'active':'' }}">
                                <i class="icon-arrow-right22"></i>
                                <i class="icon-arrow-right22 sidebar-icon-custom-margin"></i>
                                <span>Tank</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('machine.index')}}" class="nav-link {{ (request()->is('machine*')) ? 'active':'' }}">
                                <i class="icon-arrow-right22"></i>
                                <i class="icon-arrow-right22 sidebar-icon-custom-margin"></i>
                                <span>Machine</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('nozzle.index')}}" class="nav-link {{ (request()->is('nozzle*')) ? 'active':'' }}">
                                <i class="icon-arrow-right22"></i>
                                <i class="icon-arrow-right22 sidebar-icon-custom-margin"></i>
                                <span>Nozzle</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Transaction -->
                <li class="nav-item nav-item-submenu {{ (request()->is('purchase*') || request()->is('sales*')) || (request()->is('meterReading*')) || (request()->is('dipReading*')) ? 'nav-item-open':'' }}">
                    <a href="#" class="nav-link"><i class="icon-cart"></i> <span>Transaction</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="Level One" {{ (request()->is('purchase*') || request()->is('sales*')) || (request()->is('meterReading*')) || (request()->is('dipReading*')) ? 'style=display:block;':'' }}>
                        <li class="nav-item">
                            <a href="{{route('purchase.index')}}" class="nav-link {{ (request()->is('purchase*')) ? 'active':'' }}">
                                <i class="icon-arrow-right22"></i>
                                <i class="icon-arrow-right22 sidebar-icon-custom-margin"></i>
                                <span>Purchase</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('sale.index')}}" class="nav-link {{ (request()->is('sales*')) ? 'active':'' }}">
                                <i class="icon-arrow-right22"></i>
                                <i class="icon-arrow-right22 sidebar-icon-custom-margin"></i>
                                <span>Sells</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ (request()->is('meterReading*')) ? 'active':'' }}">
                                <i class="icon-arrow-right22"></i>
                                <i class="icon-arrow-right22 sidebar-icon-custom-margin"></i>
                                <span>Meter Reading</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ (request()->is('dipReading*')) ? 'active':'' }}">
                                <i class="icon-arrow-right22"></i>
                                <i class="icon-arrow-right22 sidebar-icon-custom-margin"></i>
                                <span>Dip Reading</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Accounts -->
                <li class="nav-item nav-item-submenu {{ (request()->is('bank*') || request()->is('purpose*') || request()->is('deposit*') || request()->is('withdraw*') || request()->is('transfer*')) ? 'nav-item-open':'' }}">
                    <a href="#" class="nav-link"><i class="icon-library2"></i> <span>Accounts</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="Level One" {{ (request()->is('bank*') || request()->is('purpose*') || request()->is('deposit*') || request()->is('withdraw*') || request()->is('transfer*')) ? 'style=display:block;':'' }}>
                        <li class="nav-item">
                            <a href="{{ route('bank.index') }}" class="nav-link {{ (request()->is('bank*')) ? 'active':'' }}">
                                <i class="icon-arrow-right22"></i>
                                <i class="icon-arrow-right22 sidebar-icon-custom-margin"></i>
                                <span>Banks</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('purpose.index') }}" class="nav-link {{ (request()->is('purpose*')) ? 'active':'' }}">
                                <i class="icon-arrow-right22"></i>
                                <i class="icon-arrow-right22 sidebar-icon-custom-margin"></i>
                                <span>Purposes</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('deposit.index') }}" class="nav-link {{ (request()->is('deposit*')) ? 'active':'' }}">
                                <i class="icon-arrow-right22"></i>
                                <i class="icon-arrow-right22 sidebar-icon-custom-margin"></i>
                                <span>Deposit</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('withdraw.index') }}" class="nav-link {{ (request()->is('withdraw*')) ? 'active':'' }}">
                                <i class="icon-arrow-right22"></i>
                                <i class="icon-arrow-right22 sidebar-icon-custom-margin"></i>
                                <span>Withdraw</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('transfer.index') }}" class="nav-link {{ (request()->is('transfer*')) ? 'active':'' }}">
                                <i class="icon-arrow-right22"></i>
                                <i class="icon-arrow-right22 sidebar-icon-custom-margin"></i>
                                <span>Transfer</span>
                            </a>
                        </li>
                    </ul>
                </li>




                <!-- Reports -->

                <li class="nav-item nav-item-submenu {{ (request()->is('reports/bank-statement*') || request()->is('reports/deposit*') || request()->is('reports/withdraw*') || request()->is('reports/customer-ledger*')) ? 'nav-item-open':'' }}">
                    <a href="#" class="nav-link"><i class="icon-file-stats"></i> <span>Reports</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="Level One" {{ (request()->is('reports/bank-statement*') || request()->is('reports/deposit*') || request()->is('reports/withdraw*') || request()->is('reports/customer-ledger*')) ? 'style=display:block;':'' }}>
                        <li class="nav-item">
                            <a href="{{ route('reports.bank-statement') }}" class="nav-link {{ (request()->is('reports/bank-statement*')) ? 'active':'' }}">
                                <i class="icon-arrow-right22"></i>
                                <i class="icon-arrow-right22 sidebar-icon-custom-margin"></i>
                                <span>Bank Statement</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('reports.deposit') }}" class="nav-link {{ (request()->is('reports/deposit*')) ? 'active':'' }}">
                                <i class="icon-arrow-right22"></i>
                                <i class="icon-arrow-right22 sidebar-icon-custom-margin"></i>
                                <span>Deposit Report</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('reports.withdraw') }}" class="nav-link {{ (request()->is('reports/withdraw*')) ? 'active':'' }}">
                                <i class="icon-arrow-right22"></i>
                                <i class="icon-arrow-right22 sidebar-icon-custom-margin"></i>
                                <span>Withdraw Report</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('withdraw.index') }}" class="nav-link {{ (request()->is('withdraw*')) ? 'active':'' }}">
                                <i class="icon-arrow-right22"></i>
                                <i class="icon-arrow-right22 sidebar-icon-custom-margin"></i>
                                <span>Sales Statement</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('withdraw.index') }}" class="nav-link {{ (request()->is('withdraw*')) ? 'active':'' }}">
                                <i class="icon-arrow-right22"></i>
                                <i class="icon-arrow-right22 sidebar-icon-custom-margin"></i>
                                <span>Purchase Statement</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('reports.customer-ledger') }}" class="nav-link {{ (request()->is('reports/customer-ledger*')) ? 'active':'' }}">
                                <i class="icon-arrow-right22"></i>
                                <i class="icon-arrow-right22 sidebar-icon-custom-margin"></i>
                                <span>Customer Ledger</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('transfer.index') }}" class="nav-link {{ (request()->is('transfer*')) ? 'active':'' }}">
                                <i class="icon-arrow-right22"></i>
                                <i class="icon-arrow-right22 sidebar-icon-custom-margin"></i>
                                <span>Suppler Ledger</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Administration -->

                <li class="nav-item nav-item-submenu {{ (request()->is('user*') || request()->is('role*') || request()->is('permission*')) ? 'nav-item-open' : ''}}">
                    <a href="#" class="nav-link"><i class="icon-cog2"></i> <span>Administration</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="Level One" style="{{ (request()->is('user*') || request()->is('role*') || request()->is('permission*')) ? 'display:block' : ''}}">
                        <li class="nav-item">
                            <a href="form" class="nav-link">
                                <i class="icon-arrow-right22"></i>
                                <i class="icon-arrow-right22 sidebar-icon-custom-margin"></i>
                                <span class="hvr-forward">Settings</span>
                            </a>
                        </li>

                        <li class="nav-item nav-item-submenu {{ (request()->is('user*') || request()->is('role*') || request()->is('permission*')) ? 'nav-item-open' : ''}}">
                            <a href="#" class="nav-link">
                                <i class="icon-arrow-right22"></i>
                                <i class="icon-arrow-right22 sidebar-icon-custom-margin"></i>
                                <span>Users</span>
                            </a>
                            <ul class="nav nav-group-sub" style="{{ (request()->is('user*') || request()->is('role*') || request()->is('permission*')) ? 'display:block;' : ''}}">
                                <li class="nav-item">
                                    <a href="{{ route('user.index') }}" class="nav-link {{ (request()->is('user*')) ? 'active' : ''}}" style="padding: .625rem 1.25rem 0.625rem 2.5rem!important;">
                                        <i class="icon-arrow-right22"></i>
                                        <i class="icon-arrow-right22 sidebar-icon-custom-margin"></i>
                                        <span>Users</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('role.index') }}" class="nav-link {{ (request()->is('role*')) ? 'active' : ''}}" style="padding: .625rem 1.25rem 0.625rem 2.5rem!important;">
                                        <i class="icon-arrow-right22"></i>
                                        <i class="icon-arrow-right22 sidebar-icon-custom-margin"></i>
                                        <span>Roles</span>
                                    </a>
                                </li>
                                @if(auth()->user()->hasrole('developer'))
                                    <li class="nav-item">
                                        <a href="{{ route('permission.index') }}" class="nav-link {{ (request()->is('permission*')) ? 'active' : ''}}" style="padding: .625rem 1.25rem 0.625rem 2.5rem!important;">
                                            <i class="icon-arrow-right22"></i>
                                            <i class="icon-arrow-right22 sidebar-icon-custom-margin"></i>
                                            <span>Permissions</span>                                   </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    </ul>
                </li>
                <!-- /page kits -->

            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
