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
            <td colspan="7" class="text-right" style="font-size:15px; font-weight:bold; line-height:35px;">Pay via Wallet 
            <input type="checkbox" value="<?=$wallet_balance  ?>" name="wallet_balance" class="walletcheck form-controle" style="height: 18px; width: 28px; margin-top: 10px; position: absolute;" />
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


        <tr>
            <td colspan="7" class="text-right" style="line-height:35px;"> 
            <label>
                <span>Pay via Voucher</span>
                <input type="checkbox" name="list" value="" class="click_voucher" style="height: 18px; width: 28px; margin-top: 10px; position: absolute;"/>
                </label>
            </td>
            <td colspan="2" style="line-height:35px;">

            <div id="voucher_row" class="form-group autocomplete" style="width: 100%; display: block; margin-left: auto; margin-bottom:10px; margin-right: 0;">
              
                <label id="voucher_td" style="display: inline-block; float: right; width: 80%;">
                    <div class="input-group" style="position:absolute;">
                    <input type="search" class="form-control voucher_textbox" name="voucher_code" id="voucher_code" placeholder="Code" >
                    <span class="input-group-btn">
                    <button class="btn btn-primary voucher_button" type="button" >
                    </span> <i class='fa fa-thumbs-o-up'></i> 
                    </button>
                    
                    </div>
                    
                <button class="btn btn-success btn-sm"><i class='fa fa-thumbs-o-up'></i> Apply</button>    
            </label>
			</div>
                    <input type="hidden" id="vouch_amount" value="0" />
                    <input type="hidden" id="voucher_code_new" name="voucher_code_new" value="" />
                
            </td>
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

    $(document).ready(function(){
        $("#voucher_row :input").prop("disabled", true);
    });

  
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
            //var paid_amt = parseInt(<?php echo isset($total)?$total:0; ?>)

            var vcheck = $("#vouch_amount").val();
            if(vcheck > 0)
            {
                var p = parseInt(<?php echo isset($total)?$total:0; ?>)
                var a = parseInt($("#vouch_amount").val());
                var paid_amt = p-a;
            }
            else{
                var paid_amt = parseInt(<?php echo isset($total)?$total:0; ?>)
            }

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
            
            var check = $("#vouch_amount").val();
            if(check > 0)
            {
                var p = parseInt(<?php echo isset($total)?$total:0; ?>)
                var a = parseInt($("#vouch_amount").val());
                var paid_amt = p-a;
            }
            else{
                var paid_amt = parseInt(<?php echo isset($total)?$total:0; ?>)
            }


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



    $(".click_voucher").click(function(){

        var check = $(".click_voucher").prop("checked");
        if(check){
           
            $("#voucher_td :input").prop("disabled", false);
            $(".voucher_button").click(function(){
                        var code = $(".voucher_textbox").val();
                        if(code ==""){alert('please enter voucher code'); $(".voucher_textbox").focus(); return false;}
                        swal({
                        title: "Are you sure",
                        text: "You want to apply this code",
                        icon: "warning",
                        buttons: true,
                        }).then(
                            function (isConfirm) {
                                if (isConfirm) 
                                {
                                    
                                    $.ajax({
                                        url: "<?php echo e(route('check-vouch-code')); ?>",
                                        type: 'POST',
                                        data: {code: code},
                                        headers: {
                                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                        },
                                        success: function (data) {
                                            if(data > 0){
                                                $("#vouch_amount").val(data);
                                                $('#voucher_code_new').val(code);
                                                swal("Success", "Voucher has been applied", "success");
                                                var pamt = $("#paidamt").html();
                                                console.log(data);
                                                console.log(pamt);
                                                if(data < parseInt(pamt)){
                                                    var fval = pamt-data;
                                                }
                                                else{
                                                    var fval = 0;
                                                }
                                                
                                                $("#paidamt").html(fval);
                                                $("#voucher_td :input").prop('disabled',true);
                                            }
                                            else{
                                                swal("Warning", "voucher not exist or used", "warning");
                                            }
                                            
                                        },
                                        error: function () {
                                            swal("error", "There's been an error", "error");
                                        }
                                    });


                                }
                            });

                    
                    });
        }
        else{
                 
                    var chk = parseInt($("#paidamt").html());
                    var vamt = parseInt($("#vouch_amount").val());
                    if(vamt > 0){var famt = chk+vamt;} 
                    else{var famt = chk;}
                    
                    $("#voucher_td :input").prop("disabled", false);
                    $(".voucher_textbox").val('');
                    $("#paidamt").html(famt);
                    $('#voucher_code_new').val('');
                    var vamt = parseInt($("#vouch_amount").val(0));
        }
    });
   
  
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>