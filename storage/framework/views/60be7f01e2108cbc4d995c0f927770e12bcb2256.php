<?php $__env->startSection('content'); ?>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <br><br><br><br>
    <section id="feed" class="speakers">
        <div class="container">
            <br>
            <br>
            <div class="row">
                <table id="table_id" class="display">
                    <thead>
                    <tr>
                        <th>Event Organizer</th>
                        <th>Event Title</th>
                        <th>Event start Date</th>
                        <th>Event finish Date</th>
                        <th>Geo focus</th>
                        <th>Industry</th>
                        <th>Timezone</th>
                        <th>Event Type</th>
                        <th>Event Location</th>
                        <th>Event Fee <br/> Payment Link</th>
                        <th>Want to Attend</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(!empty($othersEvents->first())): ?>
                        <?php $__currentLoopData = $othersEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key1=>$oevent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php if(!empty($oevent->organizer)): ?> <?php echo e($oevent->organizer->entity); ?> <?php else: ?>
                                        - <?php endif; ?></td>
                                <td><?php echo e($oevent->event_title); ?></td>
                                <td><?php echo e($oevent->event_date); ?></td>
                                <td><?php echo e($oevent->event_finish); ?></td>
                                <td><?php echo e((!empty($oevent->country_name)) ? $oevent->country_name->country_name : '-'); ?></td>
                                <td><?php echo e((!empty($oevent->industry)) ? $oevent->industry->name : '-'); ?></td>
                                <td><?php echo e($oevent->timezone); ?></td>
                                <td><?php echo e($oevent->event_type); ?></td>
                                <td><?php echo e($oevent->event_location); ?></td>
                                <td><?php echo e($oevent->event_free_paid); ?> <br/> <?php echo e($oevent->event_fee); ?> <br/>

                                    <?php if(!empty($oevent->payment_link)): ?> <a
                                            href="<?php echo e($oevent->payment_link); ?>" target="_blank"
                                            class="btn btn-primary"
                                    >Payment Link</a> <?php else: ?> - <?php endif; ?>

                                </td>

                                <td>
                                    <?php
                                        $diff =0;
                                            $currentTime = \Carbon\Carbon::now();
                                                $startDate =  \Carbon\Carbon::parse($oevent->event_date);
                                                $diff = $currentTime->diffInHours($startDate);

                                    ?>
                                    <?php if(!empty(Auth::user()) && Auth::user()->id != ''): ?>
                                        <?php if(!empty($oevent->checkAttendes)): ?>
                                            <?php if($diff <= 48): ?>
                                                <a target="_blank" href="<?php echo e($oevent->link); ?>"
                                                   class="btn btn-primary"
                                                >Attend Event</a>
                                            <?php else: ?>
                                                <?php if($oevent->checkAttendes->status ==0): ?>
                                                    Pending
                                                <?php elseif($oevent->checkAttendes->status ==1): ?>
                                                    Approved
                                                <?php else: ?>
                                                    Cancel
                                                <?php endif; ?>

                                                <?php if($oevent->checkAttendes->status ==0 || $oevent->checkAttendes->status ==1): ?>
                                                    <a href="javascript:void(0)"
                                                       onclick="CancelRequest(<?php echo e($oevent->checkAttendes->id); ?>)"
                                                       title="cancel"><i
                                                            class="fa-2x fa fa-times-circle-o"
                                                            style="color: red"></i> </a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <a href="javascript:void(0)"
                                               onclick="sendRequest(<?php echo e($oevent->id); ?>)"><i
                                                    class="fa fa-paper-plane"></i> </a>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#loginForm">
                                            <i
                                                class="fa fa-paper-plane"></i>
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
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>


    <script src="<?php echo e(asset('js/jquery1.min.js')); ?>"></script>

    <script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/typed.min.js')); ?>"></script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script>

        $(document).ready(function () {

            $('#table_id').DataTable();
        });

        function sendRequest(eventId) {

            swal({
                title: 'Are you sure?',
                text: 'Are you sure that you want to attend event?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Change it!'
            }).then(
                function (isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            url: "<?php echo e(url('attend-event'). '/'); ?>" + eventId,
                            type: 'post',
                            data: {
                                "_token": "<?php echo e(csrf_token()); ?>"
                            },
                            success: function () {
                                // delete the row from the table
                                swal("Requested", "Request has been deleted successfully.", "success");

                            },
                            error: function () {
                                // Show an alert with the result

                                swal("status not changed", "error");
                            }
                        });
                    }
                });
        }

        function CancelRequest(attendeId) {

            swal({
                title: 'Are you sure?',
                text: 'Are you sure that you want to cancel this event?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Change it!'
            }).then(
                function (isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            url: "<?php echo e(url('cancel-event'). '/'); ?>" + attendeId,
                            type: 'post',
                            data: {
                                "_token": "<?php echo e(csrf_token()); ?>"
                            },
                            success: function () {
                                // delete the row from the table
                                swal("Requested", "Request has been sent successfully.", "success");
                                setTimeout(function () {
                                    location.reload();
                                }, 2000);
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