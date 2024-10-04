<?php $__env->startSection('content'); ?>
    <style>

        .forgot_button{
            height: 45px;
            width: 150px;
            text-align: center;
            line-height: 45px;
            margin-right: 0;
            border-radius: 40px;
            background: #52616D;
            color: #fff;
        }
        
    </style>
    <!-- Resources -->
    <div style="width: 360px;
    margin: 12% auto;">
        <div class="row">
            <div class="col-md-12">
                <?php if(session('status')): ?>
                    <div class="alert alert-success">
                        <?php echo e(session('status')); ?>

                    </div>
                <?php endif; ?>
                <form action="<?php echo e(url('/password/email')); ?>" method="post">
                    <?php echo csrf_field(); ?>

                    <span>Enter email address</span>
                    <div class="form-group has-feedback <?php echo e($errors->has('email') ? 'has-error' : ''); ?>">
                        <input type="email" name="email" class="form-control" value="<?php echo e(isset($email) ? $email : old('email')); ?>"
                               placeholder="<?php echo e(trans('adminlte::adminlte.email')); ?>">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        <?php if($errors->has('email')): ?>
                            <span class="help-block">
                            <strong><?php echo e($errors->first('email')); ?></strong>
                        </span>
                        <?php endif; ?>
                    </div>
                    <button type="submit"
                            class="forgot_button"
                    >Send Reset Link</button>
                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>