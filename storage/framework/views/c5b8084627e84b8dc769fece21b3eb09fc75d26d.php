<?php $__env->startSection('title', 'Sponsorr'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Edit User</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>"/>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Edit User</h3>
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

        <form role="form" method="POST" name="editsubuser" id="editsubuser" action="<?php echo e(route('updateuser')); ?>"
              enctype="multipart/form-data">
            <?php echo e(csrf_field()); ?>

            <input type="hidden" id="userid" name="userid" value="<?php echo e($user->id); ?>">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email_id">Email ID <b style="color: red">*</b></label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo e(@$user->email); ?>"
                                   placeholder="Enter Email Id">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="remark">Remark<b style="color: red">*</b></label>
                            <textarea type="text" class="form-control" id="remark" name="remark"
                                      placeholder="Remark"> <?php echo e(@$user->remark); ?></textarea>
                        </div>
                    </div>
                </div>
                <?php if($user->sponsor_type == 2): ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email_id">Identity <b style="color: red">*</b></label>
                                <select name="identity" id="identity" class="form-control" required>
                                    <option value="">Select Indentity</option>
                                    <option value="Freelancers" <?php if($user->identity == 'Freelancers'): ?> selected <?php endif; ?>>
                                        Freelancers
                                    </option>
                                    <option value="Agencies" <?php if($user->identity == 'Agencies'): ?> selected <?php endif; ?>>Agencies</option>
                                    <option value="Networks"
                                            <?php if($user->identity == 'Networks'): ?> selected <?php endif; ?>>Networks
                                    </option>
<option value="Communities"
                                            <?php if($user->identity == 'Communities'): ?> selected <?php endif; ?>>Communities
                                    </option>

                                </select>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if($user->sponsor_type == 3): ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="company_name">Company Name <b style="color: red">*</b></label>
                                <input type="text" class="form-control" id="company_name" name="company_name"
                                       value="<?php echo e(@$user->company_name); ?>"
                                       placeholder="Enter Company Name" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contact_person">Contact Person <b style="color: red">*</b></label>
                                <input type="text" class="form-control" id="contact_person" name="contact_person"
                                       value="<?php echo e(@$user->contact_person); ?>"
                                       placeholder="Enter Contact Person" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="HQ">HQ <b style="color: red">*</b></label>
                                <input type="text" class="form-control" id="HQ" name="HQ" value="<?php echo e(@$user->HQ); ?>"
                                       placeholder="Enter HQ" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone_no">Phone No <b style="color: red">*</b></label>
                                <input type="text" class="form-control" id="phone_no" name="phone_no"
                                       value="<?php echo e(@$user->phone_no); ?>"
                                       placeholder="Enter Phone No" required>
                            </div>
                        </div>
                    </div>

                <?php endif; ?>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right" id="adduserbutton" name="adduserbutton">Update
                    User <i class="fa fa-refresh fa-spin upload_spin" style="display: none"></i></button>
                <a href="" class="btn btn-danger pull-right">Cancel</a>
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
                email: {
                    required: true,
                    pattern: /^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i
                }
            },
            messages: {
                email: {
                    required: "Enter a Valid Email ID",
                    pattern: "Enter a Valid Email ID"
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