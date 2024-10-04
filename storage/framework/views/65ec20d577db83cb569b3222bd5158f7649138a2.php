<?php $__env->startSection('content'); ?>
    <!-- banner section start -->
    <section>
        <div class="container" style="padding-top: 15px;">
            <div class="row"><h3 style="text-align: center;">Offers</h3>
            </div>
            <div class="row">

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
            <br>
            <div class="row">
                <?php if(!empty($offer)): ?>
                    <table id="table_id" class="display">
                        <thead>
                        <tr>
                            <th>Offer For</th>
                            <th>Identity</th>
                            <th>Function</th>
                            <th>Title</th>
                            <th>Discount (%)</th>
                            <th>Deal Amount</th>
                            <th>Country</th>
                            <th>Currency</th>
                            <?php if(!empty(Auth::user())): ?>
                                <th>Weblink</th>
                            <?php endif; ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($offer)): ?>
                            <tr>
                                <td><?php echo e($offer->offer_for); ?></td>
                                <td><?php echo e($offer->identity); ?></td>
                                <td><?php echo e($offer->function); ?></td>
                                <td><?php echo e($offer->title); ?></td>
                                <td><?php echo e($offer->discount); ?></td>
                                <td><?php echo e($offer->deal_amount); ?></td>
                                <td><?php echo e($offer->country->country_name); ?></td>
                                <td><?php echo e($offer->currency); ?></td>
                                <?php if(!empty(Auth::user())): ?>
                                    <td>
                                        <?php if(!empty($offer->weblink)): ?>
                                            <a class="btn btn-primary" href="<?php echo e($offer->weblink); ?>" target="_blank">Open
                                                Link</a>
                                        <?php endif; ?>
                                    </td>
                                <?php endif; ?>


                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="row">
                        <div class="col-md-12" style="padding-top: 15px;">
                            Offer not available right now
                        </div>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </section>
    <script src="<?php echo e(asset('js/jquery1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/typed.min.js')); ?>"></script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {

            $('#table_id').DataTable({});
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>