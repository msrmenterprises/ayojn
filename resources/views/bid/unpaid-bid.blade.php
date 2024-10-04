@extends('layout')

@section('content')

    <style>
    .swal-overlay--show-modal {
        z-index: 99999999999 !important;
    }
    .swal-modal {
        z-index: 99999 !important;
    }
    </style>

    <br><br><br><br>
    <section id="feed" class="speakers">
        <div class="container">
            <div class="row">
                <a href="{{ url('bid') }}" class="btn btn-primary float-left"
                >Opportunities </a>

            </div>
            <br>
            <br>
            <div class="row">
                <table id="table_id" class="display">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Wish to Sponsor</th>
                        <th>Specific <br>Opportunity</th>
                        <th>Why this Opportunity</th>
                        <th>Where to Sponsor</th>
                        <th>Identity</th>
                        <th>Expected Budget <br>(USD $)</th>
                        <th>Industry</th>
                        <th>Pay Now</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($bids->first()))
                        @foreach($bids as $bid)
                            <?php
                            $specification = '';
                            $specificationArray = [];
                            ?>
                            @if (!empty($bid->bidSpecify->first()))
                                @foreach ($bid->bidSpecify as $bidS)
                                    @php
                                        $specificationArray[] = $bidS->specifyName->specify_name;
                                        $specification = implode(', ',$specificationArray);
                                    @endphp
                                @endforeach
                            @endif

                            <tr>
                                <td>{{ $bid->id }}</td>
                                @if($bid->sponsor_for=='Online Events')
                                    <td> Online Activities</td>
                                @else
                                    <td>{{ $bid->sponsor_for }}</td>
                                @endif
                                <td>{{ $specification }}</td>
                                <td>{{  $bid->likeSponsorr }}</td>
                                <td>{{  (!empty($bid->country_name)) ? $bid->country_name->country_name : "-" }}
                                    / {{ (!empty($bid->city) && !empty($bid->city_name) && !empty($bid->city_name->name)) ? $bid->city_name['name'] : "-" }}</td>
                            <!--<td>{{ $bid->contacted_by }}</td> -->
                                <td>{{ $bid->identity }}</td>
                                <td>{{ $bid->sponsor_budget }}</td>
                                <td>{{ (!empty($bid->industry)) ? $bid->industry->name : '-'}}</td>

                                <td>
                                    @if($bid->admin_status == 0)
                                        Pending
                                    @else
                                        <!-- <a href="{{ url('pay-now/').'/'.$bid->id }}">
                                            <button class="btn btn-primary">Via Paypal</button>
                                        </a>  
                                        <a data-toggle="modal" data-target="#add-vouch-code">
                                            <input type="hidden" name="bid_id" id="bid_id" value="{{ $bid->id }}">
                                            @if(Auth::user()->refer_by == '' || (Auth::user()->refer_by != '' && Auth::user()->is_bonus_used == 1))
                                                <button class="btn btn-primary">Use a Voucher Code</button>
                                            @endif
                                        </a> -->
                                        @if($bid->is_paid==0)
                                        <a data-toggle="modal" class="paynow_modal" data-id="{{ $bid->id }}" data-sponsor="{{$bid->sponsor_budget}}" data-per="{{$bid->per}}">  
                                            <button class="btn btn-success"> Pay Now</button>
                                        </a>
                                        @endif

                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>

        </div>

    </section>
    <div class="modal" id="add-vouch-code" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 45.56 45.559">
                            <path id="Union_1" data-name="Union 1" class="cls-1"
                                  d="M22.426,22.426,0,44.852,22.426,22.426,0,44.852,22.426,22.426,0,0,22.426,22.426,0,0,22.426,22.426,44.852,0,22.426,22.426,44.852,0,22.426,22.426,44.852,44.852,22.426,22.426,44.852,44.852ZM22.426,22.426Z"
                                  transform="translate(0.354 0.354)"/>
                        </svg>
                    </button>
                    <div style="text-align: center">Use a Voucher Code</div>
                </div>
                <div class="modal-body">

                    <form class="addVouchForm" id="addVouchForm" method="post" onsubmit="return false"
                          name="addVouchForm">

                        <div id="add-opporutnity-form">
                            <div class="row" style="padding-bottom: 8px;">
                                <div class="col-md-3">Vouch Code</div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="vouch_code" id="vouch_code"
                                           placeholder="Use a Voucher Code">
                                </div>
                            </div>

                        </div>
                        <button type="submit" id="addBid" class="btn btn-default" onclick="submitFormVouch()"
                                style="text-align: center">Submit
                        </button>
                    </form>

                </div>

            </div>
        </div>
    </div>



    <div class="modal" id="payment_proof" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
                    <div style="text-align: center">Upload Payment Proof</div>
                   
                </div>
                <div class="modal-body">
                    <span id="proof_attachment"></span>
                   
                <form id="payment_proof_form" enctype="multipart/form-data">
                {!! csrf_field() !!}
                        <input type="hidden" name="proof_bid" id="proof_bid" />
                        <div id="add-opporutnity-form">
                            <div class="row" style="padding-bottom: 8px;">
                                <div class="col-md-3">Select file</div>
                                <div class="col-md-6">
                                    <input type="file" class="form-control" name="payment_proof_img" id="payment_proof_img" required>
                                </div>
                               
                            </div>
                            <span id="error_msg" style="text-align: center; display: block; color: red;"></span>
                        </div>
                        <button type="submit"  class="btn btn-primary">Upload & Pay</button>
                        <a class="btn btn-success continue" style="display:none;">Continue to Pay</a>
                    </form>

                </div>

            </div>
        </div>
    </div>




    <div class="modal" id="paynow_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-sm" role="document" style="width:450px;">
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
				<h4 class="modal-title" id="myModalLabel" style="text-align: center">Payment Details</h4>
				<span style="text-align: center; display: block; color: red;">
                Your will Get <span id="put_per"></span>% in your wallet
                </span>
			</div>
			<div class="modal-body">
			
            <div class="form-group autocomplete" style="margin:0px; width: 100%; display: block; margin-left: auto; margin-right: 0;">
                <label>
                    <strong>Sponsor Budget</strong>
                </label>
                <label class="pull-right" id="put_sponsor_budget">
                </label>
						
			</div>
            <hr style="margin-bottom: 10px; margin-top: 3px;" />


            <div class="form-group autocomplete" style="margin:0px; width: 100%; display: block; margin-left: auto; margin-right: 0;">
                <label>
                    <strong>Service Charges</strong>
                </label>
                <label class="pull-right">
                    100
                </label>
						
			</div>
            <hr style="margin-bottom: 20px; margin-top: 3px;" />
			 

			<div id="wallet_row" class="form-group autocomplete" style="width: 100%; display: block; margin-left: auto; margin-bottom:10px; margin-right: 0;">
                <label>
                
                <input type="checkbox" name="list" value="" class="click_wallet form-control" style="height: 16px; width: 16px; margin-top: 3px; position: absolute;" />
                <span style="margin-left: 25px;">Pay via Wallet</span>
                <input type="hidden" id="wallet_use" name="wallet_use" value="0" />
                </label>
                <label class="pull-right" id="wallet_balance">
                
                {{Auth::user()->wallet_balance}}
                </label>
			</div>


            <div id="voucher_row" class="form-group autocomplete" style="width: 100%; display: block; margin-left: auto; margin-bottom:10px; margin-right: 0;">
                <label>
                <input type="checkbox" name="list" value="" class="click_voucher form-control" style="height: 16px; width: 16px; margin-top: 3px; position: absolute;" />
                <span style="margin-left: 25px;">Pay via Voucher</span>
                </label>
                <label id="voucher_td" style="display: inline-block; float: right; width: 50%;">
                    <div class="input-group" style="position:absolute;">
                    <input type="search" class="form-control voucher_textbox" id="voucher_code" placeholder="Voucher code" >
                    <span class="input-group-btn">
                    <input type="hidden" id="vouch_amount" />
                    <button class="btn btn-primary voucher_button" type="button" >
                    </span> <i class='fa fa-thumbs-o-up'></i> Apply
                    </button>
                    
                    </div>

                
                <button class="btn btn-success btn-sm"><i class='fa fa-thumbs-o-up'></i> Apply</button>    
            </label>
			</div>

            <div id="gateway_row" class="form-group autocomplete" style="width: 100%; display: block; margin-left: auto; margin-bottom:10px; margin-right: 0;">
                <label>
                <input type="checkbox" name="list" value="" class="form-control" style="height: 16px; width: 16px; margin-top: 3px; position: absolute;" />
                <span style="margin-left: 25px;">Pay via Gateway</span>
                </label>
                
			</div>

				



            <hr style="margin-top: 5px;  margin-bottom: 10px;"/>
				<div class="form-group autocomplete" style="margin-bottom: 0px; width: 100%; display: block; margin-left: auto; margin-right: 0;">
						<label>
							<strong>Final Paid Amount</strong>
						</label>
						<label class="pull-right">
							<span id="paidamt">
                               100
                            </span> 
						</label>
						
				</div>

				<hr style="margin-top: 5px;"/>
				<div class="form-group autocomplete text-center">
				<a href="javascript:void(0)" class="btn btn-primary button-primary-color paynowfinal" data-bid=""> Pay Now</a>
                
            </div>


			</div>
		</div>
	</div>
</div>



    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        function submitFormVouch() {
            var vouch_code = $("#vouch_code").val();
            var bid_id = $("#bid_id").val();
// if (bid_id != '' && vouch_code != '') {
            $.ajax({
                url: "{{ url('/') }}" + '/add-new-vouch-code',
                type: "post",
                async: false,
                data: {
                    vouch_code: vouch_code,
                    bid_id: bid_id,
                },
                headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
                success: function (data) {
                    if (data.status) {
                        $("#add-vouch-code").modal('hide');
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        swal(data.message);
                        setTimeout(function () {
                            location.href = "{{ url('/bid') }}";
                        }, 1000);
                    } else {
                        $("#add-vouch-code").modal('toggle');
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        swal(data.message);
                    }
                },
                error: function (data) {
                },
            })
// } else {
//     $("#add-vouch-code").modal('toggle');
//     $('body').removeClass('modal-open');
//     $('.modal-backdrop').remove();
//     swal("Please enter valid Vouch code");
// }


        }
    </script>
    <script src="{{ asset('js/jquery1.min.js') }}"></script>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/typed.min.js') }}"></script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script>


        $(document).ready(function () {
            $('#table_id').DataTable({
                "fnDrawCallback": function () {
// $('.my_switch').bootstrapToggle();
                    $('.my_switch').bootstrapToggle({})
                }
            });
        });
    </script>






<script>
    $(document).ready(function(){
        $("#voucher_td :input").prop("disabled", true);
    });


$('#payment_proof_form').on('submit', function(event){

    event.preventDefault();
    $.ajax({
        url: "{{ route('paynow-proof') }}",            
        method:'post',
        data:new FormData(this),
        dataType:'json',
        contentType: false,
        processData: false,
        success: function(result)
        {
            if(result.status){
                console.log(result.status);
                $("#paynow_modal").modal('show');
                $("#payment_proof").modal('hide');
            }
            else{
                console.log(result.status);
                $("#error_msg").html('unsupported file, please select pdf,doc,jpg,png')
            }
        },
        error: function(data)
        {
            //console.log(data);
        }
    });
});


    $(".continue").click(function(){

        $("#payment_proof").modal('hide');
        $("#paynow_modal").modal('show');
           
           var sponsor_budget = $(this).attr('data-sponsor');
           var per = $(this).attr('data-per');
           if(per>0){ var fper = per;} else{var fper = '10%';}
           var rspid = $(this).attr('data-id');
           $('.paynowfinal').attr('data-bid',rspid);
           $("#put_per").html(fper);
           $("#put_sponsor_budget").html(sponsor_budget);
    });




    //add by ram for paynow button 07 jan 2024------------------------        
    $("body").on("click", ".paynow_modal", function() {
         
            $("#proof_bid").val($(this).attr('data-id'));

            $.ajax({
                url: "{{ route('paynow-proof-get') }}",  
                method:'post',
                data:{'id': $(this).attr('data-id')},
                success: function(result)
                {
                    console.log(result);
                    url = 'uploads/'+result;
                    $("#proof_attachment").html('<a href='+url+' target="_blank">Check Payment Proof<a><br/>');
                    $(".continue").show();
                   
                } 
            });



           $("#payment_proof").modal('show');
           
            var sponsor_budget = $(this).attr('data-sponsor');
            var per = $(this).attr('data-per');
            if(per>0){ var fper = per;} else{var fper = '10%';}
            var rspid = $(this).attr('data-id');
            $('.paynowfinal').attr('data-bid',rspid);
            $("#put_per").html(fper);
            $("#put_sponsor_budget").html(sponsor_budget);

        }); 
        
        $(".final").on("keyup change", function(e) {
            var amt = $(this).val();
            $("#paidamt").html(amt);
        });   



        $(document).on('click', '.paynowfinal', function (e) {

        var fields = $("input[name='list']").serializeArray(); 
        if (fields.length === 0) 
        { 
            alert('Select any one way to pay'); 
            return false;
        } 

        var bidId = $(this).data('bid');
        var amt = $("#paidamt").html();
        var vid = $(this).data('bid');
        var voucher_code = $("#voucher_code").val();
        var CSRF_TOKEN = $('meta[name="_token"]').attr('content');
        if($(".click_wallet").prop("checked"))
        {
            var wallet = $("#wallet_use").val();
        }
        else{
            var wallet = 0;
        }

        

        $.ajax({
                url: "{{ route('paynow-oportunity') }}",
                type: 'POST',
                data: {_token: CSRF_TOKEN, bidId: bidId, wallet:wallet, amt: amt, voucher_code: voucher_code},
                headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
                success: function (data) {
                console.log(data);
                if(data==1)
                {
                    alert("Payment has been done!");
                    location.reload();
                }
                
                
                },
                error: function () {
                alert("something went wrong!");
                }
            });

        });



        $(".click_wallet").click(function(){
            

            check = $(".click_wallet").prop("checked");
            if(check) 
            {
              
                if({{Auth::user()->wallet_balance}} > 100)
                {
                    var chk = parseInt($("#paidamt").html());
                    var pamt = {{Auth::user()->wallet_balance}}-chk;
                    $("#wallet_balance").html(pamt);
                    $("#paidamt").html(0);
                    $("#wallet_use").val(pamt);
                    
                    var chkagain = parseInt($("#paidamt").html());
                    if(chkagain==0)
                    {
                        $("#voucher_row :input").prop("disabled", true);
                        $("#gateway_row :input").prop("disabled", true);
                    }
                    
                    
                }
                else{
                    var chk = parseInt($("#paidamt").html());
                    var pamt = chk-{{Auth::user()->wallet_balance}};
                    $("#wallet_balance").html(0);
                    $("#paidamt").html(pamt);
                    $("#wallet_use").val({{Auth::user()->wallet_balance}});
        
                
                }
            }
            else
            {
                var chk = parseInt($("#paidamt").html());
                if({{Auth::user()->wallet_balance}} > 100)
                {
                    $("#paidamt").html(100);
                }
                else{
                    $("#paidamt").html(chk+{{Auth::user()->wallet_balance}});
                }
        
                $("#wallet_balance").html({{Auth::user()->wallet_balance}});
                $("#voucher_row :input").prop("disabled", false);
                $("#gateway_row :input").prop("disabled", false);
                $("#wallet_use").val(0);
            }
                
        });



        $(".click_voucher").click(function(){

                check = $(".click_voucher").prop("checked");
                if(check) {
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
                                        url: "{{ route('check-vouch-code') }}",
                                        type: 'POST',
                                        data: {code: code},
                                        headers: {
                                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                        },
                                        success: function (data) {
                                            if(data > 0){
                                                $("#vouch_amount").val(data);
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
                                                if(pamt==0)
                                                {
                                                    $("#wallet_row :input").prop("disabled", true);
                                                    $("#gateway_row :input").prop("disabled", true);
                                                }
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
                    $("#voucher_td :input").prop("disabled", true);
                    $(".voucher_textbox").val('');
                    if ($(".click_wallet").is(':checked')) 
                    {
                        var plusvalue = chk+vamt;
                        var finalvalue = plusvalue-{{Auth::user()->wallet_balance}}
                        $("#paidamt").html(finalvalue);
                    }
                    else{
                        $("#paidamt").html(chk+vamt);
                    }
                    
                    $("#wallet_row :input").prop("disabled", false);
                    $("#gateway_row :input").prop("disabled", false);
                    var vamt = parseInt($("#vouch_amount").val(0));
                }
        });

        //add by ram for paynow button 07 jan 2024----------------------

</script>
@endsection
