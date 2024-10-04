<?php $__env->startSection('content'); ?>
    <!-- banner section start -->

    <div class="banner-text">
        <!-- <h2><a href="#" data-toggle="modal" data-target="#sponsorrText"><b>Sponsay</b></a></h2> -->
         <h2><a href="#" data-toggle="modal" data-target="#ConnectText"><b>Connect</b></a></h2>
          <h2><a href="javascript:void(0)" data-toggle="modal" data-target="#loginForm"><b>Sponsay Login</b></a></h2>
           <h2><a href="javascript:void(0)" data-toggle="modal" data-target="#signupForm" class="signup"><b>Sponsay Register</b></a></h2>
           <h2><a href="#" data-toggle="modal" data-target="#TermsText"><b>Terms And Condition</b></a></h2>
            <h2><a href="#" data-toggle="modal" data-target="#privacyText"><b>Privacy and Policy</b></a></h2>

    </div>


<script src="<?php echo e(asset('js/jquery1.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/typed.min.js')); ?>"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>