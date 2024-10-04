<div style="width: 100%; display:block;">
<h2>Welcome to Sponsay</h2>
<p>
	<?php $url = url('verify/'.$user->email_verification_code); 
	$com_nam = $user->entity;
	?>
	<strong>Hello <?php echo e($com_nam); ?>,</strong><br>
	Thank you for signing up. Please <a href="<?php echo e($url); ?>">Verify Email</a>  address to confirm your identity.  If you are not able to click here then copy this below url and paste in browser <?php echo e(url('verify/'.$user->email_verification_code)); ?><br>
	Once verified by you we will then conduct a validation exercise to confirm your inputs. Upon approval of validation you will then have the access for Sponsay. 
	<br>
	<br>
	See you at Sponsay.
	<br>
	Global Support Team
	<br>
	<strong>Sponsay</strong>
</p>
</div>