<?php $__env->startSection('title', 'Sponsorr'); ?>

<?php $__env->startSection('content_header'); ?>
	<h1>Edit User Type</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">Edit User Type</h3>
		</div>
		<?php if(session()->has('success')): ?>
			<div class="alert alert-success">
				<?php echo e(session()->get('success')); ?>

			</div>
		<?php endif; ?>
		<?php if($errors->any()): ?>
			<div class="alert alert-danger">
				<ul>
					<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<li><?php echo e($error); ?></li>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</ul>
			</div>
		<?php endif; ?>
		<!-- /.box-header -->
		<!-- form start -->

		<form role="form"  method="POST" name="editsubuser" id="editsubuser" action="<?php echo e(route('updateusertype')); ?>" enctype="multipart/form-data">
			<?php echo e(csrf_field()); ?>

			<input type="hidden" id="userid" name="userid" value="<?php echo e($user->id); ?>">
			<div class="box-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="email_id" >User Type <b style="color: red">*</b></label>
							<select class="form-control" name="userType" id="userType" onchange="selectedUserType()"> 
								<option value="1" <?php  if($user->sponsor_type ==1){ echo "selected";}?>>Offer or Infleunce</option>
									<option value="2" <?php  if($user->sponsor_type ==2){ echo "selected";}?>>Recieve or Manage</option>
							</select>

						</div>
					</div>
				</div>
			</div>
			<div class="box-body" id="sponsorIndustryDropdown">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="email_id" >Industry<b style="color: red">*</b></label>
						<select class="form-control" name="sponsorIndustry" id="sponsorIndustry">
							<option value="test">Select your Industry </option>
							<?php $__currentLoopData = $industries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $in): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<option value="<?php echo e($in->id); ?>" <?php if($in->id == $user->sponsor_industry){ echo "selected";}?>><?php echo e($in->name); ?></option>
							
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</select>
						</div>
					</div>
				</div>
			</div>
			<!-- /.box-body -->
			<div class="box-footer">
				<button type="submit" class="btn btn-info pull-right" id="adduserbutton" name="adduserbutton">Update User <i class="fa fa-refresh fa-spin upload_spin" style="display: none" ></i></button>
				<a href=""  class="btn btn-danger pull-right">Cancel</a>
			</div>
		</form>
	</div>
<script>
	$( document ).ready(function() {
        uType = "<?php echo e($user->sponsor_type); ?>";
        if(uType == 1){
			$("#sponsorIndustryDropdown").show();	
		}else{
			$("#sponsorIndustryDropdown").hide();	
		}
	});

	function selectedUserType(){
		usertype = $("#userType").val();
		if(usertype == 1){
			$("#sponsorIndustryDropdown").show();	
		}else{
			$("#sponsorIndustryDropdown").hide();	
		}
	}
	jQuery.validator.addMethod("nameValid", function (value, element) {
		return this.optional(element) || /^[a-zA-Z\s]+$/.test(value); });
	jQuery.validator.addMethod("phoneValid", function (value, element) {
		return this.optional(element) || /^[0-9]+$/.test(value); });
	jQuery.validator.addMethod("alphanumeric1", function(value, element) {
		return this.optional(element) || /^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9-!@#$%&*?_]+)$/.test(value);
	});
	$("#editsubuser").validate({
		rules: {
			email: {
				required: true,
				pattern: /^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i
			}
		},
		messages: {
			email: {
				required: "Enter a Valid Email ID",
				pattern: "Enter a Valid Email ID"
			}
		},
		/*errorPlacement: function (error, element) {
		 if (element.attr("name") == "terms") {
		 error.appendTo('#error');
		 } else {
		 error.insertAfter(element);
		 }

		 },*/
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>