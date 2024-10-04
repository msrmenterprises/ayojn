<?php $__env->startSection('content'); ?>
    <?php
    $f = Request::get('f');
    $cn = Request::get('c');
    $b = Request::get('b');
    $i = Request::get('i');

    ?>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <?php
    use App\Country;use App\Industry;use App\SponsorrSpecify;use App\SponsorrSpecifyList;
    $countries = Country::all();
    $industries = Industry::all();
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
            <a href="<?php echo e(url('bid')); ?>" class="btn btn-primary">Back</a>
            <a href="<?php echo e(url('spam-bids') . '/'.$bidId); ?>" class="btn btn-primary">Irrevelant Bids</a>
            <h4 style="text-align: center"> Response for </h4>
            <h4 style="text-align: center"> Opportunity ID #<?php echo e(@$bidDetail->id); ?></h4>
            <br>
            <div class="row">
                <form name="search">
                    <div class="col-md-3">
                        <select class="form-control" name="f">
                            <option value="">Select Indentity</option>
                            <option value="Freelancers" <?php if ($f == "Freelancers") {
                                echo "Selected";
                            }?>>Freelancers
                            </option>
                            <option value="Agencies" <?php if ($f == "Agencies") {
                                echo "Selected";
                            }?>>Agencies
                            </option>
                            <option value="Networks" <?php if ($f == "Networks") {
                                echo "Selected";
                            }?>>Networks
                            </option>
                            <option value="Communities" <?php if ($f == "Communities") {
                                echo "Selected";
                            }?>>Communities
                            </option>

                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-control" name="c" id="c-filter" onchange="getCity(5)">
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
                        <select class="form-control" name="city" id="city-filter">
                            <option value="">Select city</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" name="i" id="i">
                            <option value="">Select Any</option>
                            <option value="1">Read More</option>
                            <option value="2">Open For Negotiation</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary"
                        >Search
                        </button> &nbsp;<a href="<?php echo e(url('bid')); ?>" title="refresh" class="btn btn-primary"
                        ><i class="fa fa-refresh" aria-hidden="true"></i></a></div>
                </form>
            </div>
            <br>
            <div class="row">
                <table id="table_id" class="display">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Email</th>
                        <!--<th>Description</th>-->
                        <th>Link</th>
                        <th>Date</th>
                        <th>Action</th>
                        <th>Irrevelant</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(!empty($bidResponses->first())): ?>
                        <?php $__currentLoopData = $bidResponses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $response): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr>
                                <td><?php echo e($response->id); ?></td>
                                <?php if($response->is_accepted ==2): ?>
                                    <td><?php echo e((!empty($response->userDetail)) ? $response->userDetail->email : ''); ?></td>
                                <?php else: ?>
                                    <td>XXXXXXgmail.com</td>
                            <?php endif; ?>
                            <!--<td><?php echo e($response->description); ?></td> -->
                                <td><?php echo e($response->portfolio_link); ?></td>
                                <td><?php echo e(date('Y-m-d',strtotime($response->created_at))); ?></td>
                                <td>
                                    <a href="javascript:void(0)"
                                       title="Read More" onclick="readMore(<?php echo e($response->id); ?>)" class="read-more"
                                       data-value="<?php echo e($response->id); ?>">Read More&nbsp;<i class="fa fa-eye"
                                                                                          aria-hidden="true"></i></a>
                                    <?php if($response->is_accepted == 2 || $response->is_accepted == 1): ?>
                                        |
                                        <a href="javascript:void(0)" onclick="acceptBid(<?php echo e($response->id); ?>)"
                                           title="Open for Negotiation">Open for Negotiation&nbsp;<i class="fa fa-check"
                                                                                                     aria-hidden="true"></i></a>
                                    <?php elseif($response->is_accepted == 3): ?>
                                        <span class="label label-success">Booked</span> 
                                    <?php elseif($response->is_accepted == 4): ?>
                                        <span class="label label-success">Paid</span>       
                                    <?php endif; ?>
                                    &nbsp;
                                </td>
                                <td><a href="javascript:void(0)" onclick="openReasonForm(<?php echo e($response->id); ?>)"
                                       title="Mark Irrevelant">Mark Irrevelant</a></td>


                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div id="append-form"></div>
        </div>
        <div id="html"></div>
    </section>

    <script>
        function openReasonForm(responseId) {
            $.ajax({
                url: "<?php echo e(url('/')); ?>" + '/add-reason/' + responseId,
                type: "get",
                async: false,
                headers: {"X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>"},
                success: function (data) {
                    if (data.html != '') {
                        $("#append-form").append(data.html);
                        $("#add-reason").modal('show');
                    }
                },
                error: function (data) {
                },
            })
        }

        function acceptBid(responseId) {
            $.ajax({
                type: 'GET',
                headers: {"X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>"},
                url: '<?php echo e(url('bid-accept')); ?>/' + responseId,

                cache: false,
                processData: false,
                success: function (response) {
                    swal("Bid opened for negotiation", {
                        icon: "success",
                    });
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                },
                error: function (response) {
                    toastr.error(response.responseJSON.msg, "Error");
                    $(':input[type="submit"]').prop('disabled', false);
                },
            });
            
            
            
            
            
            
            
            
            

            
            
            
            

            
            
            
            
            
            
            
            
            
            
            
            
            

            
            
        }

        function readMore(response_id) {
            //  response_id = $(this).data("value");
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
        }

        $("#addBid").click(function () {
            var bid_id = $("#bid_input_id").val();
            var description = $("#description").val();
            var portfolio = $("#portfolio").val();
            $.ajax({
                type: 'POST',
                url: '<?php echo e(url('add-bid-response')); ?>',
                headers: {"X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>"},
                data: {
                    bid_id: bid_id,
                    description: description,
                    portfolio_link: portfolio,
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

        });
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