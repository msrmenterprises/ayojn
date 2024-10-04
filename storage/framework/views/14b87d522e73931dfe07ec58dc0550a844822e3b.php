<style>
	.button-redirect {
		background-color: #7cd1f9;
		color: #fff;
		border: none;
		box-shadow: none;
		border-radius: 5px;
		font-weight: 600;
		font-size: 14px;
		padding: 10px 24px;
		margin: 0;
		cursor: pointer;
	}
</style>
<div class="modal" id="add-bid" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 45.56 45.559">
						<path id="Union_1" data-name="Union 1" class="cls-1"
							  d="M22.426,22.426,0,44.852,22.426,22.426,0,44.852,22.426,22.426,0,0,22.426,22.426,0,0,22.426,22.426,44.852,0,22.426,22.426,44.852,0,22.426,22.426,44.852,44.852,22.426,22.426,44.852,44.852ZM22.426,22.426Z"
							  transform="translate(0.354 0.354)"/>
					</svg>
				</button>
				<h4 id="bid_id" style="text-align: left;margin-bottom: 18px !important;">Vouching is an equivalent of EOI (Expression of Interest) and once you Vouch then it will let you and the opportunity holders communicate directly without our mediation.
				</h4>

				<div style="text-align: center">Vouchlist for <?php echo e($opportunityDetail->hashtag); ?></div>
			</div>
			<div class="modal-body">
				<div id="message" style="color: red;display: none;text-align: center"><b>Please select all value</b>
				</div>
				<form class="addBidForm" id="addBidForm" method="post" onsubmit="return false;"
					  name="addBidForm">

					<div id="add-opporutnity-form">
						<div class="row" style="padding-bottom: 8px;">
							<div class="col-md-6">Budget for the Vouch (USD $)</div>
							<div class="col-md-6">
								<input type="hidden" value="<?php echo e($opportunityDetail->id); ?>" id="opportunity_id"
									   name="opportunity_id">
								<select class="form-control" name="vouch_value" id="vouch_value" required>
									<option value="">Select Budget</option>
									<option value="200-500">200-500</option>
									<option value="500-2000">500-2000</option>
									<option value="2000-5000">2000-5000</option>
									<option value="5000-10000">5000-10000</option>
									<option value="10000-20000">10000-20000</option>
									<option value="20000-30000">20000-30000</option>
									<option value="30000-50000">30000-50000</option>
									<option value="50000-100000">50000-100000</option>
									<option value="Above 100000">Above 100000</option>
									<option value="In kind">In kind</option>

								</select>
							</div>
						</div>
						<div class="row" style="padding-bottom: 8px;">
							<div class="col-md-6">Share my vouch with</div>
							<div class="col-md-6">
								<select class="form-control" name="vouch_identity" id="vouch_identity" required>
									<option value="All">All</option>
                                    <option value="Freelancers">Freelancers</option>
                                    <option value="Agencies">Agencies</option>
                                    <option value="Networks">Networks</option>
                                    <option value="Communities">Communities</option>
								</select>
							</div>
						</div>

						<div class="row" style="padding-bottom: 8px;">
							<div class="col-md-6">Listed in</div>
							<div class="col-md-6">
								<select class="form-control" name="vouch_country" id="vouch_country" required
										onchange="getCountryByHashTag()">
									<option value="">Select Country</option>
									<?php if(!empty($opportunities->first())): ?>
										<?php $__currentLoopData = $opportunities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opprtunity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($opprtunity->country_name->country_code); ?>"
													data-hashtag="<?php echo e($opprtunity->id); ?>"><?php echo e($opprtunity->country_name->country_name); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php endif; ?>
								</select>
								
								
								
							</div>
						</div>
						<div class="row" style="padding-bottom: 8px;">
							<div class="col-md-6">Located in</div>
							<div class="col-md-6">
								<select class="form-control" name="vouch_city" id="vouch_city" required>
									<option value="">Select City</option>
								</select>
							</div>
						</div>
						<div class="row" style="padding-bottom: 8px;">
							<div class="col-md-6">How do you wish to be contacted?</div>
							<div class="col-md-6">
								<select class="form-control" name="vouch_contacted" id="vouch_contacted" required>
									<option value="">Select Contact type</option>
									<option value="Email">Email</option>
									<option value="Mobile">Mobile</option>
									<option value="Both">Both</option>
								</select>
							</div>
						</div>
					</div>
					<button type="submit" id="addBid" class="btn btn-default" onclick="submitForm()"
							style="text-align: center">Submit
					</button>
				</form>

			</div>

		</div>
	</div>
</div>

<script>
  function getCountryByHashTag() {
    let value = $('#vouch_country option:selected').data('hashtag');
    let url = "<?php echo e(url('/get-cities/')); ?>/" + value;
    $.get(url, {}, function (response) {
      if (response.success) {
        let CityHTML = '<option value="">Select City</option>';

        response.data.opportunities.forEach(function (cls) {
          CityHTML += '<option value="' + cls.city_name.id + '" >' + cls.city_name.name + '</option>';
        });
        $("#vouch_city").html(CityHTML);
      }
    }, 'json');
  }


  function submitForm() {
    var vouch_value = $("#vouch_value").val();
    var opportunity_id = $("#opportunity_id").val();
    var vouch_identity = $("#vouch_identity").val();
    var vouch_city = $("#vouch_city").val();
    var vouch_country = $("#vouch_country").val();
    var vouch_contacted = $("#vouch_contacted").val();
    if (vouch_value != '' && opportunity_id != '' && vouch_identity != '' && vouch_city != '' && vouch_country != '' && vouch_contacted != '') {
      $("#message").hide();
      $.ajax({
        url: "<?php echo e(url('/')); ?>" + '/add-new-vouch',
        type: "post",
        async: false,
        data: {
          vouch_value: vouch_value,
          opportunity_id: opportunity_id,
          vouch_identity: vouch_identity,
          vouch_city: vouch_city,
          vouch_country: vouch_country,
          vouch_contacted: vouch_contacted
        },
        headers: {"X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>"},
        success: function (data) {
          if (data.status == 1) {

            $("#vouch_" + opportunity_id).html('<span class="badge badge-info">Pending</span>');
            const el = document.createElement('div')
            el.innerHTML = "<a class='swal-button swal-button--confirm' href='<?php echo e(url('my-vouches')); ?>'>View my vouched opportunities</a>"
            // swal('', data.message, 'success');
            swal({
              title: "Your vouch is sent, let’s wait while it gets a response!",
              content: el,
            }).then(okay => {
              if (okay) {
                location.reload()
              }
            });
            $("#add-bid").modal('hide');
            $("#append-form").html('');
          } else {

            if (data.status == 2) {
              const el = document.createElement('div')
              el.innerHTML = "<a class='swal-button swal-button--confirm' href='<?php echo e(url('my-vouches')); ?>'>View my vouched opportunities</a>"
              // swal('', data.message, 'success');
              swal({
                title: "You have already vouched this opportunity",
                content: el,
              }).then(okay => {
                if (okay) {
                  location.reload()
                }
              });
            } else {
              swal(data.message);
            }

            $("#append-form").html('');
          }
        },
        error: function (data) {
        },
      })
    } else {
      $("#message").show();
      // $("#add-bid").modal('hide');
      // $("#append-form").html('');
      // swal("Please select all value");
    }


  }
</script>
