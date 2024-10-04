<?php $__env->startSection('content'); ?>
    <br><br><br><br>
    <section id="feed" class="speakers">
        <div class="container">
            <div class="row">
                <a href="<?php echo e(url('bid')); ?>" class="btn btn-primary float-left"
                >Opportunities </a>

            </div>
            <br>
            <br>
            <div class="row">
                <table id="table_id" class="display">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Wish to Sponsor</th>
                        <th>Specific <br>Opportunity</th>
                        <th>Why this Opportunity</th>
                        <th>Where to Sponsor</th>
                        <th>Identity</th>
                        <th>Expected Budget <br>(USD $)</th>
                        <th>Industry</th>
                        <th>Pay Now</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(!empty($bids->first())): ?>
                        <?php $__currentLoopData = $bids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                            $specification = '';
                            $specificationArray = [];
                            ?>
                            <?php if(!empty($bid->bidSpecify->first())): ?>
                                <?php $__currentLoopData = $bid->bidSpecify; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bidS): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $specificationArray[] = $bidS->specifyName->specify_name;
                                        $specification = implode(', ',$specificationArray);
                                    ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>

                            <tr>
                                <td><?php echo e($bid->id); ?></td>
                                <?php if($bid->sponsor_for=='Online Events'): ?>
                                    <td> Online Activities</td>
                                <?php else: ?>
                                    <td><?php echo e($bid->sponsor_for); ?></td>
                                <?php endif; ?>
                                <td><?php echo e($specification); ?></td>
                                <td><?php echo e($bid->likeSponsorr); ?></td>
                                <td><?php echo e((!empty($bid->country_name)) ? $bid->country_name->country_name : "-"); ?>

                                    / <?php echo e((!empty($bid->city) && !empty($bid->city_name) && !empty($bid->city_name->name)) ? $bid->city_name['name'] : "-"); ?></td>
                            <!--<td><?php echo e($bid->contacted_by); ?></td> -->
                                <td><?php echo e($bid->identity); ?></td>
                                <td><?php echo e($bid->sponsor_budget); ?></td>
                                <td><?php echo e((!empty($bid->industry)) ? $bid->industry->name : '-'); ?></td>

                                <td>
                                    <?php if($bid->admin_status == 0): ?>
                                        Pending
                                    <?php else: ?>
                                        <!-- <a href="<?php echo e(url('pay-now/').'/'.$bid->id); ?>">
                                            <button class="btn btn-primary">Via Paypal</button>
                                        </a>  
                                        <a data-toggle="modal" data-target="#add-vouch-code">
                                            <input type="hidden" name="bid_id" id="bid_id" value="<?php echo e($bid->id); ?>">
                                            <?php if(Auth::user()->refer_by == '' || (Auth::user()->refer_by != '' && Auth::user()->is_bonus_used == 1)): ?>
                                                <button class="btn btn-primary">Use a Voucher Code</button>
                                            <?php endif; ?>
                                        </a> -->

                                        <a data-toggle="modal" data-target="#paynow_modal">
                                            <input type="hidden" name="bid_id" id="bid_id" value="<?php echo e($bid->id); ?>">
                                            <?php if(Auth::user()->refer_by == '' || (Auth::user()->refer_by != '' && Auth::user()->is_bonus_used == 1)): ?>
                                                <button class="btn btn-success"> Pay Now</button>
                                            <?php endif; ?>
                                        </a>

                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>

    </section>
    <div class="modal" id="add-vouch-code" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                    <div style="text-align: center">Use a Voucher Code</div>
                </div>
                <div class="modal-body">

                    <form class="addVouchForm" id="addVouchForm" method="post" onsubmit="return false"
                          name="addVouchForm">

                        <div id="add-opporutnity-form">
                            <div class="row" style="padding-bottom: 8px;">
                                <div class="col-md-3">Vouch Code</div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="vouch_code" id="vouch_code"
                                           placeholder="Use a Voucher Code">
                                </div>
                            </div>

                        </div>
                        <button type="submit" id="addBid" class="btn btn-default" onclick="submitFormVouch()"
                                style="text-align: center">Submit
                        </button>
                    </form>

                </div>

            </div>
        </div>
    </div>


    <div class="modal" id="paynow_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-sm" role="document" style="width:450px;">
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
				<h4 class="modal-title" id="myModalLabel" style="text-align: center">Payment Details</h4>
				
			</div>
			<div class="modal-body">
			
            <div class="form-group autocomplete" style="margin:0px; width: 100%; display: block; margin-left: auto; margin-right: 0;">
						<label>
							<strong>Bid Amount</strong>
						</label>
						<label class="pull-right">
                         450
						</label>
						
				</div>
                <hr style="margin-bottom: 20px; margin-top: 3px;" />
			 

			<div class="form-group autocomplete" style="width: 100%; display: block; margin-left: auto; margin-bottom:10px; margin-right: 0;">
                <label>
                <input type="hidden" id="wallet_use" name="wallet_use" value="0" />
                <input type="checkbox" value="" class="walletcheck form-control" style="height: 16px; width: 16px; margin-top: 3px; position: absolute;" />
                <span style="margin-left: 25px;">Pay via Wallet</span>
                </label>
                <label class="pull-right">
                230
                </label>
			</div>


            <div class="form-group autocomplete" style="width: 100%; display: block; margin-left: auto; margin-bottom:10px; margin-right: 0;">
                <label>
                <input type="hidden" id="wallet_use" name="wallet_use" value="0" />
                <input type="checkbox" value="" class="form-control" style="height: 16px; width: 16px; margin-top: 3px; position: absolute;" />
                <span style="margin-left: 25px;">Pay via Voucher</span>
                </label>
                <label style="display: inline-block; float: right; width: 50%;">

                    <div class="input-group" style="position:absolute;">
                    <input type="search" class="form-control" placeholder="Voucher code" >
                    <span class="input-group-btn">
                    <button class="btn btn-primary" type="button">
                    </span> <i class='fa fa-thumbs-o-up'></i> Apply</button>
                    
                    </div>

                
                <button class="btn btn-success btn-sm"><i class='fa fa-thumbs-o-up'></i> Apply</button>    
            </label>
			</div>

            <div class="form-group autocomplete" style="width: 100%; display: block; margin-left: auto; margin-bottom:10px; margin-right: 0;">
                <label>
                <input type="hidden" id="wallet_use" name="wallet_use" value="0" />
                <input type="checkbox" value="" class="form-control" style="height: 16px; width: 16px; margin-top: 3px; position: absolute;" />
                <span style="margin-left: 25px;">Pay via Gateway</span>
                </label>
                
			</div>

				



            <hr style="margin-top: 5px;  margin-bottom: 10px;"/>
				<div class="form-group autocomplete" style="margin-bottom: 0px; width: 100%; display: block; margin-left: auto; margin-right: 0;">
						<label>
							<strong>Final Paid Amount</strong>
						</label>
						<label class="pull-right">
							<span id="paidamt">450</span> 
						</label>
						
				</div>

				<hr style="margin-top: 5px;"/>
				<div class="form-group autocomplete text-center">
				<a href="javascript:void(0)" class="btn btn-primary button-primary-color paynowfinal" data-bid=""> Pay Now</a>
                <input type="hidden" value="" name="userid" id="userid" />
            </div>


			</div>
		</div>
	</div>
</div>



    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        function submitFormVouch() {
            var vouch_code = $("#vouch_code").val();
            var bid_id = $("#bid_id").val();
// if (bid_id != '' && vouch_code != '') {
            $.ajax({
                url: "<?php echo e(url('/')); ?>" + '/add-new-vouch-code',
                type: "post",
                async: false,
                data: {
                    vouch_code: vouch_code,
                    bid_id: bid_id,
                },
                headers: {"X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>"},
                success: function (data) {
                    if (data.status) {
                        $("#add-vouch-code").modal('hide');
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        swal(data.message);
                        setTimeout(function () {
                            location.href = "<?php echo e(url('/bid')); ?>";
                        }, 1000);
                    } else {
                        $("#add-vouch-code").modal('toggle');
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        swal(data.message);
                    }
                },
                error: function (data) {
                },
            })
// } else {
//     $("#add-vouch-code").modal('toggle');
//     $('body').removeClass('modal-open');
//     $('.modal-backdrop').remove();
//     swal("Please enter valid Vouch code");
// }


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
            $('#table_id').DataTable({
                "fnDrawCallback": function () {
// $('.my_switch').bootstrapToggle();
                    $('.my_switch').bootstrapToggle({})
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>