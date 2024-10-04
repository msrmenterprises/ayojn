<?php $__env->startSection('content'); ?>
    <style>
        .error {
            color: red;
        }
    </style>
    <?php
    use App\Industry;
    $industries = Industry::all();
    ?>
    <!-- banner section start -->
    <section id="feed" class="speakers">
        <div class="container" style="text-align: center;padding-top: 15px;">

            <div class="row"><br/>
                <h3 style="margin-top:100px">Create Offer</h3>
            </div>
            <!--<div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    Let’s create offer for offer and receiver user
                </div>
            </div>-->

            <br>
            <form name="add-offer" method="post" id="add-offer" action="<?php echo e(url('partner/store-offer')); ?>">
                <div id="add-opporutnity-form">
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <?php if(session()->has('success')): ?>
                                <div class="alert alert-success">
                                    <?php echo e(session()->get('success')); ?>

                                </div>
                            <?php endif; ?>
                            <?php if(!empty($errors->first())): ?>
                                <div class="alert alert-danger">
                                    <?php echo e($errors->first()); ?>


                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <select class="form-group form-control opportunity_country" name="offer_for"
                                    id="offer_for">
                                <option value="">Offer For</option>
                                <option value="Clients">Clients</option>
                                <option value="Agencies">Agencies</option>
                                <option value="Networks">Networks</option>
                                <option value="Freelancers">Freelancers</option>
                                <option value="Communities">Communities</option>
                                <option value="Both">Everyone
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6" style="padding-bottom: 15px">
                            <input type="text" class="form-control" name="offer_by" id="offer_by"
                                   value="<?php echo e(Auth::user()->company_name); ?>"
                                   readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <select class="form-group form-control opportunity_country" name="partner_identity"
                                    id="partner_identity" required>
                                <option value="">Offer Type</option>
                                <option value="Tech">Tech</option>
                                <option value="Non-Tech">Non-Tech</option>

                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <select class="form-group form-control opportunity_country" name="function"
                                    id="function" required>
                                <option value="">Suited For</option>
                                <?php $__currentLoopData = $industries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $in): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>{
                                <option value="<?php echo e($in->id); ?>"><?php echo e($in->name); ?></option>
                                }
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <!-- <option value="Sales">Sales</option>
                                <option value="Marketing">Marketing</option>
                                <option value="Finance">Finance</option>
                                <option value="Legal">Legal</option>
                                <option value="Administration">Administration</option>
                                <option value="HR">HR</option>
                                <option value="Operations">Operations</option>
                                <option value="Others">Others</option> -->
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6" style="padding-bottom: 15px">
                            <input type="text" class="form-control" name="title" id="title"
                                   placeholder="Product/Service Headline">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6" style="padding-bottom: 15px">
                            <input type="text" class="form-control" name="discount" id="discount"
                                   placeholder="Discount (%) if any / Voucher Code">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6" style="padding-bottom: 15px">
                            <input type="text" class="form-control" name="deal_amount" id="deal_amount"
                                   placeholder="Deal Amount">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6" style="padding-bottom: 15px">
                            <input type="text" class="form-control" name="incentive" id="incentive"
                                   placeholder="Sponsay's Incentive % if any(Only for our Reference)">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <select class="form-group form-control available_in" name="available_in"
                                    id="available_in" required>
                                <option value="">Available in</option>
                                <?php if(!empty($countries)): ?>
                                    <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($c->country_code); ?>"><?php echo e($c->country_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <select class="form-group form-control available_in" name="currency"
                                    id="currency" required>
                                <option value="">Currency</option>
                                <?php if(!empty($Currency)): ?>
                                    <?php $__currentLoopData = $Currency; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($cu->name); ?>"><?php echo e($cu->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6" style="padding-bottom: 15px">
                            <input type="text" class="form-control" name="weblink" id="weblink"
                                   placeholder="Weblink for the offer">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6" style="padding-bottom: 15px">
                            <input type="text" class="form-control" name="notification_email" id="notification_email"
                                   placeholder="Notification Email" required>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">Submit</button> &nbsp;
                    </div>
                </div>

            </form>
            <br>
        </div>
    </section>

    <script src="<?php echo e(asset('js/jquery1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/typed.min.js')); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
    <script>
        $.validator.addMethod("wordCount", function (value, element, wordCount) {

            return value.split(' ').length <= wordCount;

        }, 'Exceeded word count');
        $("#add-offer").validate({
            rules: {
                offer_for: 'required',
                partner_identity: 'required',
                function: 'required',
                title: {
                    required: true,
                    wordCount: 4
                },
                available_in: 'required',
                currency: 'required',
                discount: {
                    required: true,
                    number: true,
                    min: 0,
                    max: 100
                }, deal_amount: {
                    required: true,
                    number: true,
                    min: 0
                }, incentive: {
                    required: true,
                    number: true,
                    min: 0,
                    max: 100
                }
            }, messages: {
                offer_for: 'Please select offer For ',
                partner_identity: 'Please select identity',
                function: 'Please select function',
                title: {
                    required: "Please enter title",
                    wordCount: 'Please shorten to 4 words or less'
                },
                available_in: 'Please select country',
                currency: 'Please select currency',
                discount: {
                    required: 'Please enter discount'
                }, deal_amount: {
                    required: 'Please enter deal amount',
                    number: 'Please enter number'
                }, incentive: {
                    required: 'Please enter incentive',
                    number: 'Please enter number'
                }
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>