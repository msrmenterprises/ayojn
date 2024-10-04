<?php $__env->startSection('content'); ?>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <?php
    $f = Request::get('f');
    $cn = Request::get('c');
    $b = Request::get('b');
    $i = Request::get('i');

    use App\Country;use App\Industry;use App\SponsorrSpecify;use App\SponsorrSpecifyList;
    $countries = Country::all();
    $industries = Industry::all();
    $sponsorrlist = SponsorrSpecifyList::where('sponsorr_type', Auth::user()->sponsor_for)->get();
    $userwisesponsor = SponsorrSpecify::where('user_id', Auth::user()->id)->get();
    $userwisesponsorarray = [];
    if (count($userwisesponsor) > 0) {
        foreach ($userwisesponsor as $usersponsorr) {
            $userwisesponsorarray[] = $usersponsorr->specify_name;
        }
    }?>
    <!-- banner section start -->


    <br><br><br><br>
    <section id="feed" class="speakers">
        <div class="container" style="padding-top: 15px;">
            <div class="row"><h3 style="text-align: center;">Vouch List For <?php echo e($opportunityData->hashtag); ?></h3></div>
            <div class="row">
                <?php if(session('success')): ?>
                    <div class="alert alert-success">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>
                <?php if(session('error')): ?>
                    <div class="alert alert-danger">
                        <?php echo e(session('error')); ?>

                    </div>
                <?php endif; ?>
            </div>
            <div class="row">
                <?php if($opportunityData->is_paid == 1): ?>
                    <a href="<?php echo e(url('export-vouch/') .'/'.$opportunityData->id); ?>"
                       class="btn btn-primary float-left">Export Vouches</a>
                <?php else: ?>
                    <a href="javascript:void(0)"
                       class="btn btn-primary float-left" onclick="payment()">Export Vouches</a>
                <?php endif; ?>

            </div>

            <br>
            <div class="row">
                <table id="table_id" class="display">
                    <thead>
                    <tr>
                        <th>Vouch ID</th>
                        <th>Budget</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(!empty($vouchLists->first())): ?>
                        <?php $__currentLoopData = $vouchLists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vouchList): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($vouchList->vouch_identity == $identity || $vouchList->vouch_identity == "All"): ?>
                                <tr>
                                    <td>#<?php echo e($vouchList->id); ?></td>
                                    <td><?php echo e($vouchList->vouch_value); ?></td>
                                    <td><?php if(!empty($vouchList->VouchUser) && $vouchList->VouchUser->status == 1): ?>

                                            <a href="<?php echo e(url('update-vouch/')."/".$vouchList->VouchUser->id); ?>"
                                               class="btn btn-primary">Open
                                                for Negotiation </a>
                                        <?php else: ?>
                                            <?php if($opportunityData->is_paid == 1): ?>
                                                <?php if(!empty($vouchList->userDetail)): ?>
                                                    <?php
                                                    $email = '';
                                                    if ($vouchList->vouch_contacted == 'Mobile') {
                                                        $email = $email . $vouchList->userDetail->phone_no . ", ";
                                                    } else if ($vouchList->vouch_contacted == 'Both') {
                                                        $email = $email . $vouchList->userDetail->email . "-" . $vouchList->userDetail->phone_no . ", ";
                                                    } else {
                                                        $email = $email . $vouchList->userDetail->email . ", ";
                                                    }
                                                    ?>
                                                    <a href="javascript:void(0)" style="font-size: 25px"
                                                       onclick="displayEmail('<?php echo e($email); ?>')"><i
                                                            class="fa fa-envelope"></i></a>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <a href="javascript:void(0)" style="font-size: 25px"
                                                   onclick="payment()"><i
                                                        class="fa fa-envelope"></i></a>
                                            <?php endif; ?>

                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>

    </section>

    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <?php if(session()->has('success_messagesss')): ?>
        <script>
            swal("This vouch has been closed");
        </script>
    <?php endif; ?>
    <script>
        function payment() {
            url = "<?php echo e(url('receive-payment/')."/".$opportunityData->id); ?>";
            const el = document.createElement('div');
            el.innerHTML = "In order to access the contact details of clients for this Vouchlist, please pay the premium fees of USD 100. If you're unaware of the premium fees then please refer the FAQs. " +
                "<a href='" + url + "' class='btn btn-primary'>Pay Now</a>";
            swal({
                title: "",
                content: el,
            });
        }

        function displayEmail(email) {
            const el = document.createElement('div')
            //el.innerHTML = "Brilliant ! One of the clients reachable at " + email + " vouched you for this opportunity.";
            el.innerHTML = "Client is reachable at " + email;
            swal({
                title: "",
                content: el,
            });
        }
    </script>
    <script src="<?php echo e(asset('js/jquery1.min.js')); ?>"></script>

    <script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/typed.min.js')); ?>"></script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script>

        $(document).ready(function () {

            $('#table_id').DataTable({

                "oLanguage": {
                    "sEmptyTable": "It seems like the vouch is Not for you, perhaps a mismatch of Identity/ Location as per the client specification."
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>