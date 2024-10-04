<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu tree" data-widget="tree">
            <li class="">
                <a href="{{ url('/controlpanel') }}">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="">
                <a href="{{ url('controlpanel/user-list') }}">
                    <i class="fa fa-user"></i>
                    <span>User</span>
                </a>
            </li>

          
            <li class="">
                <a href="{{ url('controlpanel/review-list') }}">
                    <i class="fa fa-check-circle"></i>
                    <span>Offer/receive Profile Review</span>
                </a>
            </li>

            <li class="">
                <a href="{{ url('controlpanel/import-users') }}">
                    <i class="fa fa-users"></i>
                    <span>Import users</span>
                </a>
            </li>
            <li class="">
                <a href="{{ url('controlpanel/bid-list') }}">
                    <i class="fa fa-gavel" aria-hidden="true"></i>
                    <span>Bids</span>
                </a>
            </li>
            <li class="">
                <a href="{{ url('controlpanel/opportunity-list') }}">
                    <i class="fa fa-tasks" aria-hidden="true"></i>
                    <span>Opportunities</span>
                </a>
            </li>
            <li class="">
                <a href="{{ url('controlpanel/codes') }}">
                    <i class="fa fa-dollar" aria-hidden="true"></i>
                    <span>Vouch Codes</span>
                </a>
            </li>
            <li class="">
                <a href="{{ url('controlpanel/redeem-request') }}">
                    <i class="fa fa-gift" aria-hidden="true"></i>
                    <span>Redeem Request</span>
                </a>
            </li>

            <li class="treeview">
                <a href="#">
                <i class="fa fa-dashboard"></i> <span>Marketplace</span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                <li class="">
                <a href="{{ url('controlpanel/partners') }}">
                    <i class="fa fa-handshake-o" aria-hidden="true"></i>
                    <span>Partners</span>
                </a>
            </li>
            <li class="">
                <a href="{{ url('controlpanel/offers') }}">
                    <i class="fa fa-gift" aria-hidden="true"></i>
                    <span>Offers</span>
                </a>
            </li>

            <li class="">
                <a href="{{ url('controlpanel/offers-opt') }}">
                    <i class="fa fa-gift" aria-hidden="true"></i>
                    <span>Offers Opt</span>
                </a>
            </li>
               
                </ul>
                </li>

          
            <li class="">
                <a href="{{ url('controlpanel/partner-review-list') }}">
                    <i class="fa fa-check"></i>
                    <span>Partner Profile Review</span>
                </a>
            </li>
         
            <li class="">
                <a href="{{ url('controlpanel/events') }}">
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                    <span>Events</span>
                </a>
            </li>
            <li class="">
                <a href="{{ url('controlpanel/collaborates') }}">
                    <i class="fa fa-handshake-o" aria-hidden="true"></i>
                    <span>Collaborates</span>
                </a>
            </li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
