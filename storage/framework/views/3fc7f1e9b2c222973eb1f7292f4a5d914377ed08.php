<!--Add title-->
<?php $__env->startSection('title',  'Sponsorr'); ?>
<!--Main Body content-->
<?php $__env->startSection('content'); ?>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Upload Users</h3>
        </div>
        <?php if($message = Session::get('success')): ?>
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong><?php echo e($message); ?></strong>
            </div>
        <?php endif; ?>


        <?php if($message = Session::get('error')): ?>
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong><?php echo e($message); ?></strong>
            </div>
        <?php endif; ?>
        <form role="form" class="form-horizontal" method="POST" name="addcountry_import" id="addcountry_import" action="<?php echo e(route('import-excel')); ?>" enctype="multipart/form-data">
            <?php echo e(csrf_field()); ?>

            <div class="box-body">
                <div class="form-group">
                    <label for="countryname" class="col-sm-2 control-label">User Data</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="lead_file" name="lead_file" maxlength="50" placeholder="Country Name">
                    </div>
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right" id="addexportbutton" name="addexportbutton">Import Users</button>
                <!-- <a href="#"  class="btn btn-danger pull-right">Cancel</a> -->
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>