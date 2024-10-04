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
    <div class="login-box"  style="width: 360px;
    margin: 12% auto;">
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg"><?php echo e(trans('adminlte::adminlte.password_reset_message')); ?></p>
            <form action="<?php echo e(url('/password/reset')); ?>" method="post">
                <?php echo csrf_field(); ?>


                <input type="hidden" name="token" value="<?php echo e($token); ?>">

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
                <div class="form-group has-feedback <?php echo e($errors->has('password') ? 'has-error' : ''); ?>">
                    <input type="password" name="password" class="form-control"
                           placeholder="<?php echo e(trans('adminlte::adminlte.password')); ?>">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    <?php if($errors->has('password')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('password')); ?></strong>
                        </span>
                    <?php endif; ?>
                </div>
                <div class="form-group has-feedback <?php echo e($errors->has('password_confirmation') ? 'has-error' : ''); ?>">
                    <input type="password" name="password_confirmation" class="form-control"
                           placeholder="<?php echo e(trans('adminlte::adminlte.retype_password')); ?>">
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                    <?php if($errors->has('password_confirmation')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('password_confirmation')); ?></strong>
                        </span>
                    <?php endif; ?>
                </div>
                <button type="submit"
                        class="forgot_button"
                ><?php echo e(trans('adminlte::adminlte.reset_password')); ?></button>
            </form>
        </div>
        <!-- /.login-box-body -->
    </div><!-- /.login-box -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>