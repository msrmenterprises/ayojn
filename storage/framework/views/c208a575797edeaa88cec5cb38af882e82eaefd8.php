<?php $__env->startSection('content'); ?>
	<section id="feed" class="speakers">
		<div class="container">
			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-8" style="padding-top: 10px;">
					<h4>The information you would share here is only for indexing purposes and doesn’t reveal your identity. You could access the index once you share your inputs.</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3"></div>
				<div class="col-md-6">
					<form class="offer-form" id="offer-form" method="post" onsubmit="return false"
						  name="offer-form">

						<div class="form-group">
							<label>
								<strong>You wish to create Outreach via?</strong>
							</label>
						</div>

						<div class="form-group">
							<select class="form-control" name="offer_sponsorr_type" id="offer_sponsorr_type"
									onchange="displaySpecifyEditForm(1)">
								<option value="select">Select Any</option>
								<option value="Event" <?php echo e((Auth::user()->sponsor_for == 'Event')?'selected':''); ?>>Event
								</option>
								<option value="Campaign" <?php echo e((Auth::user()->sponsor_for == 'Campaign')?'selected':''); ?>>
									Campaign
								</option>
								<option value="Content" <?php echo e((Auth::user()->sponsor_for == 'Content')?'selected':''); ?>>
									Content
								</option>
								<option
									value="Sports Team" <?php echo e((Auth::user()->sponsor_for == 'Sports Team')?'selected':''); ?>>
									Sports Team
								</option>
								<option value="Venue" <?php echo e((Auth::user()->sponsor_for == 'Venue')?'selected':''); ?>>Venue
								</option>
								<option
									value="Not for Profit" <?php echo e((Auth::user()->sponsor_for == 'Not for Profit')?'selected':''); ?>>
									Not for Profit
								</option>
								<option
									value="Performing Arts" <?php echo e((Auth::user()->sponsor_for == 'Performing Arts')?'selected':''); ?>>
									Performing Arts
								</option>
								<option
									value="Think Tank" <?php echo e((Auth::user()->sponsor_for == 'Think Tank')?'selected':''); ?>>
									Think Tank
								</option>
								<option
									value="Knowledge Pool" <?php echo e((Auth::user()->sponsor_for == 'Knowledge Pool')?'selected':''); ?>>
									Knowledge Pool
								</option>
								<option
									value="Online Events" <?php echo e((Auth::user()->sponsor_for == 'Online Events')?'selected':''); ?>>
									Online Activities
								</option>
								<option
									value="Research" <?php echo e((Auth::user()->sponsor_for == 'Research')?'selected':''); ?>>
									Research
								</option>
								<option value="Other" <?php echo e((Auth::user()->sponsor_for == 'Other')?'selected':''); ?>>Other
								</option>
							</select>

						</div>
						<div id="sponsorOtherSpecifys" style="display: show !important;">
							<div class="form-group autocomplete">
								<label>
									<strong>Please Specify</strong>
								</label>

								
								<select class="form-control" name="offer_sponsorr_specify[]"
										id="offer_sponsorr_specify" multiple>
									<?php if(count($sponsorrlist) > 0): ?>
										<?php $__currentLoopData = $sponsorrlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sponsor_list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option
												value="<?php echo e($sponsor_list->id); ?>" <?php echo e((in_array($sponsor_list->id,$userwisesponsorarray))?'selected':''); ?>><?php echo e($sponsor_list->specify_name); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php endif; ?>
								</select>
							</div>
						</div>
                        <?php if (! empty(Auth::user()->likeSponsorr)) {
                            $likeArray = explode(',', Auth::user()->likeSponsorr);
                        } else {
                            $likeArray = [];
                        }?>
						<div class="form-group">
							<label>
								<strong>Objective you’re trying to achieve?</strong>
							</label>
						</div>
						<div class="form-group ">
							<select class="form-control" name="offer_sponsorr_like[]" id="offer_sponsorr_like" multiple>
								<option value="Message" <?php if (in_array('Message', $likeArray)) {
                                    echo "selected";
                                }?>>Message
								</option>
								<option value="Leads" <?php if (in_array('Leads', $likeArray)) {
                                    echo "selected";
                                }?>>Leads
								</option>
								<option value="Branding" <?php if (in_array('Branding', $likeArray)) {
                                    echo "selected";
                                }?>>Branding
								</option>
							</select>
						</div>

						<div class="form-group">
							<label>
								<strong>Geographically! Where exactly do you wish to focus?</strong>
							</label>
						</div>
						<div class="form-group">
							<select class="form-control" name="offer_sponsorr_country" id="offer_sponsorr_country">
								<option value="">Select Country</option>
								<?php if(!empty($countries)): ?>
									<?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option
											value="<?= $c->country_code?>" <?php echo e(($c->country_code == Auth::user()->country)?'selected':''); ?>><?= $c->country_name?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php endif; ?>
							</select>
						</div>


						<div class="form-group">
							<label>
								<strong>What's your ideal budget(USD)</strong>
							</label>
						</div>

						<div class="form-group">
							<select class="form-control" name="offer_sponsorr_budget" id="offer_sponsorr_budget">
								<option value="">Select Any</option>
                                <option value="200-500" <?php echo e((Auth::user()->sponsor_budget == '200-500')?'selected':''); ?>>200-500</option>
                                <option value="500-2000" <?php echo e((Auth::user()->sponsor_budget == '500-2000')?'selected':''); ?>>500-2000</option>
                                <option value="2000-5000" <?php echo e((Auth::user()->sponsor_budget == '2000-5000')?'selected':''); ?>>2000-5000</option>
                                <option value="5000-10000" <?php echo e((Auth::user()->sponsor_budget == '5000-10000')?'selected':''); ?>>5000-10000</option>
                                <option value="10000-20000" <?php echo e((Auth::user()->sponsor_budget == '10000-20000')?'selected':''); ?>>10000-20000</option>
                                <option value="20000-30000" <?php echo e((Auth::user()->sponsor_budget == '20000-30000')?'selected':''); ?>>20000-30000</option>
                                <option value="30000-50000" <?php echo e((Auth::user()->sponsor_budget == '30000-50000')?'selected':''); ?>>30000-50000</option>
                                <option value="50000-100000" <?php echo e((Auth::user()->sponsor_budget == '50000-100000')?'selected':''); ?>>50000-100000</option>
                                <option value="Above 100000" <?php echo e((Auth::user()->sponsor_budget == 'Above 100000')?'selected':''); ?>>Above 100000</option>
                                <option value="In kind" <?php echo e((Auth::user()->sponsor_budget == 'In kind')?'selected':''); ?>>In kind</option>

							</select>
						</div>
						<div class="form-group">
							<label>
								<strong>Select Industry </strong>
							</label>
						</div>
						<div class="form-group">
							<select class="form-control" name="offer_sponsorr_industry" id="offer_sponsorr_industry">
								<option value="test">Select your Industry</option>
								<?php $__currentLoopData = $industries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $in): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>{
								<option
									value="<?php echo e($in->id); ?>" <?php echo e((Auth::user()->sponsor_industry == $in->id)?'selected':''); ?>><?php echo e($in->name); ?></option>
								}
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>

						</div>
						
						<button type="submit" id="editformsubmit" onclick="OfferForm()" class="btn btn-default">
							Submit
						</button>
					</form>
				</div>
				<div class="col-md-3"></div>
			</div>
		</div>
	</section>
	<script>
      function OfferForm() {
        var offer_sponsorr_type = $("#offer_sponsorr_type").val();
        var offer_sponsorr_specify = $("#offer_sponsorr_specify").val();
        var offer_sponsorr_like = $("#offer_sponsorr_like").val();
        var offer_sponsorr_budget = $("#offer_sponsorr_budget").val();
        var offer_sponsorr_industry = $("#offer_sponsorr_industry").val();
        var offer_sponsorr_country = $("#offer_sponsorr_country").val();
        $.ajax({
          type: 'POST',
          url: '<?php echo e(route('update-offer-data')); ?>',
          headers: {"X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>"},
          data: {
            offer_sponsorr_type: offer_sponsorr_type,
            offer_sponsorr_specify: offer_sponsorr_specify,
            offer_sponsorr_like: offer_sponsorr_like,
            offer_sponsorr_budget: offer_sponsorr_budget,
            offer_sponsorr_industry: offer_sponsorr_industry,
            offer_sponsorr_country: offer_sponsorr_country,
          },
          success: function (response) {
            var data = response;
            if (response.status) {
              toastr.success(response.msg, "Success");
              window.location.reload();
            } else {
              toastr.error(response.msg, "Error");
            }

            /*notification = new Notification('New post alert!', {
			 body: 'this is test', // content for the alert
			 icon: "https://pusher.com/static_logos/320x320.png" // optional image url
			 });*/

            // link to page on clicking the notification
            //
            //}

          },
          error: function (response) {
            toastr.error(response.responseJSON.msg, "Error");
            $(':input[type="submit"]').prop('disabled', false);
          },
        });

      }

      function displaySpecifyEditForm(flagSpecify) {
        var event_type = $("#offer_sponsorr_type").val();
        $('#offer_sponsorr_specify').html('');
        //$("#sponsoredOtherSpecify").show();
        var CSRF_TOKEN = $('meta[name="_token"]').attr('content');
        $.ajax({
          type: 'POST',
          url: "<?php echo e(route('getspecify')); ?>",
          data: {_token: CSRF_TOKEN, event_type: event_type},
          headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          },
          success: function (data) {
            //console.log(data);
            if (data != '') {
              // Loop through each of the results and append the option to the dropdown
              $.each(data, function (k, v) {
                $('#offer_sponsorr_specify').append('<option value="' + v.id + '">' + v.specify_name + '</option>');

              });
            }
            //$('#popupcountry').html(data);
            //$('#topCountriesForm').modal('show');
          },
          error: function (jqXHR, textStatus, errorThrown) {
            toastr.error("Something went wrong", "Error");
          },
        });
      }
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>