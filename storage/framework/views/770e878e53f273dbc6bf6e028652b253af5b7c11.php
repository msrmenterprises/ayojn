<?php $__env->startSection('content'); ?>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <?php
    $f = Request::get('f');
    $cn = Request::get('c');
    $b = Request::get('b');
    $i = Request::get('i');

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
		<div class="container" style="padding-top: 15px;">
			<div class="row"><h3 style="text-align: center;">Built Opportunities</h3>
			</div>
			<div class="row"><a href="<?php echo e(url('build-opportunity')); ?>" class="btn btn-primary float-left"
				>Build New Opportunities</a>

			</div>
			<br>
			<div class="row">
				<form name="search">
					<div class="col-md-3">
						<input class="form-control" name="f" id="f" placeholder="Search Opportunities">
					</div>
					<div class="col-md-2">
						<select class="form-control" name="c" id="c">
							<option value="">Select Country</option>
							<?php if(!empty($countries)): ?>
								<?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option value="<?= $c->country_code?>" <?php if ($cn == $c->country_code) {
                                        echo "Selected";
                                    }?>><?= $c->country_name?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php endif; ?>
						</select>
					</div>
					<div class="col-md-2">
						<input class="form-control" name="b" id="b" placeholder="Search Vouches">
					</div>
					<div class="col-md-3">
						<select class="form-control" name="i" id="i">
							<option value="">Select Industry</option>
							<?php $__currentLoopData = $industries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $in): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>{
							<option value="<?php echo e($in->id); ?>" <?php if ($i == $in->id) {
                                echo "Selected";
                            }?>><?php echo e($in->name); ?></option>
							}
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</select>
					</div>
					<div class="col-md-2">
						<button type="submit" class="btn btn-primary"
						>Search
						</button> &nbsp;<a href="<?php echo e(url('opportunity')); ?>" title="refresh" class="btn btn-primary"
						><i class="fa fa-refresh" aria-hidden="true"></i></a></div>
				</form>
			</div>
			<br>
			<div class="row">
				<table id="table_id" class="display">
					<thead>
					<tr>
						<th>Opportunity ID</th>
						<th>Vouched</th>
						<th>Opportunity</th>
						<th>Country</th>
						<th>City</th>
						<th>Industry</th>
						<th>Status</th>
						<th>Added Date</th>
						<th>Share</th>
					</tr>
					</thead>
					<tbody>
					<?php if(!empty($bids->first())): ?>
						<?php $__currentLoopData = $bids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr>
								<td>#<?php echo e($bid->id); ?></td>
								<td><a href="<?php echo e(url('vouches/')."/".$bid->id); ?>"><span
											class="badge badge-warning"><?php echo e($bid->vouchesResponse->count()); ?></span></a>
								</td>
								<td><?php echo e($bid->hashtag); ?></td>
								<td><?php echo e((!empty($bid->country_name)) ? $bid->country_name->country_name : "-"); ?></td>
								<td><?php echo e((!empty($bid->opportunity_city)) ? $bid->city_name->name : "-"); ?></td>
								<td><?php echo e((!empty($bid->industry)) ? $bid->industry->name : '-'); ?></td>
								<td>
									<?php if($bid->status == 0): ?>
										<span class="badge badge-warning">Pending</span>
									<?php else: ?>
										<span class="badge badge-success">Approved</span>
									<?php endif; ?>
								</td>
								<td><?php echo e(Date("Y-m-d",strtotime($bid->created_at))); ?></td>
								<td><span id="opportunity_<?php echo e($bid->id); ?>" class="share-course-filed"
										  style="display: none"> <?php echo e(url('share-opportunity')."/" . $bid->share_id); ?></span> <a
										href="javascript:void(0)" class="btn btn-primary read-more-btn  share-opp-btn"
										onclick="copyToClipboard('#opportunity_<?php echo e($bid->id); ?>',<?php echo e($bid->status); ?>)">Copy Web link</a></td>
							</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<?php endif; ?>
					</tbody>
				</table>
			</div>

		</div>
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
						<h4 class="modal-title" id="myModalLabel" style="text-align: center">Response</h4>
						<h4 id="bid_id" style="text-align: center"></h4>
					</div>
					<div class="modal-body">
						<form class="addBidForm" id="addBidForm" method="post" onsubmit="return false"
							  name="addBidForm">

							<div class="form-group autocomplete">
								<label>
									<strong>Write Your Pitch (In 500 characters)</strong>
								</label>
								<textarea id="description" name="description" class="form-control"
										  placeholder="Let's talk about Oranges if the bid is about Oranges and NOT Apples. For e.g. tell a story about how you did it before and that could help the client for now. "
										  maxlength="500"></textarea>
								<input id="bid_input_id" name="bid_input_id" type="hidden">
							</div>
							<div class="form-group">
								<label>
									<strong>Web Link</strong>

								</label>
								<input id="portfolio" name="portfolio" class="form-control"
									   placeholder="Website, Portfolio, Social Media Profile" data-validation="url">
							</div>

							<button type="submit" id="addBid" class="btn btn-default">Submit</button>
						</form>

					</div>

				</div>
			</div>
		</div>
	</section>

	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

	<script>
      $(".share-opp-btn").on('click', function (e) {

      });
      function copyToClipboard(element,status) {
        if(status != 0){
          var $temp = $("<input>");
          $("body").append($temp);
          $temp.val($(element).text()).select();
          document.execCommand("copy");
          $temp.remove();
          toastr.success('Web Link Copied','Success');
		}else{
          toastr.error('We are preparing this opportunity for a launch, please wait while we are working on this.','Warning');
		}

      }
      // $("#addBidForm").validate({
      //   rules: {
      //     portfolio: {
      //       required: true,
      //       url: true
      //     }, description: {
      //       required: true,
      //       maxlength: 500
      //     }
      //   },
      //   submitHandler: function (form) {
      //     addBid()
      //   }
      // });

      function displayEmail(email) {
        swal(email);
      }
	</script>
	<script src="<?php echo e(asset('js/jquery1.min.js')); ?>"></script>

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