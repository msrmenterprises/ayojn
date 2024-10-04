<?php $__env->startSection('content'); ?>
    <!-- banner section start -->


        <br><br><br><br>
        <section id="feed" class="speakers" >
  <div class="container">
    <div class="row">
		
		<br>
    	
		<!-- <h2 class="text-center">Thank you for sharing your inputs.<br> While we validate the details how about you have a read on how we are building a momentum for Sponsay.</h2> -->


		<h2 class="text-center"><br/><br/><br/>Thank you for signing up. <br/><br/>Please check your inbox, we just sent you an email to verify your email address. </h2>
    	<hr>
      
    </div>

  </div>
</section>


<script src="<?php echo e(asset('js/jquery1.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/typed.min.js')); ?>"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>