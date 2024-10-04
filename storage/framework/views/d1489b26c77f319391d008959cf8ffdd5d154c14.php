<?php $__env->startSection('title', 'Sponsorr'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Edit Vouch Code</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>"/>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Vouch Code</h3>
        </div>
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
    <!-- /.box-header -->
        <!-- form start -->

        <form role="form" method="POST" name="editsubuser" id="editsubuser" action="<?php echo e(route('vouch-update')); ?>"
              enctype="multipart/form-data">
            <?php echo e(csrf_field()); ?>

            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="vouch_code">Vouch Code<b style="color: red">*</b></label>
                            <input type="text" class="form-control" id="vouch_code" name="vouch_code"
                                   placeholder="Enter Vouch Code" value="<?php echo e($vouchCode->vouch_code); ?>">
                            <input type="hidden" name="code_id" value="<?php echo e($vouchCode->id); ?>">
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right" id="adduserbutton" name="adduserbutton">Update Vouch code<i class="fa fa-refresh fa-spin upload_spin" style="display: none"></i></button>
            </div>
        </form>
    </div>
    <script>
        jQuery.validator.addMethod("nameValid", function (value, element) {
            return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
        });
        jQuery.validator.addMethod("phoneValid", function (value, element) {
            return this.optional(element) || /^[0-9]+$/.test(value);
        });
        jQuery.validator.addMethod("alphanumeric1", function (value, element) {
            return this.optional(element) || /^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9-!@#$%&*?_]+)$/.test(value);
        });
        $("#editsubuser").validate({
            rules: {
                vouch_code: {
                    required: true,
                }
            },
            messages: {
                vouch_code: {
                    required: "Enter a vouch code",
                }
            },
            /*errorPlacement: function (error, element) {
             if (element.attr("name") == "terms") {
             error.appendTo('#error');
             } else {
             error.insertAfter(element);
             }

             },*/
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>