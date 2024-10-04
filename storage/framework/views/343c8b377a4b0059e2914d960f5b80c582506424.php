<?php $__env->startSection('content'); ?>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <?php
    $f = Request::get('f');
    $cn = Request::get('c');
    $b = Request::get('b');
    $i = Request::get('i');

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
        <div class="container" style="padding-top: 15px;">
            <div class="row"><h3 style="text-align: center;">Launched Opportunities</h3>
            </div>
            <div class="row"><a href="<?php echo e(url('my-vouches')); ?>" class="btn btn-primary float-left">My Vouched
                    Opportunities</a>

            </div>
            <br>
            <div class="row">
                <form name="search">
                    <div class="col-md-3">
                        <input class="form-control" name="f" id="f" placeholder="Search Opportunity">
                    </div>
                    <div class="col-md-2">
                        <select class="form-control" name="c" id="lunch_opportunity_country" onchange="getCity(9)">
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
                        <select class="form-control" name="city" id="lunch_opportunity_city">
                            <option value="">Select City</option>

                        </select>
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
                        
                        <th>Opportunity</th>
                        
                        <th>Industry</th>
                        <!--<th>Added Date</th> -->
                        <th>Action</th>
                        <th>Share</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(!empty($bids->first())): ?>
                        <?php $__currentLoopData = $bids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                
                                <td><?php echo e($bid->hashtag); ?></td>
                                
                                <td><?php echo e((!empty($bid->industry)) ? $bid->industry->name : '-'); ?></td>
                            <!--<td><?php echo e(Date("Y-m-d",strtotime($bid->created_at))); ?></td> -->
                                <td id="vouch_<?php echo e($bid->id); ?>">

                                    <?php if(Auth::user()->free_vouch  < 3 ||  Auth::user()->is_paid == 1): ?>
                                        <a href="javascript:void(0)" onclick="getVouchForm(<?php echo e($bid->id); ?>)"
                                           class="btn btn-primary">Vouch</a>
                                    <?php else: ?>

                                        <a href="javascript:void(0)" onclick="paymentPopUp(<?php echo e($bid->id); ?>)"
                                           class="btn btn-primary">Vouch</a>
                                    <?php endif; ?>


                                </td>
                                <td><span id="opportunity_<?php echo e($bid->id); ?>" class="share-course-filed"
                                          style="display: none"> <?php echo e(url('share-opportunity')."/" . $bid->share_id); ?></span>
                                    <a
                                        href="javascript:void(0)" class="btn btn-primary read-more-btn share-opp-btn"
                                        onclick="copyToClipboard('#opportunity_<?php echo e($bid->id); ?>')">Copy Web link</a></td>
                                
                                
                                
                                
                                
                                
                                
                                
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
        <div id="append-form"></div>
    </section>

    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

    <script>
        $(".share-opp-btn").on('click', function (e) {
            toastr.success('Web Link Copied', 'Success');
        });

        function paymentPopUp(id) {
            const el = document.createElement('div')
            const url = "<?php echo e(url('vouch-payment/')); ?>" + "/" + id;
            el.innerHTML = "<a class='swal-button swal-button--confirm' href='" + url + "'>Pay $5</a>";
            //swal("Good news ! Client would like to negotiate and discuss the proposal. At this stage we highly recommend that you use PandaDoc create winning proposals and send it directly to the client at: ", email);
            swal({
                title: "Please pay to Vouch this bid",
                content: el,
            })
        }


        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).text()).select();
            document.execCommand("copy");
            $temp.remove();
            toastr.success('Web Link Copied', 'Success');
        }

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

        function getVouchForm(vouchId) {
            $.ajax({
                url: "<?php echo e(url('/')); ?>" + '/add-vouch/' + vouchId,
                type: "get",
                async: false,
                headers: {"X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>"},
                success: function (data) {
                    if (data.html != '') {
                        $("#append-form").html(data.html);
                        $("#add-bid").modal('show');
                    }
                },
                error: function (data) {
                },
            })
        }

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