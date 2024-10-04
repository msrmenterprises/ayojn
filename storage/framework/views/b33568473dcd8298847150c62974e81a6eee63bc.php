<?php $__env->startSection('content'); ?>
    <!-- banner section start -->
    <section>
        <div class="container" style="padding-top: 15px;">
        <?php if(session('cart')): ?>        
<form action="<?php echo e(route('checkout')); ?>" method="post">
            <div class="row">
                <div class="col-md-12" style="padding-top: 15px;">
                    <?php if(session()->has('success')): ?>
                        <div class="alert alert-success">
                            <?php echo e(session()->get('success')); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
         
            <br>
            <div class="row">
            

<table id="cart" class="table table-hover table-condensed">
    <thead>
        <tr>
        <th>Deal Type</th>
        <th>Suited For</th>
        <th>Core Offer</th>
        <th>Discount (%)</th>
        <th>Deal Amount</th>
        <th>Available In</th>
        <th width="10%">Quantity</th>
        <th width="7%" class="text-center">Total</th>
        <th></th>
        </tr>
    </thead>
    <tbody>
        <?php $total = 0 ?>
        
            <?php $__currentLoopData = session('cart'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $total += $details['deal_amount'] * $details['quantity'] ?>
            <tr data-id="<?php echo e($id); ?>">
                <td><?php echo e($details['identity']); ?></td>
                <td><?php echo e($details['industry']); ?></td>
                <td><?php echo e($details['title']); ?></td>
                <td><?php echo e($details['discount']); ?></td>
                <td><?php echo e($details['deal_amount']); ?></td>
                <td><?php echo e($details['country_name']); ?></td>
                <td data-th="Quantity">
                    <input type="number" value="<?php echo e($details['quantity']); ?>" class="form-control quantity cart_update" min="1" />
                </td>
                <td class="text-center" style="font-size:18px; font-weight:bold; "><?php echo e($details['deal_amount'] * $details['quantity']); ?></td>
                <td class="actions" data-th="">
                    <button class="btn btn-danger cart_remove"><i class="fa fa-trash-o"></i></button>
                    
                </td>
            </tr>  
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      
    </tbody>
    <tfoot>
       <tr>
            <td colspan="7" class="text-right" style="font-size:15px; font-weight:bold; line-height:35px;">Payble Amount</td>
            <td class="text-center" style="font-size:18px; font-weight:bold; line-height:35px;">
            <input type="hidden" name="pay_hidden" value="<?php echo e($total); ?>" />
            <?php echo e($total); ?>

            </td>
            <td></td>
        </tr>

        <tr>
            <?php
                $wallet_balance = \DB::table('users')->where('id',Auth::user()->id)->value('wallet_balance');
            ?>
            <td colspan="7" class="text-right" style="font-size:15px; font-weight:bold; line-height:35px;">Wallet Balance 
            <input type="checkbox" value="<?=$wallet_balance  ?>" name="wallet_balance" class="walletcheck form-controle" style="height: 15px; width: 28px; margin-top: 10px; position: absolute;" />
            <input type="hidden" name="walletamt_hidden" id="walletamt_hidden" value="<?=$wallet_balance; ?>" />

            <input type="hidden" id="wallet_use" name="wallet_use" />

            </td>
            <td class="text-center" style="font-size:18px; font-weight:bold; line-height:35px;">
            <span id="walletamt">
              
                <?php echo e($wallet_balance); ?>

            </span>
            </td>
            <td></td>
        </tr>

        <tr style="background-color:#e4e4e4;">
            <td colspan="7" class="text-right" style="font-size:15px; font-weight:bold; line-height:35px;">Paid Amount</td>
            <td class="text-center" style="font-size:18px; font-weight:bold; line-height:35px;">
            <span id="paidamt"><?php echo e($total); ?></span>
            <input type="hidden" name="paidamt_hidden" value="<?php echo e($total); ?>" id="paidamt_hidden" />
            </td>
            <td></td>
        </tr>

        <tr>
            <td colspan="9" class="text-right">
                <br/>
                <button class="btn btn-success"><i class="fa fa-money"></i> Pay Now</button>
            </td>
        </tr>
    </tfoot>
</table>

</form>
<?php else: ?>

<?php if($rstorder > 0): ?>
<div class="row text-center" >
    <h2 style="padding-top:140px; display: inline-block;">Your offers has been successfully redeem, check your <a href="<?php echo e(url('marketplace-history')); ?>">history</a></h2>
</div>
<?php else: ?>
<div class="row text-center" >
    <h2 style="padding-top:140px; display: inline-block;">No offers found, in Cart </h2>
</div>
<?php endif; ?>


<?php endif; ?>            </div>

        </div>
    </section>
    <script src="<?php echo e(asset('js/jquery1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/typed.min.js')); ?>"></script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>
    


<script type="text/javascript">
  
    $(".cart_update").change(function (e) {
        e.preventDefault();
        var ele = $(this);
        console.log(ele);
  
        $.ajax({
            url: '<?php echo e(route('update_cart')); ?>',
            method: "patch",
            data: {
                _token: '<?php echo e(csrf_token()); ?>', 
                id: $(this).parents("tr").attr("data-id"), 
                quantity: $(this).parents("tr").find(".quantity").val()
            },
            success: function (response) {
               window.location.reload();
            }
        });
    });
  
    $(".cart_remove").click(function (e) {
        e.preventDefault();
  
        var ele = $(this);
  
        if(confirm("Do you really want to remove?")) {
            $.ajax({
                url: '<?php echo e(route('remove_from_cart')); ?>',
                method: "DELETE",
                data: {
                    _token: '<?php echo e(csrf_token()); ?>', 
                    id: ele.parents("tr").attr("data-id")
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        }
    });


    $(".walletcheck").click(function(){

        check = $(".walletcheck").prop("checked");
        if(check) {
            var wallet_amt = parseInt(<?php echo isset($wallet_balance)?$wallet_balance:0; ?>)
            var paid_amt = parseInt(<?php echo isset($total)?$total:0; ?>)

            if(wallet_amt>paid_amt)
            {
                var walletfinal = wallet_amt-paid_amt;
                var finalpaid = 0;
                var wallet_use = paid_amt;
            }
            else{
                var finalpaid = paid_amt-wallet_amt;
                var walletfinal = 0;
                var wallet_use = wallet_amt;
            }

            $("#wallet_use").val(wallet_use);
            $("#walletamt").html(walletfinal);
            $("#walletamt_hidden").val(walletfinal);
            $("#paidamt").html(finalpaid);
            $("#paidamt_hidden").val(finalpaid);


        } else {
            
            var wallet_amt = parseInt(<?php echo isset($wallet_balance)?$wallet_balance:0; ?>)
            var paid_amt = parseInt(<?php echo isset($total)?$total:0; ?>)

            if(wallet_amt>paid_amt)
            {
                var walletfinal = wallet_amt;
                var finalpaid = <?php echo isset($total)?$total:0; ?>;
                var wallet_use = 0;
            }
            else{
                var finalpaid =  paid_amt;
                var walletfinal = wallet_amt;
                var wallet_use = 0;
            }

            $("#wallet_use").val(wallet_use);
            $("#walletamt").html(walletfinal);
            $("#walletamt_hidden").val(walletfinal);
            $("#paidamt").html(finalpaid);
            $("#paidamt_hidden").val(finalpaid);
        }
    });



   
  
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>