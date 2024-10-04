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
	<div class="container">
		<br/><br/><br/>
			<div class="row" style="margin-top:40px !important;">
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
					<span> <h3 style="margin:0 !important;">Redeem Your points</h3></span>
				
					<span> <h5>Your Current Points : <strong><?php echo e(Auth::user()->wallet_balance); ?></strong></h5/></span><br/>
					<span> <h5>Minimum 5 Points Required for Redemption(Transfer Charges may apply). </h5/></span><br/>
					<form action="<?php echo e(url('/sent-request')); ?>" method="post">
						<?php echo csrf_field(); ?>

						<span style="margin-bottom: 10px;margin-top: 15px;">Please enter your bank details or paypal id for redemption.</span>
						<div class="form-group has-feedback">
							<textarea type="text" name="notes" class="form-control"
									  placeholder="Bank Detail Or Paypal id" required></textarea>
						</div>
						<?php if(Auth::user()->wallet_balance == 0): ?>
							<button type="button"
									class="btn btn-primary read-more-btn" onclick="requestRequest()"
							>Send Request
							</button>
						<?php else: ?>
							<button type="submit"
									class="btn btn-primary read-more-btn  share-opp-btn"
							>Send Request
							</button>
						<?php endif; ?>
					</form>
				</div>
			</div>
		
	</div>
    <script>
        function requestRequest() {
            toastr.error('You have insufficient balance in wallet', "Error");
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>