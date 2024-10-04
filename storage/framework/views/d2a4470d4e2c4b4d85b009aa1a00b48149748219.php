<!--Add title-->
<?php $__env->startSection('title',  'Sponsorr'); ?>
<!--Main Body content-->
<?php $__env->startSection('content'); ?>
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
                <a href="<?php echo e(url('/controlpanel/user-list?type=offer')); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="ion ion-ios-people-outline"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Offer</span>
                            <span class="info-box-number"><?php echo e($inCompleteofferCount); ?>/<?php echo e($offercount); ?></span>
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
                <a href="<?php echo e(url('/controlpanel/user-list?type=manage')); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Manage </span>
                            <span class="info-box-number"><?php echo e($inCompleteSponsorCount); ?>/<?php echo e($managecount); ?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>

            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-4 col-sm-6 col-xs-12">
                <a href="<?php echo e(url('/controlpanel/user-list?type=incomplete')); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="ion ion-ios-people-outline"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Incomplete </span>
                            <span class="info-box-number"><?php echo e($incompleteCount); ?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>

            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-4 col-sm-6 col-xs-12">
                <a href="<?php echo e(url('controlpanel/review-list')); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="ion ion-ios-people-outline"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total User Updates </span>
                            <span class="info-box-number"><?php echo e($userCount); ?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-4 col-sm-6 col-xs-12">
                <a href="<?php echo e(url('controlpanel/partner-review-list')); ?>">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Partner Updates </span>
                            <span class="info-box-number"><?php echo e($partnerUserCount); ?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </a>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        
        
        <!-- /.col -->
        </div>
    </section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>