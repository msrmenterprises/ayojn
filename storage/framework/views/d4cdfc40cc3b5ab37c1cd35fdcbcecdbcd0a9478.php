<?php $__env->startSection('content'); ?>
    

    
    <script src="<?php echo e(asset('js/typed.min.js')); ?>"></script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <br><br><br><br>
    <section id="feed" class="speakers">
        <div class="container" style="padding-top: 15px;">
            <div class="row"><h3 style="text-align: center;">Launched Opportunities</h3>
            </div>
            <br>
            <br>
            <div class="row">
                <table id="table_id" class="display">
                    <thead>
                    <tr>
                        <th>Opportunity ID</th>
                        <th>Opportunity</th>
                        <th>Country</th>
                        <th>Industry</th>
                        <!--<th>Added Date</th> -->
                        <th>Action</th>
                        
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(!empty($bidData->first())): ?>
                        <tr>
                            <td>#<?php echo e($bidData->id); ?></td>
                            <td><?php echo e($bidData->hashtag); ?></td>
                            <td><?php echo e((!empty($bidData->country_name)) ? $bidData->country_name->country_name : "-"); ?></td>
                            <td><?php echo e((!empty($bidData->industry)) ? $bidData->industry->name : '-'); ?></td>
                        <!--<td><?php echo e(Date("Y-m-d",strtotime($bidData->created_at))); ?></td> -->
                            <td id="vouch_<?php echo e($bidData->id); ?>">
                                <?php if(!empty(Auth::user()) && Auth::user()->sponsor_type == 1): ?>
                                    <?php if(empty($bidData->vouchResponse)): ?>
                                        <?php if(!empty(Auth::user()) && Auth::user()->id != ''): ?>
                                            <a href="javascript:void(0)" onclick="getVouchForm(<?php echo e($bidData->id); ?>)"
                                               class="btn btn-primary">Vouch</a>
                                        <?php else: ?>
                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#loginForm">
										<span
                                            class="label label-info">Vouch</span>
                                            </a>
                                        <?php endif; ?>
                                    <?php else: ?>

                                        <?php if(!empty($bidData->vouchResponse) && empty($bidData->vouchResponse->vouchesResponseUser->first())): ?>
                                            <span class="badge badge-info">Pending</span>
                                        <?php else: ?>
                                            <?php if(!empty($bidData->vouchResponse->vouchesResponseUser->first())): ?>
                                                <?php $email = '';
                                                foreach ($bidData->vouchResponse->vouchesResponseUser as $us) {
                                                    $email = $email . $us->opportunityUser->email . ", ";
                                                }?>
                                                <a href="javascript:void(0)" style="font-size: 25px"
                                                   onclick="displayEmail('<?php echo e($email); ?>')"><span
                                                        class="badge badge-info">Respond</span></a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                            
                            
                            
                            
                            
                            
                            
                            
                        </tr>
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
                        $("#append-form").append(data.html);
                        $("#add-bid").modal('show');
                    }
                },
                error: function (data) {
                },
            })
        }

        function displayEmail(email) {
            swal("Log in/ Sign up to Explore this opportunity");
        }
    </script>
    
    

    <script>

        $(document).ready(function () {

            $('#table_id').DataTable();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>