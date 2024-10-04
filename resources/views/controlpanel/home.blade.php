@extends('adminlte::page')
<!--Add title-->
@section('title',  'Ayojn')
<!--Main Body content-->
@section('content')
    <?php
    use App\User;
    $incompleteCount = User::whereNull('sponsor_for')->where('id', '!=', Auth::user()->id)->get()->count();
    $inCompleteofferCount = User::whereNull('sponsor_for')->where('sponsor_type', '=', '1')
        ->where('id', '!=', Auth::user()->id)->get()->count();
    $inCompleteSponsorCount = User::whereNull('sponsor_for')->where('sponsor_type', '=', '2')
        ->where('id', '!=', Auth::user()->id)->get()->count();
    $userCount = User::where('sponsor_type', '!=', '3')->where('is_edited', 1)->get()->count();
    $partnerUserCount = User::where('sponsor_type', '=', '3')->where('is_edited', 1)->get()->count();
    ?>
    <!-- //banner-top -->
    <!-- banner -->
    <!-- Content Header (Page header) -->
    <style type="text/css">
        .mb20 {
            margin-bottom: 20px;
        }

        .checkbox {
            margin-top: 0px;
        }
    </style>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-4 col-sm-6 col-xs-12">
                <a href="{{ url('/controlpanel/user-list?type=offer')}}">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="ion ion-ios-people-outline"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Offer</span>
                            <span class="info-box-number">{{$inCompleteofferCount}}/{{ $offercount }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-4 col-sm-6 col-xs-12">
                <a href="{{ url('/controlpanel/user-list?type=manage')}}">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Manage </span>
                            <span class="info-box-number">{{$inCompleteSponsorCount}}/{{ $managecount }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>

            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-4 col-sm-6 col-xs-12">
                <a href="{{ url('/controlpanel/user-list?type=incomplete')}}">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="ion ion-ios-people-outline"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Incomplete </span>
                            <span class="info-box-number">{{ $incompleteCount }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>

            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-4 col-sm-6 col-xs-12">
                <a href="{{ url('controlpanel/review-list')}}">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="ion ion-ios-people-outline"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total User Updates </span>
                            <span class="info-box-number">{{ $userCount }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-4 col-sm-6 col-xs-12">
                <a href="{{ url('controlpanel/partner-review-list')}}">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Partner Updates </span>
                            <span class="info-box-number">{{ $partnerUserCount }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        {{--@if(Auth::user()->role_id != 4)--}}
        {{--@endif--}}
        <!-- /.col -->
        </div>
    </section>

@endsection
