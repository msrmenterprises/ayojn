<!-- navigation bar start -->
<!-- Fixed navbar -->
<style>
.modal {
        top: 30px !important;
    }
.main-nav li a {
         margin: 23px 10px 0px !important;
    }
</style>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<div class="overflowmob"></div>
<header class="flw site-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <a href="{{ url('/')}}" class="pull-left logo">
                    <img src="{{ asset('images/n-logo.png') }}"  />

                </a>
                <div class="navbar-default">
                    <button type="button" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="mobile-nav-final">
                    <a class="closed navbar-toggle"><img src="{{ asset('images/close.png') }}"></a>

                    @if(Auth::guest())

                        <ul class="pull-right main-nav">
                            <li class="{{ (request()->path() == '/') ? 'active' : '' }}"><a href="{{ url('/') }}">
                                    Home</a></li>
                            <!-- <li class="{{ (request()->path() == 'expertise') ? 'active' : '' }}"><a
                                    href="{{ url('expertise') }}"> Expertise</a></li>
                            <li class="{{ (request()->path() == 'focus') ? 'active' : '' }}"><a
                                    href="{{ url('focus') }}"> Focus</a></li>
                            <li class="{{ (request()->path() == 'solutions') ? 'active' : '' }}"><a
                                    href="{{ url('solutions') }}"> Solutions</a></li>
                            <li class="{{ (request()->path() == 'partners') ? 'active' : '' }}"><a
                                    href="{{ url('partners') }}"> Partners</a></li>
                            <li class="{{ (request()->path() == 'stories') ? 'active' : '' }}"><a
                                    href="{{ url('stories') }}"> Success Stories</a></li> -->
                        <!--<li class="{{ (request()->path() == 'connect') ? 'active' : '' }}"><a
                                        href="{{ url('events') }}">Events</a></li> -->
                            <!-- <li class="{{ (request()->path() == 'connect') ? 'active' : '' }}"><a
                                    href="{{ url('connect') }}"> Connect</a></li> -->
                            <li><a style="margin-top: 8px !important;" href="javascript:void(0)" class="btn btn-primary-new" data-toggle="modal"
                                   data-target="#signupForm"> Sign Up</a></li>
                            <li><a href="javascript:void(0)" data-toggle="modal" data-target="#loginForm"> Log In</a>
                            </li>


                        </ul>

                    @else
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                           class="pull-right login-button">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>

                        <ul class="pull-right main-nav">

                            @if(Auth::user()->userstatus == 1 && Auth::user()->is_suspend != 1)
                                @if((Auth::user()->sponsor_type == 1 || Auth::user()->sponsor_type == 2) &&strtotime(Auth::user()->disapprove_time) <= strtotime(Carbon\Carbon::now()->toDateTimeString()))
                                {{--                                    <li><a href="javascript:void(0)" onclick="openreferafriend()">RECOMMEND</a></li>--}}
                                {{--                                    <li><a href="javascript:void(0)"--}}
                                {{--                                           onclick="openEditForm({{ Auth::user()->id }})">PROFILE</a>--}}
                                {{--                                    </li>--}}
                                {{--                                    <li><a href="{{ url('pending-faq') }}">FAQs </a></li>--}}
                                @else
                                    <?php
                                    $userData = Auth::user();
                                    ?>
                                    @if(Auth::user()->sponsor_type == 1)
                                        <li class="menu-hover">
                                            <a href="#">INDEX</a>
                                            <ul>
                                                <li><a href="{{ route('map') }}">Map</a></li>
                                                @if (!empty($userData->sponsor_for) || !empty($userData->likeSponsorr) || !empty($userData->sponsor_budget) || !empty($userData->sponsor_industry) || !empty($userData->sponsor_country))
                                                    <li><a href="javascript:void(0)" onclick="opentop_countries()">Emerging
                                                            From</a>
                                                    </li>
                                                    <li><a href="javascript:void(0)" onclick="opentop_destination()">Directed
                                                            To</a>
                                                    </li>
                                                    <li><a href="javascript:void(0)" onclick="opentop_industries()">Biggest
                                                            Spenders</a>
                                                    </li>
                                                    <li><a href="javascript:void(0)" onclick="opentop_recipients()">Top
                                                            Recipients</a></li>
                                                @endif
                                            </ul>
                                        </li>
                                        <li class="menu-hover">
                                            <a href="#"> OPPORTUNITIES</a>
                                            <ul>
                                                <li><a href="{{ route('opportunity')}}">Browse Opportunities <br/><br/>(Limited
                                                        Use)</a></li>
                                                <li><a href="{{ route('bid') }}">Create Opportunities<br/><br/>
                                                        (Payable)
                                                    </a></li>

                                            </ul>
                                        </li>

                                    @elseif(Auth::user()->sponsor_type == 2)
                                        <li class="menu-hover">
                                            <a href="#">INDEX</a>
                                            <ul>
                                                <li><a href="{{ route('map') }}">Map</a></li>
                                                @if (!empty($userData->sponsor_for) || !empty($userData->sponsor_budget) || !empty($userData->sponsor_country))
                                                    <li><a href="javascript:void(0)" onclick="opentop_countries()">Emerging
                                                            From</a>
                                                    </li>
                                                    <li><a href="javascript:void(0)" onclick="opentop_destination()">Directed
                                                            To</a>
                                                    </li>
                                                    <li><a href="javascript:void(0)" onclick="opentop_industries()">Biggest
                                                            Spenders</a>
                                                    </li>
                                                    <li><a href="javascript:void(0)" onclick="opentop_recipients()">Top
                                                            Recipients</a></li>
                                                @endif
                                            </ul>
                                        </li>
                                        <li class="menu-hover">
                                            <a href="#"> OPPORTUNITIES</a>
                                            <ul>
                                                <li><a href="{{ route('bid') }}">Bid Opportunities <br/><br/>(Limited
                                                        use)</a></li>
                                                <li><a href="{{ route('opportunity')}}">Build Opportunities <br/><br/>(Payable)
                                                    </a>
                                                </li>
                                                <li><a href="{{ route('collaborate') }}">Collaborate<br/><br/>(Free to use)
                                                    </a></li>
                                            </ul>
                                        </li>
                                    @elseif(Auth::user()->sponsor_type == 3)
                                        <li><a href="{{ url('partner/home') }}">MARKETPLACE</a>
                                        </li>
                                    @endif
                                @endif
                            @endif
                                @if(Auth::user()->sponsor_type == 2 && Auth::user()->userstatus != 1)
                                <li class="menu-hover">
                                    <a href="#"> OPPORTUNITIES</a>
                                    <ul>
                                        <li><a href="{{ route('collaborate') }}">Collaborate<br/><br/>(Free to use)
                                            </a></li>
                                    </ul>
                                </li>
                                @endif
                            @if(Auth::user()->sponsor_type != 3)
                                <li><a href="{{ route('poffers') }}">MARKETPLACE </a></li>
                            @endif
                            <li><a href="javascript:void(0)" onclick="openreferafriend()">RECOMMEND </a>
                            <li><a href="{{ url('events') }}">EVENTS </a>
                            </li>
                            <li class="menu-hover">
                                <a href="#">ACCOUNT</a>
                                <ul>
                                    <li><a href="javascript:void(0)"
                                           onclick="openEditForm({{ Auth::user()->id }})">PROFILE</a></li>
                                    <li><a href="{{ route('notification-settings') }}">Notification Settings</a></li>
                                    <!--add by ram 29 sep -->
                                    <li><a href="{{ route('marketplace-history') }}">Marketplace History</a></li>
                                    <li><a href="{{ route('wallet-history') }}">Wallet Log</a></li>

                                </ul>
                            </li>
                            {{--                            <li><a href="javascript:void(0)"--}}
                            {{--                                   onclick="openEditForm({{ Auth::user()->id }})">PROFILE</a>--}}
                            {{--                            </li>--}}
                            @if(Auth::user()->sponsor_type == 1)
                                <li><a href="{{ url('/offer/faq') }}">FAQs </a></li>
                            @elseif(Auth::user()->sponsor_type == 2)
                                <li><a href="{{ url('receive/faq') }}">FAQs </a></li>
                            @elseif(Auth::user()->sponsor_type == 3)
                                <li><a href="{{ url('partner-faqs') }}">FAQs </a></li>
                            @endif
                        <!--<li><a href="{{ url('/DOOH') }}">DOOH </a></li> -->

                            <?php
                            $notifications = Test::where('in_app', 1)->where('is_read', 0)
                                ->where('user_id', Auth::user()->id)->limit(15)
                                ->orderBy('id', 'desc')->get();
                            ?>


                            <li class="dropdown">
                                <a href="{{ route('cart') }}" style="position: relative;"> <i class="fa fa-shopping-cart"></i> <span
                                        class="nober">{{ count((array) session('cart')) }}</span></a>
                            
                            </li>


                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-haspopup="true" aria-expanded="false"> <i class="fa fa-bell"></i> <span
                                        class="nober">{{ $notifications->count() }}</span></a>
                                <ul class="dropdown-menu notify-drop">
                                    <div class="notify-drop-title">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-6">Notifications
                                                (<b>{{ $notifications->count() }}</b>)
                                            </div>

                                        </div>
                                    </div>
                                    <!-- end notify title -->
                                    <!-- notify content -->
                                    <div class="drop-content">
                                        @if(!empty($notifications->first()))
                                            @foreach($notifications as $notification)
                                                <li>

                                                    <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 ">
                                                        <p>{{ strip_tags($notification->message) }}
                                                            <br>
                                                            @if(Auth::user()->userstatus == 1)<a
                                                                href="{{ $notification->link }}"
                                                                onclick="updateStatusNotification({{ $notification->id }})">view</a>@endif
                                                        </p>

                                                    </div>
                                                </li>
                                            @endforeach
                                        @endif

                                    </div>
                                    {{--                                        <div class="notify-drop-footer text-center">--}}
                                    {{--                                            <a href=""><i class="fa fa-eye"></i> View All</a>--}}
                                    {{--                                        </div>--}}
                                </ul>
                            </li>

                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</header>
<script>
    $(function () {
        $('[data-tooltip="tooltip"]').tooltip()
    });

    $(".dropdown-toggle").click(function () {
        $(".notify-drop").toggle();
    });

    function updateStatusNotification(id) {
        $.ajax({
            type: 'POST',
            url: '{{ route('update-status-notification') }}',
            headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
            data: {
                id: id
            },
            success: function (response) {
            },
            error: function (response) {
                toastr.error(response.responseJSON.msg, "Error");
                $(':input[type="submit"]').prop('disabled', false);
            },
        });
    }
</script>

