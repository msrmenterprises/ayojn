<?php $__env->startSection('content'); ?>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <?php
    use App\Country;
    $countries = Country::all();
    use App\Industry;
    $industries = Industry::all();
    use App\SponsorrSpecify;
    use App\SponsorrSpecifyList;
    $sponsorrlist = SponsorrSpecifyList::where('sponsorr_type', Auth::user()->sponsor_for)->get();
    $userwisesponsor = SponsorrSpecify::where('user_id', Auth::user()->id)->get();
    $userwisesponsorarray = [];
    if (count($userwisesponsor) > 0) {
        foreach ($userwisesponsor as $usersponsorr) {
            $userwisesponsorarray[] = $usersponsorr->specify_name;
        }
    }?>
	<!-- banner section start -->


	<br><br><br><br>
	<section id="feed" class="speakers">
		<div class="container">
			<a href="<?php echo e(url('opportunity')); ?>" class="btn btn-primary">Back</a>
			<h4 style="text-align: center"> My Vouched Opportunities</h4>

			<br>
			<div class="row">
				<table id="table_id" class="display">
					<thead>
					<tr>
						<th width="10%">Response Id</th>
						<th width="10%">Vouch Budget</th>
						<th width="10%">Opportunities</th>
						<th width="10%">Country</th>
						<th width="10%">City</th>
						<th width="10%">Industry</th>
						<th width="10%">Response</th>
						<th width="10%">Status</th>
					</tr>
					</thead>
					<tbody>

					<?php if(!empty($bids->first())): ?>
						<?php $__currentLoopData = $bids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $response): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							
							<tr>
								<td>#<?php echo e($response->id); ?></td>
								<td><?php echo e($response->vouch_value); ?></td>
								<td><?php echo e($response->opportunity->hashtag); ?></td>
								<td><?php echo e($response->opportunity->country_name->country_name); ?></td>
								<td><?php echo e((!empty($response->opportunity->opportunity_city)) ? $response->opportunity->city_name->name : "-"); ?></td>
								<td><?php echo e($response->opportunity->industry->name); ?></td>
								<td>
									<?php if(empty($response->opportunity->vouchResponse)): ?>
			-
									<?php else: ?>

										<?php if(!empty($response->opportunity->vouchResponse) && empty($response->opportunity->vouchResponse->vouchesResponseUser->first())): ?>
											<span class="badge badge-info">Pending</span>
										<?php else: ?>
											
											<?php if(!empty($response->opportunity->vouchResponse->vouchesResponseUser->first())): ?>
                                                <?php $email = '';
                                                foreach ($response->opportunity->vouchResponse->vouchesResponseUser as $us) {
                                                    if ($response->opportunity->vouchResponse->vouch_contacted == 'Mobile') {
                                                        $email = $email . $us->opportunityUser->phone_no . ", ";
                                                    } else if ($response->opportunity->vouchResponse->vouch_contacted == 'Both') {
                                                        $email = $email . $us->opportunityUser->email . "-" . $us->opportunityUser->phone_no . ", ";
                                                    } else {
                                                        $email = $email . $us->opportunityUser->email . ", ";
                                                    }
                                                }?>
												<a href="javascript:void(0)" style="font-size: 25px"
												   onclick="displayEmail('<?php echo e($email); ?>')"><i
														class="fa fa-envelope"></i><sup><span
															class="badge"><?php echo e($response->opportunity->vouchResponse->vouchesResponseUser->count()); ?></span></sup></a>
											<?php endif; ?>
										<?php endif; ?>
									<?php endif; ?>
								</td>
								<td>
																		<?php if(!empty($response->opportunity->vouchResponse)): ?>
																			<input type="checkbox"
																				   onchange='changebid(<?php echo e($response->opportunity->vouchResponse->id); ?>,"<?php echo e($response->opportunity->vouchResponse->is_active); ?>")'
																				   name="toggle-event-bid" data-toggle="toggle" data-on="On"
																				   data-off="Off" <?php echo e(($response->opportunity->vouchResponse->is_active == 'On')?'checked':''); ?>>
																		<?php endif; ?>
								</td>
							</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<?php endif; ?>
					</tbody>
				</table>
			</div>

		</div>
		<div id="html"></div>
	</section>

	<script>
      function changebid(id, status) {
        $.ajax({
          type: 'POST',
          url: '<?php echo e(url('change-opportunity-status')); ?>',
          headers: {"X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>"},
          data: {
            status: status,
            id: id
          },
          success: function (response) {
            //console.log(response.status);
            var data = response;
            if (data.status) {
              toastr.success(response.message, "Success");
              window.location.reload();
            } else {
              toastr.error(response.errors, "Error");
            }


            // link to page on clicking the notification

            //}

          },
          error: function (response) {
            toastr.error(response.responseJSON.msg, "Error");
            $(':input[type="submit"]').prop('disabled', false);
          },
        });
      }
      $(".read-more").click(function () {
        response_id = $(this).data("value");
        $.ajax({
          type: 'GET',
          headers: {"X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>"},
          url: '<?php echo e(url('get-bid-response')); ?>/' + response_id,

          cache: false,
          processData: false,
          success: function (response) {
            $("#html").html(response.html);
            $("#read-more-response").modal('show');
          },
          error: function (response) {
            toastr.error(response.responseJSON.msg, "Error");
            $(':input[type="submit"]').prop('disabled', false);
          },
        });
      });
      function displayEmail(email) {
        swal("You may communicate directly with Opportunity creator via: \n" + email);
      }
	</script>
	<script src="<?php echo e(asset('js/jquery1.min.js')); ?>"></script>
	<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
	<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
	<script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
	<script src="<?php echo e(asset('js/typed.min.js')); ?>"></script>
	<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script>

      $(document).ready(function () {

        $('#table_id').DataTable();
      });
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>