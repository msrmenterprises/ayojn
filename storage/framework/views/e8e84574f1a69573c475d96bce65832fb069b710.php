<?php $__env->startSection('content'); ?>
    <style>
        .error {
            color: red;
        }

        #exTab2 h3 {
        / / color: white;
        / / background-color: #428bca;
            padding: 5px 15px;
        }
    </style>

    <section id="feed" class="speakers">
        <div class="container">
            <div class="row">
                <!-- banner section start -->


                <div class="row" style="margin-bottom: 25px; text-align: center">
                    <h3>Response List</h3>
                </div>
                <div class="row" style="margin-bottom: 15px;">
                    <a href="<?php echo e(url('export-collaborator') ."/". $eventId); ?>" class="btn btn-success">Export
                        Collborators</a>
                    <br>
                </div>
                <div class="row">
                    <table id="table_id" class="display table">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th> Email</th>
                            <th> Phone no</th>
                            <th> Description</th>
                            <th> Portfolio</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($attendeedList->first())): ?>
                            <?php $__currentLoopData = $attendeedList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($event->id); ?></td>
                                    <td><?php echo e(($event->user) ? $event->user->email : '-'); ?></td>
                                    <td><?php echo e(($event->user) ? $event->user->phone_no : '-'); ?></td>
                                    <td><?php echo e($event->description); ?></td>
                                    <td><?php echo e($event->portfolio_link); ?></td>
                                    <td> <?php if($event->status == 1): ?>
                                            Approved
                                        <?php elseif($event->status == 2): ?>
                                            Reject
                                        <?php else: ?> Pending
                                            <a href="javascript:void(0)" onclick="changeStatus(<?php echo e($event->id); ?>)"><i
                                                    class="fa fa-pencil-square-o"></i> </a>
                                        <?php endif; ?>


                                    </td>

                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>

    <script src="<?php echo e(asset('js/jquery1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/typed.min.js')); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#table_id').DataTable();
        });

        function changeStatus(attendeId) {

            swal({
                title: 'Are you sure?',
                text: 'Are you sure that you want to accept Collaboration?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Change it!'
            }).then(
                function (isConfirm) {
                    console.log(isConfirm)
                    if (isConfirm.dismiss != 'cancel' && isConfirm.dismiss != 'overlay') {
                        $.ajax({
                            url: "<?php echo e(url('change-collaboration-status'). '/'); ?>" + attendeId,
                            type: 'post',
                            data: {
                                "_token": "<?php echo e(csrf_token()); ?>"
                            },
                            success: function () {
                                // delete the row from the table
                                swal("Status Changed", "Request successfully sent.", "success");
                                setTimeout(function () {
                                    location.reload()
                                }, 1500);
                            },
                            error: function () {
                                // Show an alert with the result

                                swal("status not changed", "error");
                            }
                        });
                    }
                });
        }
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>