<?php $__env->startSection('content'); ?>
    <!-- banner section start -->
    <section>
        <div class="container" style="padding-top: 15px;">
            <div class="row">
                <h3 style="text-align: center;margin-top:110px; line-height:35px;">Any deal you pick from here will let you avail a discount of 30% on Ayojn’s next service fee.
                
            <br/>
            <span style="color:red;">Wallet Balance : <b><?php echo e(Auth::user()->wallet_balance); ?> points</b>(1 Point = 1 USD) </span>
        </h3>
                
            </div>

            <div class="row">
                <div class="col-md-12" style="padding-top: 15px;">
                    <?php if(session()->has('success')): ?>
                        <div class="alert alert-success">
                            <?php echo e(session()->get('success')); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <br>
            <div class="row">

            </div>
            <br>
            <div class="row">
                <table id="table_id" class="display">
                    <thead>
                    <tr>
                        <th>Deal Type</th>
                        <th>Suited For</th>
                        <th>Core Offer</th>
                        <th>Discount (%)</th>
                        <th>Deal Amount</th>
                        <th>Currency</th>
                        <th>Available In</th>
                        <th>Weblink</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(!empty($offers)): ?>
                        <?php $__currentLoopData = $offers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $offer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($offer->identity); ?></td>
                                <td><?php echo e((!empty($offer->industry) ? $offer->industry->name :'-')); ?></td>
                                <td><?php echo e($offer->title); ?></td>
                                <td><?php echo e($offer->discount); ?></td>
                                <td><?php echo e($offer->deal_amount); ?></td>

                                <td><?php echo e($offer->currency); ?></td>
                                <td><?php echo e($offer->country->country_name); ?></td>
                                <td>
                                    <?php if(!empty($offer->weblink)): ?>
                                        <a class="btn btn-primary" href="<?php echo e($offer->weblink); ?>" target="_blank">Open Link</a>
                                    <?php endif; ?>
                                </td>
                                <td><a href="<?php echo e(route('add_to_cart', $offer->id)); ?>" class="btn btn-success add-to-cart"><i class="fa fa-shopping-cart"></i> Add to Cart</a></td>

                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </section>
    <script src="<?php echo e(asset('js/jquery1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/typed.min.js')); ?>"></script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>
    <script>
        $(".share-opp-btn").on('click', function (e) {
            toastr.success('Web Link Copied', 'Success');
        });

        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).text()).select();
            document.execCommand("copy");
            $temp.remove();
        }

        function changeOffer(id, status) {
            $.ajax({
                type: 'POST',
                url: '<?php echo e(url('partner/change-offer-status')); ?>',
                headers: {"X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>"},
                data: {
                    status: status,
                    id: id
                },
                success: function (response) {
                    var data = response;
                    if (data.status) {
                        toastr.success(response.message, "Success");
                        window.location.reload();
                    } else {
                        toastr.error(response.errors, "Error");
                    }
                },
                error: function (response) {
                    toastr.error(response.responseJSON.msg, "Error");
                    $(':input[type="submit"]').prop('disabled', false);
                },
            });
        }

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