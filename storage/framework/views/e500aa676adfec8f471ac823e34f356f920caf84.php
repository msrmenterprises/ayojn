<?php $__env->startSection('content'); ?>
    <?php
    $f = Request::get('f');
    $cn = Request::get('c');
    $b = Request::get('b');
    $i = Request::get('i');

    ?>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <?php
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
        <div class="container">
            <div class="row">
                <?php if($unpaid > 0): ?>
                    <a href="javascript:void(0)" onclick="unpaidOpportunity()" class="btn btn-primary float-left"
                    >Create a New Opportunity </a>

                <?php else: ?>
                    <a href="javascript:void(0)" data-toggle="modal" class="btn btn-primary float-left"
                       data-target="#add-bid">Create a New Opportunity </a>
                <?php endif; ?>
                <?php if($unpaid > 0): ?>
                    <a href="<?php echo e(url('unpaid-bid')); ?>" class="btn btn-primary float-left"
                       >My Unpaid Opportunity</a>
                <?php endif; ?>
            </div>
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
            <br>
            <div class="row">
                <form name="search">
                    <div class="col-md-3">
                        <select class="form-control" name="f">
                            <option value="">Outreach Via</option>
                            <option value="Event" <?php if ($f == 'Event') {
                                echo "Selected";
                            }?>>Event
                            </option>
                            <option value="Campaign" <?php if ($f == 'Campaign') {
                                echo "Selected";
                            }?>>Campaign
                            </option>
                            <option value="Content" <?php if ($f == 'Content') {
                                echo "Selected";
                            }?>>Content
                            </option>
                            <option value="Sports Team" <?php if ($f == 'Sports Team') {
                                echo "Selected";
                            }?>>Sports Team
                            </option>
                            <option value="Venue" <?php if ($f == 'Venue') {
                                echo "Selected";
                            }?>>Venue
                            </option>
                            <option value="Not for Profit" <?php if ($f == 'Not for Profit') {
                                echo "Selected";
                            }?>>Not for Profit
                            </option>
                            <option value="Performing Arts" <?php if ($f == 'Performing Arts') {
                                echo "Selected";
                            }?>>Performing Arts
                            </option>
                            <option value="Think Tank" <?php if ($f == 'Think Tank') {
                                echo "Selected";
                            }?>>Think Tank
                            </option>
                            <option value="Knowledge Pool" <?php if ($f == 'Knowledge Pool') {
                                echo "Selected";
                            }?>>Knowledge Pool
                            </option>
                            <option value="Online Events" <?php if ($f == 'Online Events') {
                                echo "Selected";
                            }?>>Online Activities
                            </option>
                            <option value="Other" <?php if ($f == 'Other') {
                                echo "Selected";
                            }?>>Other
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-control" name="c" id="c">
                            <option value="">Select Country</option>
                            <?php if(!empty($countries)): ?>
                                <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?= $c->country_code?>" <?php if ($cn == $c->country_code) {
                                        echo "Selected";
                                    }?>><?= $c->country_name?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-control" name="b" id="b">
                            <option value="">Select Budget</option>
                            <option value="Less than 2000" <?php if ($b == 'Less than 2000') {
                                echo "Selected";
                            }?>>Less than $2000
                            </option>
                            <option value="Between 2000-5000" <?php if ($b == 'Between 2000-5000') {
                                echo "Selected";
                            }?>>Between $2000-$5000
                            </option>
                            <option value="Between 5000-20000" <?php if ($b == 'Between 5000-20000') {
                                echo "Selected";
                            }?>>Between $5000-$20000
                            </option>
                            <option
                                value="Between 20000-50000" <?php if ($b == 'Between 20000-50000') {
                                echo "Selected";
                            }?>?
                            'selected':'' }}>
                            Between $20000-$50000
                            </option>
                            <option value="Above 50000" <?php if ($b == 'Above 50000') {
                                echo "Selected";
                            }?>>Above $50000
                            </option>

                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" name="i" id="i">
                            <option value="">Select your Industry</option>
                            <?php $__currentLoopData = $industries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $in): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>{
                            <option value="<?php echo e($in->id); ?>" <?php if ($i == $in->id) {
                                echo "Selected";
                            }?>><?php echo e($in->name); ?></option>
                            }
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary"
                        >Search
                        </button> &nbsp;<a href="<?php echo e(url('bid')); ?>" title="refresh" class="btn btn-primary"
                        ><i class="fa fa-refresh" aria-hidden="true"></i></a></div>
                </form>
            </div>
            <br>
            <div class="row">
                <table id="table_id" class="display">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Outreach Via</th>
                        <th>Specific <br>Opportunity</th>
                        <th>Objective</th>
                        <th>Geo Focus</th>
                        <!--<th>Contact By</th> -->
                        <th>Available For</th>
                        <th>Expected Budget <br>(USD $)</th>
                        <th>Industry</th>
                        <th>Status</th>
                        <th>Bids</th>
                        <th>Bid Book/Pay Status</th>
                        <th>Created On</th>
                        <!--<th>Action</th> -->
                        <th>Share</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(!empty($bids->first())): ?>
                        <?php $__currentLoopData = $bids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                            $specification = '';
                            $specificationArray = [];
                            ?>
                            <?php if(!empty($bid->bidSpecify->first())): ?>
                                <?php $__currentLoopData = $bid->bidSpecify; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bidS): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $specificationArray[] = $bidS->specifyName->specify_name;
                                        $specification = implode(', ',$specificationArray);
                                    ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>

                            <tr>
                                <td><?php echo e($bid->id); ?></td>
                                <?php if($bid->sponsor_for=='Online Events'): ?>
                                    <td> Online Activities</td>
                                <?php else: ?>
                                    <td><?php echo e($bid->sponsor_for); ?></td>
                                <?php endif; ?>
                                <td><?php echo e($specification); ?></td>
                                <td><?php echo e($bid->likeSponsorr); ?></td>
                                <td><?php echo e((!empty($bid->country_name)) ? $bid->country_name->country_name : "-"); ?>

                                    / <?php echo e((!empty($bid->city) && !empty($bid->city_name) && !empty($bid->city_name->name)) ? $bid->city_name['name'] : "-"); ?></td>
                            <!--<td><?php echo e($bid->contacted_by); ?></td> -->
                                <td><?php echo e($bid->identity); ?></td>
                                <td><?php echo e($bid->sponsor_budget); ?></td>
                                <td><?php echo e((!empty($bid->industry)) ? $bid->industry->name : '-'); ?></td>
                                <td>
                                    <input type="checkbox" onchange='changebid(<?php echo e($bid->id); ?>,"<?php echo e($bid->status); ?>")'
                                           name="toggle-event-bid" data-toggle="toggle" data-on="On"
                                           data-off="Off" <?php echo e(($bid->status == 'On')?'checked':''); ?>>
                                </td>
                                <td><a href="<?php echo e(url('bid-response/') ."/".base64_encode($bid->id)); ?>"> <span
                                            class="badge badge-light"><?php echo e($bid->bidResponseWithSpam->count()); ?></span> </a></td>
                                <td><?php


                                $result = null;
                                foreach ($bid->bidResponseWithSpam as $object) {
                                    if ($object->is_accepted > 2) {
                                        $result = $object->is_accepted;
                                        break;
                                    }
                                }
                                unset($object);
                                $obj = $result;

                                if ($obj == 0)
                                    echo '<span class="label label-warning ">Not Seen Yet</span>';
                                elseif ($obj == 1)
                                    echo '<span class="label label-primary" > Read for Receiver </span >';
                                elseif ($obj == 3)
                                    echo '<span class="label label-success" > Booked </span >';
                                elseif ($obj == 4)
                                    echo '<span class="label label-primary" > Paid </span >';               
                                else
                                    echo '<span class="label label-success" > Open for Negotiation </span >';


                                ?></td>            
                                <td><?php echo e(Date("Y-m-d",strtotime($bid->created_at))); ?></td>
                            <!--<td><a href="javascript:void(0)" onclick="editBid(<?php echo e($bid->id); ?>)"
									   class="btn btn-primary"><i class="fa fa-pencil"></i></a></td> -->
                                <td><span id="opportunity_<?php echo e($bid->id); ?>" class="share-course-filed"
                                          style="display: none"> <?php echo e(url('share')."/" . $bid->share_id); ?></span> <a
                                        href="javascript:void(0)" class="btn btn-primary read-more-btn  share-opp-btn"
                                        onclick="copyToClipboard('#opportunity_<?php echo e($bid->id); ?>')">Copy Web link</a></td>

                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
        <div class="modal" id="add-bid" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                        <h4 class="modal-title" id="myModalLabel">Create Opportunity</h4>
                        <h5 class="modal-title" id="myModalLabel">Creating Opportunity is an equivalent of RFP (Request for Proposal) and will activate our search for the best fitting proposals for you.
                        </h5>
                    </div>
                    <div class="modal-body">
                        <form class="addBidForm" id="addBidForm" method="post" onsubmit="return false"
                              name="addBidForm">
                            <div class="form-group">
                                <!-- <h3>
                                    Let's gather the relevant details so that we can match your information requirements
                                </h3> -->
                            </div>
                            <div class="form-group autocomplete">
                                <label>
                                    <strong>Status Of Bid</strong>
                                </label>

                                
                                <select class="form-control" name="status" id="status">
                                    <option value="On">On</option>
                                    <option value="Off">Off</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>
                                    <strong>You wish to create Outreach via?</strong>
                                </label>
                            </div>

                            <div class="form-group">
                                <select class="form-control" name="sponsorr_type_bid" id="sponsorr_type_bid"
                                        onchange="getSpecifyBid()">
                                    <option value="">Select Any</option>
                                    <option value="Event">Event</option>
                                    <option value="Campaign">Campaign</option>
                                    <option value="Content">Content</option>
                                    <option value="Sports Team">Sports Team</option>
                                    <option value="Venue">Venue</option>
                                    <option value="Not for Profit">Not for Profit</option>
                                    <option value="Performing Arts">Performing Arts</option>
                                    <option value="Think Tank">Think Tank</option>
                                    <option value="Knowledge Pool">Knowledge Pool</option>
                                    <option value="Online Events">Online Activities</option>
                                    <option value="Research">Research</option>
                                    <option value="Other">Other</option>
                                </select>

                            </div>
                            <div id="sponsorOtherSpecifys" style="display: show !important;">
                                <div class="form-group autocomplete">
                                    <label>
                                        <strong>Please Specify</strong>
                                    </label>

                                    
                                    <select class="form-control" name="specify_bid" id="specify_bid" multiple>
                                        <?php if(count($sponsorrlist) > 0): ?>
                                            <?php $__currentLoopData = $sponsorrlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sponsor_list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option
                                                    value="<?php echo e($sponsor_list->id); ?>"><?php echo e($sponsor_list->specify_name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>
                                    <strong>Objective you’re trying to achieve?</strong>
                                </label>
                            </div>
                            <div class="form-group ">
                                <select class="form-control" name="likeSponsorr[]" id="likeSponsorr" multiple>
                                    <option value="Message">Message</option>
                                    <option value="Leads">Leads</option>
                                    <option value="Branding">Branding</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>
                                    <strong>Geographically! Where exactly do you wish to focus?</strong>
                                </label>
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="country_bid" id="country_bid" onchange="getCity(3)">
                                    <option value="">Select Country</option>
                                    <?php if(!empty($countries)): ?>
                                        <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?= $c->country_code?>"><?= $c->country_name?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>
                                    <strong>Any Specific City/Across the Country</strong>
                                </label>
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="city_bid" id="city_bid">
                                    <option value="">Select City</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>
                                    <strong>Do you wish this opportunity to be available only for local bidders from the selected city ? </strong>
                                </label>
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="city_bidder_from" id="city_bidder_from">
                                    <option value="">Select Type</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>
                                    <strong>How do you wish to be contacted by the bidders?</strong>
                                </label>
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="contacted_by" id="contacted_by">
                                    <!--<option value="">Select Contact type</option> -->
                                    <option value="Email">Email</option>
                                    <option value="Mobile">Mobile</option>
                                    <option value="Both">Both</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>
                                    <strong>Opportunity available for </strong>
                                </label>
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="identity_bid" id="identity_bid">
                                    <!--<option value="">Select Contact type</option> -->
                                    <option value="Freelancers">Freelancers</option>
                                    <option value="Agencies">Agencies</option>
                                    <option value="Networks">Networks</option>
                                    <option value="Everyone">Everyone</option>
                                    <option value="Communities">Communities</option>
                                </select>
                            </div>


                            <div class="form-group">
                                <label>
                                    <strong>Approximate Budget (USD)</strong>
                                </label>
                            </div>

                            <div class="form-group">
                                <select class="form-control" name="budget_bid" id="budget_bid">
                                    <option value="">Select Any</option>
                                    <option value="200-500">200-500</option>
                                    <option value="500-2000">500-2000</option>
                                    <option value="2000-5000">2000-5000</option>
                                    <option value="5000-10000">5000-10000</option>
                                    <option value="10000-20000">10000-20000</option>
                                    <option value="20000-30000">20000-30000</option>
                                    <option value="30000-50000">30000-50000</option>
                                    <option value="50000-100000">50000-100000</option>
                                    <option value="Above 100000">Above 100000</option>
                                    <option value="In kind">In kind</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <label>
                                    <strong>Select Industry </strong>
                                </label>
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="industry_bid" id="industry_bid">
                                    <option value="">Select your Industry</option>
                                    <?php $__currentLoopData = $industries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $in): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>{
                                    <option value="<?php echo e($in->id); ?>"><?php echo e($in->name); ?></option>
                                    }
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                            </div>
                            
                            <button type="submit" id="addBid" onclick="addBid()" class="btn btn-default">Submit</button>
                        </form>

                    </div>

                </div>
            </div>
        </div>
        <div class="modal" id="update-bid" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                        <h4 class="modal-title" id="myModalLabel">Update Bid</h4>
                    </div>
                    <div class="modal-body">
                        <form class="updateBidForm" id="updateBidForm" method="post" onsubmit="return false"
                              name="updateBidForm">
                            <input type="hidden" id="bidId" name="bidId" value="">
                            <div class="form-group">
                                <!-- <h3>
                                    Let's gather the relevant details so that we can match your information requirements
                                </h3> -->
                            </div>
                            <div class="form-group autocomplete">
                                <label>
                                    <strong>Status Of Bid</strong>
                                </label>

                                
                                <select class="form-control" name="status_edit" id="status_edit">
                                    <option value="On">On</option>
                                    <option value="Off">Off</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>
                                    <strong>What do you want to get Sponsored</strong>
                                </label>
                            </div>

                            <div class="form-group">
                                <select class="form-control" name="sponsorr_type_bid_edit" id="sponsorr_type_bid_edit"
                                        onchange="getSpecifyBidEdit()">
                                    <option value="">Select Any</option>
                                    <option value="Event">Event</option>
                                    <option value="Campaign">Campaign</option>
                                    <option value="Content">Content</option>
                                    <option value="Sports Team">Sports Team</option>
                                    <option value="Venue">Venue</option>
                                    <option value="Not for Profit">Not for Profit</option>
                                    <option value="Performing Arts">Performing Arts</option>
                                    <option value="Think Tank">Think Tank</option>
                                    <option value="Knowledge Pool">Knowledge Pool</option>
                                    <option value="Online Events">Online Events</option>
                                    <option value="Other">Other</option>
                                </select>

                            </div>
                            <div id="sponsorOtherSpecifys" style="display: show !important;">
                                <div class="form-group autocomplete">
                                    <label>
                                        <strong>Please Specify</strong>
                                    </label>

                                    
                                    <select class="form-control" name="specify_bid_edit" id="specify_bid_edit" multiple>
                                        <?php if(count($sponsorrlist) > 0): ?>
                                            <?php $__currentLoopData = $sponsorrlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sponsor_list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option
                                                    value="<?php echo e($sponsor_list->id); ?>"><?php echo e($sponsor_list->specify_name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>
                                    <strong>Where would you like this to be sponsored</strong>
                                </label>
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="country_bid_edit" id="country_bid_edit">
                                    <option value="">Select Country</option>
                                    <?php if(!empty($countries)): ?>
                                        <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?= $c->country_code?>"><?= $c->country_name?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>
                                    <strong>Bidders Only from city</strong>
                                </label>
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="city_bid_edit" id="city_bid_edit">
                                    <option value="Anywhere">Anywhere</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>
                                    <strong>How you wish to be contacted by the bidders?</strong>
                                </label>
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="contacted_by_edit" id="contacted_by_edit">
                                    <option value="">Select Contact type</option>
                                    <option value="Email">Email</option>
                                    <option value="Mobile">Mobile</option>
                                    <option value="Both">Both</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>
                                    <strong>Identify Yourself</strong>
                                </label>
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="identity_bid_edit" id="identity_bid_edit">
                                    <option value="">Select Contact type</option>
                                    <option value="Freelancers">Freelancers</option>
                                    <option value="Agencies">Agencies</option>
                                    <option value="Networks">Networks</option>
                                    <option value="Everyone">Everyone</option>
                                    <option value="Communities">Communities</option>
                                </select>
                            </div>


                            <div class="form-group">
                                <label>
                                    <strong>What's your ideal deal size </strong>
                                </label>
                            </div>

                            <div class="form-group">
                                <select class="form-control" name="budget_bid_edit" id="budget_bid_edit">
                                    <option value="">Select Any</option>
                                    <option value="Less than 2000">Less than $2000</option>
                                    <option value="Between 2000-5000">Between $2000-$5000</option>
                                    <option value="Between 5000-20000">Between $5000-$20000</option>
                                    <option value="Above 20000">Above $20000</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <label>
                                    <strong>Select Industry </strong>
                                </label>
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="industry_bid_edit" id="industry_bid_edit">
                                    <option value="">Select your Industry</option>
                                    <?php $__currentLoopData = $industries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $in): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>{
                                    <option value="<?php echo e($in->id); ?>"><?php echo e($in->name); ?></option>
                                    }
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                            </div>
                            
                            <button type="submit" id="updateBid" onclick="updateBid()" class="btn btn-default">Submit
                            </button>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>
    <script>
        $(".share-opp-btn").on('click', function (e) {
            toastr.success('Web Link Copied', 'Success');
        });

        function unpaidOpportunity() {
            toastr.error('You have one unpaid opportunity in your account', 'Notice');
        }

        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).text()).select();
            document.execCommand("copy");
            $temp.remove();
            toastr.success('Web Link Copied', 'Success');
        }

        function changebid(id, status) {
            $.ajax({
                type: 'POST',
                url: '<?php echo e(url('change-bid-status')); ?>',
                headers: {"X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>"},
                data: {
                    status: status,
                    id: id
                },
                success: function (response) {
                    //console.log(response.status);
                    var data = response;
                    if (data.status) {
                        toastr.success(response.message, "Success");
                        window.location.reload();
                    } else {
                        toastr.error(response.errors, "Error");
                    }
                    // link to page on clicking the notification
                    //}
                },
                error: function (response) {
                    toastr.error(response.responseJSON.msg, "Error");
                    $(':input[type="submit"]').prop('disabled', false);
                },
            });
        }

        $("#addBid").click(function () {
            var status = $("#status").val();
            var country_bid = $("#country_bid").val();
            var specify_bid = $("#specify_bid").val();
            var sponsorr_type_bid = $("#sponsorr_type_bid").val();
            var industry_bid = $("#industry_bid").val();
            var budget_bid = $("#budget_bid").val();
            var likeSponsorr = $("#likeSponsorr").val();
            var city_bid = $("#city_bid").val();
            var contacted_by = $("#contacted_by").val();
            var identity_bid = $("#identity_bid").val();
            var city_bidder_from = $("#city_bidder_from").val();
            // $('#create_post').prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: '<?php echo e(url('add-bid')); ?>',
                headers: {"X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>"},
                data: {
                    status: status,
                    country_bid: country_bid,
                    specify_bid: specify_bid,
                    sponsorr_type_bid: sponsorr_type_bid,
                    industry_bid: industry_bid,
                    budget_bid: budget_bid,
                    city_bid: city_bid,
                    contacted_by: contacted_by,
                    identity_bid: identity_bid,
                    likeSponsorr: likeSponsorr,
                    city_bidder_from: city_bidder_from
                },
                success: function (response) {
                    //console.log(response.status);
                    var data = response;
                    if (data.status) {
                        toastr.success(response.message, "Success");
                        location.href = "<?php echo e(url('unpaid-bid')); ?>"
                    } else {
                        toastr.error(response.errors, "Error");
                    }


                    // link to page on clicking the notification

                    //}

                },
                error: function (response) {
                    toastr.error(response.responseJSON.msg, "Error");
                    $(':input[type="submit"]').prop('disabled', false);
                },
            });

        });

        function editBid(id) {
            $.ajax({
                type: 'POST',
                url: '<?php echo e(url('edit-bid')); ?>',
                headers: {"X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>"},
                data: {
                    id: id,
                },
                success: function (response) {
                    var data = response;
                    console.log(data.bid);
                    if (data.status) {
                        $('#bidId').val(data.bid.id);
                        $('#status_edit').find('option[value="' + data.bid.status + '"]').attr('selected', 'selected');
                        $('#sponsorr_type_bid_edit').find('option[value="' + data.bid.sponsor_for + '"]').attr('selected', 'selected');
                        $('#country_bid_edit').find('option[value="' + data.bid.sponsor_country + '"]').attr('selected', 'selected');
                        $('#budget_bid_edit').find('option[value="' + data.bid.sponsor_budget + '"]').attr('selected', 'selected');
                        $('#industry_bid_edit').find('option[value="' + data.bid.sponsor_industry + '"]').attr('selected', 'selected');
                        getSpecifyBidEdit();
                        getCity(4);
                        $('#identity_bid_edit').find('option[value="' + data.bid.identity + '"]').attr('selected', 'selected');
                        $('#contacted_by_edit').find('option[value="' + data.bid.contacted_by + '"]').attr('selected', 'selected');
                        setTimeout(function () {
                            $('#city_bid_edit').find('option[value="' + data.bid.city + '"]').attr('selected', 'selected');
                        }, 3500);
                        $.each(data.bid.bid_specify, function (key, value) {
                            console.log(value['specify_name']);
                            $('#specify_bid_edit').find('option[value="' + value['specify_name'] + '"]').attr('selected', 'selected');
                        })
                        $('#update-bid').modal("toggle");
                        //window.location.reload();
                    } else {
                        toastr.error(response.errors, "Error");
                    }
                },
                error: function (response) {
                    toastr.error(response.responseJSON.msg, "Error");
                    $(':input[type="submit"]').prop('disabled', false);
                },
            });
        }

        $("#updateBid").click(function () {
            var bidid = $("#bidId").val();
            var status = $("#status_edit").val();
            var country_bid = $("#country_bid_edit").val();
            var specify_bid = $("#specify_bid_edit").val();
            var sponsorr_type_bid = $("#sponsorr_type_bid_edit").val();
            var industry_bid = $("#industry_bid_edit").val();
            var budget_bid = $("#budget_bid_edit").val();
            var contacted_by = $("#contacted_by_edit").val();
            var identity_bid = $("#identity_bid_edit").val();
            var city_bid = $("#city_bid_edit").val();
            // $('#create_post').prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: '<?php echo e(url('update-bid')); ?>',
                headers: {"X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>"},
                data: {
                    bidid: bidid,
                    status: status,
                    country_bid: country_bid,
                    specify_bid: specify_bid,
                    sponsorr_type_bid: sponsorr_type_bid,
                    industry_bid: industry_bid,
                    contacted_by: contacted_by,
                    identity_bid: identity_bid,
                    city_bid: city_bid,
                    budget_bid: budget_bid
                },
                success: function (response) {
                    //console.log(response.status);
                    var data = response;
                    if (data.status) {
                        toastr.success(response.message, "Success");
                        window.location.reload();
                    } else {
                        toastr.error(response.errors, "Error");
                    }
                },
                error: function (response) {
                    toastr.error(response.responseJSON.msg, "Error");
                    $(':input[type="submit"]').prop('disabled', false);
                },
            });

        });
    </script>
    <script src="<?php echo e(asset('js/jquery1.min.js')); ?>"></script>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/typed.min.js')); ?>"></script>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>