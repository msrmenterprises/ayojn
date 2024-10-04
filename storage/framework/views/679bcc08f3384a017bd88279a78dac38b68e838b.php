<!--Add title-->
<?php $__env->startSection('title',  'Sponsorr'); ?>
<!--Main Body content-->
<?php $__env->startSection('content'); ?>
    <!-- //banner-top -->
    <!-- banner -->
    <!-- Content Header (Page header) -->

    <section class="content-header">
        <h1>
            Offer
            <small>List</small>

        </h1>


        <ol class="breadcrumb">


            <li><a href="<?php echo e(url('admin/dashboard')); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Offer List</li>

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

                    <div class="box-body table-responsive">
                        <table id="data-table" class="table table-bordered table-striped last-child-sm" width="100%"
                               data-page-length='100'>
                            <thead>
                            <tr>
                            <th width="3%">Id</th>
                                <!-- <th>Name</th> -->
                                <th width="7%">E-mail</th>
                                <th width="7%">Phone no</th>
                                <th width="15%">Sponsorship Type</th>
                                <th width="7%">Entity</th>
                                <th width="10%">Identity</th>
                            
                              
                                <th width="7%">Last Login</th>
                                <th width="7%">Created At</th>
                                <th width="7%">Action</th>
                               
                            </tr>
                            </thead>
                            <tbody>
                            
                                    <?php $__currentLoopData = $userlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $userlists): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        
                                    <tr>
                                    <td><?php echo e($userlists->id); ?></td>
                                    <td><?php echo e($userlists->email); ?></td>
                                    <td><?php echo e($userlists->phone_no); ?></td>
                                    <td>
                                        <?php if($userlists->sponsor_type==2): ?>
                                            Receive user
                                            <?php else: ?>
                                            Offer user
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($userlists->entity); ?></td>
                                    <td><?php echo e($userlists->identity); ?></td>
                                    <td><?php echo e($userlists->last_login_at??''); ?></td>
                                    <td><?php echo e($userlists->created_at??''); ?></td>
                                    <td>
                                        <?php
                                        $user_id = $userlists->id;
                                        $offer_id = Request::segment(4); 
                                        $order_id = \DB::table('offers_order')->where('user_id', $user_id)->value('id');
                                        $status = \DB::table('offers_order_item')->where('order_id',$order_id)->where('offer_id',$offer_id)->value('status');
                                        ?>

                                        <?php if($status==0): ?>
                                        <a href="javascript:void(0)"  onclick="changeStatus(<?php echo e($userlists->id); ?>)" class="btn btn-danger btn-sm"><i class="fa fa-check"></i> Approve</a>
                                        <?php else: ?>
                                        <a href="javascript:void(0)" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Paid</a>
                                        <?php endif; ?>
                                    </td>
                                    </tr>
                              
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <tfoot>
                            <tr>
                            <th width="3%">Id</th>
                             
                                <th width="7%">E-mail</th>
                                <th width="7%">Phone no</th>
                                <th width="15%">Sponsorship Type</th>
                                <th width="7%">Entity</th>
                                <th width="10%">Identity</th>
                              
                                <th width="7%">Last Login</th>
                                <th width="7%">Created At</th>
                                <th width="7%">Action</th>
                              
                              
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- form start -->
                    <div class="box-footer clearfix text-right">

                    </div>
                    
                </div>
                <!-- /.box -->
            </div>
            <!--/.col (left) -->
        </div>
    </section>



    <script>

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
        var url = "<?php echo e(route('offer-buy-status')); ?>";
        $('#spinner').show();
        $.ajax({
            url: url,
            method: "POST",
            headers: {"X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>"},
            data: {user_id: id, offer_id: <?php echo e(Request::segment(4)); ?>},
            success: function (data) {
                console.log(data)
                $('#spinner').hide();
                if(data==1)
                {
                    location.reload();
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
        </script>
   <?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>