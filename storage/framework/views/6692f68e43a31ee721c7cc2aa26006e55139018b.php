<!--Add title-->
<?php $__env->startSection('title',  'Sponsorr'); ?>
<!--Main Body content-->
<?php $__env->startSection('content'); ?>
    <!-- //banner-top -->
    <!-- banner -->
    <!-- Content Header (Page header) -->

    <section class="content-header">
        <h1>
            Partner
            <small>List</small>

        </h1>


        <ol class="breadcrumb">


            <li><a href="<?php echo e(url('admin/dashboard')); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Partner List</li>

        </ol>
    </section>
    <style type="text/css">
        .mb20 {
            margin-bottom: 20px;
        }

        .checkbox {
            margin-top: 0px;
        }
    </style>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class="col-md-12">
                            <?php if(session()->has('success')): ?>
                                <div class="alert alert-success">
                                    <?php echo e(session()->get('success')); ?>

                                </div>
                            <?php endif; ?>
                            <?php if($errors->any()): ?>
                                <div class="alert alert-danger">
                                    <ul>
                                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e($error); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <?php if(session('true')): ?>
                                <div class="alert alert-success alert-dismissable">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <?php echo e(session('true')); ?>

                                </div>
                            <?php endif; ?>
                            <?php if(session('false')): ?>
                                <div class="alert alert-danger alert-dismissable">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <?php echo e(session('false')); ?>

                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-12">
                            
                            
                            
                            
                        </div>
                    </div>

                    <div class="box-body table-responsive">
                        <table id="data-table" class="table table-bordered table-striped last-child-sm" width="100%"
                               data-page-length='100'>
                            <thead>
                            <tr>
                                <th width="3%">Company Name</th>
                                <th width="7%">Contact person</th>
                                <th width="7%">Email</th>
                                <th width="7%">Phone Number</th>
                                <th width="5%">Referral Count</th>
                                <th width="5%">Mode Of register</th>
                                <th width="5%">Last Login</th>
                                <th width="5%">Status</th>
                                <th width="5%">Action</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th width="3%">Company Name</th>
                                <th width="7%">Contact person</th>
                                <th width="7%">Email</th>
                                <th width="7%">Phone Number</th>
                                <th width="5%">Referral Count</th>
                                <th width="5%">Mode Of register</th>
                                <th width="5%">Last Login</th>
                                <th width="5%">Status</th>
                                <th width="5%">Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- form start -->
                    <div class="box-footer clearfix text-right">

                    </div>
                    <div id="append-form"></div>
                </div>
                <!-- /.box -->
            </div>
            <!--/.col (left) -->
        </div>
    </section>

    <script type="text/javascript">
        var oTable;
        $(function () {
            var url = "<?php echo e(URL::to('controlpanel/partner/list-users')); ?>";
            var oTable = $('#data-table').DataTable({
                // dom: "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>"+
                // "<'row'<'col-xs-12't>>"+
                // "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>",
                bFilter: true,
                bLengthChange: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: url,
                    type: "POST",
                    headers: {"X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>"},
                    data: function (d) {

                    }
                },
                columns: [
                    // {data: 'check', name: 'check', sorting: false, orderable: false},
                    {"data": "company_name"},
                    {"data": "contact_person"},
                    {"data": "email"},
                    {"data": "phone_no"},
                    {"data": "referral_count"},
                    {"data": "refer_by_user"},
                    {"data": "last_login_at"},
                    {"data": 'userstatus', "name": 'userstatus'},
                    {"data": "action", orderable: false}
                ], "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    $(nRow).attr("data-id", aData['id']);
                    return nRow;
                },
            });

            $('#moveprofile').on('submit', function (e) {
                if ($('#admin_from').val() != '' && $('#admin_to').val() != '') {
                    oTable.draw();
                } else {
                    toastr.error("Admin From And To Is Required", "Error");
                }
                e.preventDefault();
            });
        });
        function deleteUser(id) {
            swal({
                title: 'Are you sure?',
                text: 'Are you sure that you want to delete this user?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    var url = "<?php echo e(route('delete-user')); ?>";
                    $('#spinner').show();
                    $.ajax({
                        url: url,
                        method: "POST",
                        data: {user_id: id},
                        headers: {"X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>"},
                        success: function (data) {
                            obj = jQuery.parseJSON(data);
                            if (obj.msg) {
                                $('#spinner').hide();
                                swal("Success", obj.msg, "success");
                                $('#data-table').DataTable().draw(false)

                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            $('#spinner').hide();
                            swal("warning", "Please try again", "error");
                        }
                    });
                }
            })
        }

        function changeStatus(id) {

            swal({
                title: 'Are you sure?',
                text: 'Are you sure that you want to change status?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, change it!'
            }).then((result) => {
                if (result.value) {
                    var url = "<?php echo e(route('user-change-status')); ?>";
                    $('#spinner').show();
                    $.ajax({
                        url: url,
                        method: "POST",
                        headers: {"X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>"},
                        data: {user_id: id},
                        success: function (data) {
                            obj = jQuery.parseJSON(data);
                            $('#spinner').hide();
                            if (obj.status == 1) {
                                $('#cust_id' + id).addClass("label-success");
                                $('#cust_id' + id).removeClass("label-danger");
                                $('#cust_id' + id).html("Approved");
                            } else {
                                $('#cust_id' + id).removeClass("label-success");
                                $('#cust_id' + id).addClass("label-danger");
                                $('#cust_id' + id).html("Disapproved");
                            }
                            swal("Updated", obj.msg, "success");
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            $('#spinner').hide();
                            swal("warning", "Please try again", "error");
                        }
                    });
                }
            })
        }

        function userChangeStatusSuspendWithComment(responseId) {
            $.ajax({
                url: "<?php echo e(url('/')); ?>" + '/controlpanel/user-change-status-suspand/' + responseId,
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

        function changeSuspendStatus(id) {

            swal({
                title: 'Are you sure?',
                text: 'Are you sure that you want to change status?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, change it!'
            }).then((result) => {
                if (result.value) {
                    var url = "<?php echo e(route('user-change-status-suspand')); ?>";
                    $('#spinner').show();
                    $.ajax({
                        url: url,
                        method: "POST",
                        headers: {"X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>"},
                        data: {user_id: id},
                        success: function (data) {
                            obj = jQuery.parseJSON(data);
                            $('#spinner').hide();
                            if (obj.status == 1) {
                                $('#user_id' + id).addClass("label-danger");
                                $('#user_id' + id).html("Suspended");
                            } else {
                                $('#user_id' + id).addClass("label-danger");
                                $('#user_id' + id).html("Suspend");
                            }
                            swal("Updated", obj.msg, "success");
                            setTimeout(function () {
                                location.reload()
                            }, 1500)
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            $('#spinner').hide();
                            swal("warning", "Please try again", "error");
                        }
                    });
                }
            })
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>