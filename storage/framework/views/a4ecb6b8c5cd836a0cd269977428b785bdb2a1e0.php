<?php $__env->startSection('content'); ?>
	<style>

		.forgot_button {
			height: 45px;
			width: 150px;
			text-align: center;
			line-height: 45px;
			margin-right: 0;
			border-radius: 40px;
			background: #52616D;
			color: #fff;
		}

	</style>
	<!-- Resources -->
	<div style="width: 480px;
    margin: 12% auto;">
		<div class="row">
			<div class="col-md-12">
				<?php if(session('message')): ?>
					<div class="alert alert-danger">
						<?php echo e(session('message')); ?>

					</div>
				<?php endif; ?>
				<?php if(session('sucess_message')): ?>
					<div class="alert alert-success">
						<?php echo e(session('sucess_message')); ?>

					</div>
				<?php endif; ?>
				<b> We will send a mail to the registered Email address.<br/></b>
				<form action="<?php echo e(url('/sent-username')); ?>" method="post">
					<?php echo csrf_field(); ?>

					<span>Hint incase you forget Username or Password</span>
					<div class="form-group has-feedback">
						<input type="text" name="mother" class="form-control"
							   placeholder="Nick Name, First Job, Favourite Colour or anything" required>
						<span class="glyphicon glyphicon-user form-control-feedback"></span>
						<?php if($errors->has('email')): ?>
							<span class="help-block">
                            <strong><?php echo e($errors->first('email')); ?></strong>
                        </span>
						<?php endif; ?>
					</div>
					<span>Mobile No</span>
					<div class="form-group has-feedback ">
						<input type="text" name="mobile_no" class="form-control"
							   placeholder="Mobile No" required>
						<span class="glyphicon glyphicon-phone form-control-feedback"></span>
					</div>
					<button type="submit"
							class="forgot_button"
					>Send Username
					</button>
				</form>
			</div>
		</div>
	</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>