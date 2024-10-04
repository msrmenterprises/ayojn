<style>
    .forgot_button {
        height: 45px;
        width: 135px;
        text-align: center;
        line-height: 45px;
        margin-right: 0;
        border-radius: 40px;
        background: #52616D;
        color: #fff;
    }
</style>
<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <!--   <div class="modal-header">
                   <h4 class="modal-title">Modal Heading</h4>
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>-->

            <!-- Modal body -->
            <div class="modal-body">

                <div class="row">
                    <?php if(!empty($finalArray)): ?>
                        <div class="col-md-12 col-lg-12 align-self-center">
                            <p class="text-muted font-13 mb-1">
                                <i class="mdi mdi-checkbox-blank-circle mr-2 text-success"></i>
                                <?php if($sponsor_type == 1): ?>
                                    Average Sponsorship Offered for Events
                                <?php else: ?>
                                    Average Price of Event Sponsorship
                                <?php endif; ?>

                            </p>
                            <p class="text-muted font-13 mb-1">
                                <span class="float-right"> <?php echo e($finalArray['EventBudgetMessage']); ?> (Based on <?php echo e($eventTotalUsers); ?> inputs )</span>
                            </p>
                            <a href="javascript:void(0)" id="a1" onClick="changeContent(1,2)" data-toggle="collapse"
                               data-target="#demo">View More</a>
                            <a href="javascript:void(0)" id="a2" onClick="changeContent(2,1)" data-toggle="collapse"
                               data-target="#demo">View Less</a>

                            <div id="demo" class="collapse">
                                <button href="javascript:void(0)" class="forgot_button">Conference
                                    (<?php echo e($finalArray['conference']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Work Shop
                                    (<?php echo e($finalArray['music_festival']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Tradeshow
                                    (<?php echo e($finalArray['tradeshow']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Exhibition
                                    (<?php echo e($finalArray['exhibition']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Masterclass
                                    (<?php echo e($finalArray['Masterclass']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Seminar
                                    (<?php echo e($finalArray['Seminar']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Delegation
                                    (<?php echo e($finalArray['Delegation']); ?>)
                                </button>
                                <button href="javascript:void(0)" style="width: 215px" class="forgot_button">Awards &
                                    Competitions (<?php echo e($finalArray['AwardsCompetitions']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button" style="width: 215px">Festivals &
                                    Parties (<?php echo e($finalArray['FestivalsParties']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button" style="width: 160px">Product
                                    Launch (<?php echo e($finalArray['ProductLaunch']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">MeetUp
                                    (<?php echo e($finalArray['MeetUp']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Roadshows
                                    (<?php echo e($finalArray['Roadshows']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Recreational
                                    (<?php echo e($finalArray['Recreational']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Experiences
                                    (<?php echo e($finalArray['Experiences']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button" style="width: 160px;">Not Decided yet
                                    (<?php echo e($finalArray['notDYet1']); ?>)
                                </button>
                            </div>
                            <br>
                            <div class="progress">
                                <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar"
                                     aria-valuenow="<?php echo e($finalArray['EventPer']); ?>" aria-valuemin="0" aria-valuemax="100"
                                     style="width:<?php echo e($finalArray['EventPer']); ?>%">

                                </div>
                            </div>
                            <br>
                            <p class="text-muted font-13 mb-1">
                                <i class="mdi mdi-checkbox-blank-circle mr-2 text-success"></i>
                                <?php if($sponsor_type == 1): ?>
                                    Average Sponsorship Offered for Campaign
                                <?php else: ?>
                                    Average Price of Campaign Sponsorship
                                <?php endif; ?>
                            </p>
                            <p class="text-muted font-13 mb-1">
                                <span class="float-right"> <?php echo e($finalArray['CampaingBudgetMessage']); ?> (Based on <?php echo e($campaignTotalUsers); ?> inputs )</span>
                            </p>
                            <a href="javascript:void(0)" id="a3" onClick="changeContent(3,4)" data-toggle="collapse"
                               data-target="#campaign">View More</a>
                            <a href="javascript:void(0)" id="a4" onClick="changeContent(4,3)" data-toggle="collapse"
                               data-target="#campaign">View Less</a>

                            <div id="campaign" class="collapse">
                                <button href="javascript:void(0)" class="forgot_button">Online
                                    (<?php echo e($finalArray['Online']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Offline
                                    (<?php echo e($finalArray['Offline']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Social Media
                                    (<?php echo e($finalArray['SocialMedia']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Influencer
                                    (<?php echo e($finalArray['Infleucer']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Email
                                    (<?php echo e($finalArray['Email']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Experiential
                                    (<?php echo e($finalArray['Experiential']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Canvassing
                                    (<?php echo e($finalArray['Canvassing']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">PR (<?php echo e($finalArray['PR']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Prospecting
                                    (<?php echo e($finalArray['Prospecting']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Affiliate
                                    (<?php echo e($finalArray['Affiliate']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">GrowthMarketing
                                    (<?php echo e($finalArray['GrowthMarketing']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Programmatic
                                    (<?php echo e($finalArray['Programmatic']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">DOOH (<?php echo e($finalArray['DOOH']); ?>

                                    )
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">OOH (<?php echo e($finalArray['OOH']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Performance
                                    (<?php echo e($finalArray['Performance']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Lobbying
                                    (<?php echo e($finalArray['Lobbying1']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button" style="width: 160px;">Not Decided yet
                                    (<?php echo e($finalArray['notDYet2']); ?>)
                                </button>
                            </div>
                            <br>
                            <div class="progress">
                                <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar"
                                     aria-valuenow="<?php echo e($finalArray['CampaignPer']); ?>" aria-valuemin="0"
                                     aria-valuemax="100" style="width:<?php echo e($finalArray['CampaignPer']); ?>%">

                                </div>
                            </div>
                            <br>
                            <p class="text-muted font-13 mb-1">
                                <i class="mdi mdi-checkbox-blank-circle mr-2 text-success"></i>
                                <?php if($sponsor_type == 1): ?>
                                    Average Sponsorship Offered for Content
                                <?php else: ?>
                                    Average Price of Content Sponsorship
                                <?php endif; ?>
                            </p>
                            <p class="text-muted font-13 mb-1">
                                <span class="float-right"> <?php echo e($finalArray['ContentBudgetMessage']); ?> (Based on <?php echo e($contentTotalUsers); ?> inputs )</span>
                            </p>
                            <a href="javascript:void(0)" id="a5" onClick="changeContent(5,6)" data-toggle="collapse"
                               data-target="#Content">View More</a>
                            <a href="javascript:void(0)" id="a6" onClick="changeContent(6,5)" data-toggle="collapse"
                               data-target="#Content">View Less</a>

                            <div id="Content" class="collapse">
                                <button href="javascript:void(0)" class="forgot_button">Blog (<?php echo e($finalArray['Blog']); ?>

                                    )
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Video
                                    (<?php echo e($finalArray['Video']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Infographics
                                    (<?php echo e($finalArray['Inforgraphics']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Case Studies
                                    (<?php echo e($finalArray['CaseStudies']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Whitepapers
                                    (<?php echo e($finalArray['Whitpapers']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Articles
                                    (<?php echo e($finalArray['Articles']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Interviews
                                    (<?php echo e($finalArray['Interviews']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">
                                    Memes/ GIFs (<?php echo e($finalArray['Memes']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button" style="width: 160px;">Not Decided yet
                                    (<?php echo e($finalArray['notDYet3']); ?>)
                                </button>
                            </div>
                            <br>
                            <div class="progress">
                                <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar"
                                     aria-valuenow="<?php echo e($finalArray['ContentUserPer']); ?>" aria-valuemin="0"
                                     aria-valuemax="100" style="width:<?php echo e($finalArray['ContentUserPer']); ?>%">

                                </div>
                            </div>
                            <p class="text-muted font-13 mb-1">
                                <i class="mdi mdi-checkbox-blank-circle mr-2 text-success"></i>
                                <?php if($sponsor_type == 1): ?>
                                    Average Sponsorship Offered for Sports
                                <?php else: ?>
                                    Average Price of Sports Sponsorship
                                <?php endif; ?>
                            </p>
                            <p class="text-muted font-13 mb-1">
                                <span class="float-right"> <?php echo e($finalArray['SportBudgetMessage']); ?> (Based on <?php echo e($SportsTotalUsers); ?> inputs )</span>
                            </p>
                            <a href="javascript:void(0)" id="a7" onClick="changeContent(7,8)" data-toggle="collapse"
                               data-target="#SportTeam">View More</a>
                            <a href="javascript:void(0)" id="a8" onClick="changeContent(8,7)" data-toggle="collapse"
                               data-target="#SportTeam">View Less</a>

                            <div id="SportTeam" class="collapse">
                                <button href="javascript:void(0)" class="forgot_button">Football
                                    (<?php echo e($finalArray['Football']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Online Sports
                                    (<?php echo e($finalArray['OnlineSports']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Regional
                                    (<?php echo e($finalArray['Regional']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Adventure Sports
                                    (<?php echo e($finalArray['AdventureSports']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Racetrack
                                    (<?php echo e($finalArray['Racetrack']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">International
                                    (<?php echo e($finalArray['International']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Cricket
                                    (<?php echo e($finalArray['Cricket']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Boxing
                                    (<?php echo e($finalArray['Boxing']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Golf (<?php echo e($finalArray['Golf']); ?>

                                    )
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Polo (<?php echo e($finalArray['Polo']); ?>

                                    )
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Skiing
                                    (<?php echo e($finalArray['Skiing']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Power Boat
                                    (<?php echo e($finalArray['PowerBoat']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Base Ball
                                    (<?php echo e($finalArray['BaseBall']); ?>)
                                </button>
                                <button href="javascript:void(0)" style="width: 150px" class="forgot_button">Online
                                    Gaming (<?php echo e($finalArray['OnlineGaming']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">
                                    Basketball(<?php echo e($finalArray['Basketball']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button" style="width: 160px;">Not Decided yet
                                    (<?php echo e($finalArray['notDYet4']); ?>)
                                </button>
                            </div>
                            <div class="progress">
                                <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar"
                                     aria-valuenow="<?php echo e($finalArray['SportTeamUserPer']); ?>" aria-valuemin="0"
                                     aria-valuemax="100" style="width:<?php echo e($finalArray['SportTeamUserPer']); ?>%">

                                </div>
                            </div>

                            
                            <p class="text-muted font-13 mb-1">
                                <i class="mdi mdi-checkbox-blank-circle mr-2 text-success"></i>
                                <?php if($sponsor_type == 1): ?>
                                    Average Sponsorship Offered for Venue
                                <?php else: ?>
                                    Average Price of Venue Sponsorship
                                <?php endif; ?>

                            </p>
                            <p class="text-muted font-13 mb-1">
                                <span class="float-right"> <?php echo e($finalArray['VenueBudgetMessage']); ?> (Based on <?php echo e($VenueTotalUsers); ?> inputs )</span>
                            </p>
                            <a href="javascript:void(0)" id="a11" onClick="changeContent(11,12)" data-toggle="collapse"
                               data-target="#Outdoor">View More</a>
                            <a href="javascript:void(0)" id="a12" onClick="changeContent(12,11)" data-toggle="collapse"
                               data-target="#Outdoor">View Less</a>

                            <div id="Outdoor" class="collapse">
                                <button href="javascript:void(0)" class="forgot_button">Outdoor
                                    (<?php echo e($finalArray['Outdoor']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Indoor
                                    (<?php echo e($finalArray['indoor']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Sports
                                    (<?php echo e($finalArray['Sports']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Shopping
                                    (<?php echo e($finalArray['Shopping']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Entertainment
                                    (<?php echo e($finalArray['Entertainment']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Transport
                                    (<?php echo e($finalArray['Transport']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button" style="width: 160px;">Not Decided yet
                                    (<?php echo e($finalArray['notDYet5']); ?>)
                                </button>
                            </div>
                            <br>
                            <div class="progress">
                                <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar"
                                     aria-valuenow="<?php echo e($finalArray['VenuePer']); ?>" aria-valuemin="0" aria-valuemax="100"
                                     style="width:<?php echo e($finalArray['VenuePer']); ?>%">

                                </div>
                            </div>
                            <br>

                            

                            
                            <p class="text-muted font-13 mb-1">
                                <i class="mdi mdi-checkbox-blank-circle mr-2 text-success"></i>
                                <?php if($sponsor_type == 1): ?>
                                    Average Sponsorship Offered for Not for Profit
                                <?php else: ?>
                                    Average Price of Not for Profit Sponsorship
                                <?php endif; ?>

                            </p>
                            <p class="text-muted font-13 mb-1">
                                <span class="float-right"> <?php echo e($finalArray['ProfitBudgetMessage']); ?> (Based on <?php echo e($ProfitTotalUsers); ?> inputs )</span>
                            </p>
                            <a href="javascript:void(0)" id="a13" onClick="changeContent(13,14)" data-toggle="collapse"
                               data-target="#CSR">View More</a>
                            <a href="javascript:void(0)" id="a14" onClick="changeContent(14,13)" data-toggle="collapse"
                               data-target="#CSR">View Less</a>

                            <div id="CSR" class="collapse">
                                <button href="javascript:void(0)" class="forgot_button">CSR (<?php echo e($finalArray['CSR']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Aid (<?php echo e($finalArray['Aid']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Donation
                                    (<?php echo e($finalArray['Donation']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Campaign
                                    (<?php echo e($finalArray['Campaign']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Lobbying
                                    (<?php echo e($finalArray['Lobbying']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Charity
                                    (<?php echo e($finalArray['Charity']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button" style="width: 160px;">Not Decided yet
                                    (<?php echo e($finalArray['notDYet6']); ?>)
                                </button>
                            </div>
                            <br>
                            <div class="progress">
                                <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar"
                                     aria-valuenow="<?php echo e($finalArray['ProfitPer']); ?>" aria-valuemin="0" aria-valuemax="100"
                                     style="width:<?php echo e($finalArray['ProfitPer']); ?>%">

                                </div>
                            </div>
                            <br>
                            
                            <p class="text-muted font-13 mb-1">
                                <i class="mdi mdi-checkbox-blank-circle mr-2 text-success"></i>
                                <?php if($sponsor_type == 1): ?>
                                    Average Sponsorship Offered for Performing Art
                                <?php else: ?>
                                    Average Price of Performing Art Sponsorship
                                <?php endif; ?>

                            </p>
                            <p class="text-muted font-13 mb-1">
                                <span class="float-right"> <?php echo e($finalArray['PerformBudgetMessage']); ?> (Based on <?php echo e($PerformTotalUsers); ?> inputs )</span>
                            </p>
                            <a href="javascript:void(0)" id="a15" onClick="changeContent(15,16)" data-toggle="collapse"
                               data-target="#Theatre">View More</a>
                            <a href="javascript:void(0)" id="a16" onClick="changeContent(16,15)" data-toggle="collapse"
                               data-target="#Theatre">View Less</a>

                            <div id="Theatre" class="collapse">
                                <button href="javascript:void(0)" class="forgot_button">Theatre
                                    (<?php echo e($finalArray['Theatre']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Dance (<?php echo e($finalArray['Dance']); ?>

                                    )
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Music (<?php echo e($finalArray['Music']); ?>

                                    )
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Comedy
                                    (<?php echo e($finalArray['Comedy']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Story Telling
                                    (<?php echo e($finalArray['StoryTelling']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Magic (<?php echo e($finalArray['Magic']); ?>

                                    )
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Circus
                                    (<?php echo e($finalArray['Circus']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Entertainment
                                    (<?php echo e($finalArray['Entertainment']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Puppetry
                                    (<?php echo e($finalArray['Puppetry']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Poetry
                                    (<?php echo e($finalArray['Poetry']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Visual Arts
                                    (<?php echo e($finalArray['VisualArts']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button" style="width: 160px;">Not Decided yet
                                    (<?php echo e($finalArray['notDYet7']); ?>)
                                </button>
                            </div>
                            <br>
                            <div class="progress">
                                <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar"
                                     aria-valuenow="<?php echo e($finalArray['PerformPer']); ?>" aria-valuemin="0" aria-valuemax="100"
                                     style="width:<?php echo e($finalArray['PerformPer']); ?>%">

                                </div>
                            </div>
                            <br>
                            
                            <p class="text-muted font-13 mb-1">
                                <i class="mdi mdi-checkbox-blank-circle mr-2 text-success"></i>
                                <?php if($sponsor_type == 1): ?>
                                    Average Sponsorship Offered for Think Tank
                                <?php else: ?>
                                    Average Price of Think Tank Sponsorship
                                <?php endif; ?>

                            </p>
                            <p class="text-muted font-13 mb-1">
                                <span class="float-right"> <?php echo e($finalArray['ThinkTankBudgetMessage']); ?> (Based on <?php echo e($ThinkTankTotalUsers); ?> inputs )</span>
                            </p>
                            <a href="javascript:void(0)" id="a17" onClick="changeContent(17,18)" data-toggle="collapse"
                               data-target="#Regional">View More</a>
                            <a href="javascript:void(0)" id="a18" onClick="changeContent(18,17)" data-toggle="collapse"
                               data-target="#Regional">View Less</a>

                            <div id="Regional" class="collapse">
                                <button href="javascript:void(0)" class="forgot_button">Regional
                                    (<?php echo e($finalArray['Regional']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Global
                                    (<?php echo e($finalArray['Global']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button" style="width: 160px;">Not Decided yet
                                    (<?php echo e($finalArray['notDYet8']); ?>)
                                </button>
                            </div>
                            <br>
                            <div class="progress">
                                <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar"
                                     aria-valuenow="<?php echo e($finalArray['ThinkTankPer']); ?>" aria-valuemin="0"
                                     aria-valuemax="100" style="width:<?php echo e($finalArray['ThinkTankPer']); ?>%">

                                </div>
                            </div>
                            <br>
                            
                            <p class="text-muted font-13 mb-1">
                                <i class="mdi mdi-checkbox-blank-circle mr-2 text-success"></i>
                                <?php if($sponsor_type == 1): ?>
                                    Average Sponsorship Offered for Knowledge Pool
                                <?php else: ?>
                                    Average Price of Knowledge Pool Sponsorship
                                <?php endif; ?>

                            </p>
                            <p class="text-muted font-13 mb-1">
                                <span class="float-right"> <?php echo e($finalArray['KnowledgePoolBudgetMessage']); ?> (Based on <?php echo e($KnowledgePoolTotalUsers); ?> inputs )</span>
                            </p>
                            <a href="javascript:void(0)" id="a19" onClick="changeContent(19,20)" data-toggle="collapse"
                               data-target="#Pedia">View More</a>
                            <a href="javascript:void(0)" id="a20" onClick="changeContent(20,19)" data-toggle="collapse"
                               data-target="#Pedia">View Less</a>

                            <div id="Pedia" class="collapse">
                                <button href="javascript:void(0)" class="forgot_button">Lecture Series
                                    (<?php echo e($finalArray['LectureSeries']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Pedia (<?php echo e($finalArray['Pedia']); ?>

                                    )
                                </button>
                                <button href="javascript:void(0)" class="forgot_button" style="width: 160px;">Not Decided yet
                                    (<?php echo e($finalArray['notDYet9']); ?>)
                                </button>

                            </div>
                            <br>
                            <div class="progress">
                                <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar"
                                     aria-valuenow="<?php echo e($finalArray['KnowledgePoolPer']); ?>" aria-valuemin="0"
                                     aria-valuemax="100" style="width:<?php echo e($finalArray['KnowledgePoolPer']); ?>%">

                                </div>
                            </div>
                            <br>
                            <p class="text-muted font-13 mb-1">
                                <i class="mdi mdi-checkbox-blank-circle mr-2 text-success"></i>
                                <?php if($sponsor_type == 1): ?>
                                    Average Sponsorship Offered for Online Activities
                                <?php else: ?>
                                    Average Price of Online Activities  Sponsorship
                                <?php endif; ?>

                            </p>
                            <p class="text-muted font-13 mb-1">
                                <span class="float-right"> <?php echo e($finalArray['OnlineEventBudgetMessage']); ?> (Based on <?php echo e($OnlineEventsTotalUsers); ?> inputs )</span>
                            </p>
                            <a href="javascript:void(0)" id="a21" onClick="changeContent(21,22)" data-toggle="collapse"
                               data-target="#Regional">View More</a>
                            <a href="javascript:void(0)" id="a22" onClick="changeContent(22,21)" data-toggle="collapse"
                               data-target="#Regional">View Less</a>

                            <div id="Regional" class="collapse">
                                <button href="javascript:void(0)" class="forgot_button">Webinar
                                    (<?php echo e($finalArray['Webinar']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Webcast
                                    (<?php echo e($finalArray['Webcast']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Live Stream
                                    (<?php echo e($finalArray['LiveStream']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Chat Groups
                                    (<?php echo e($finalArray['ChatGroups']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button">Media Forum
                                    (<?php echo e($finalArray['MediaForum']); ?>)
                                </button>
                                <button href="javascript:void(0)" style="width: 200px" class="forgot_button">Focus Group
                                    Board (<?php echo e($finalArray['FocusGroupBoard']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button" style="width: 160px;">Not Decided yet
                                    (<?php echo e($finalArray['notDYet10']); ?>)
                                </button>
                            </div>
                            <br>
                            <div class="progress">
                                <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar"
                                     aria-valuenow="<?php echo e($finalArray['OnlineEventsPer']); ?>" aria-valuemin="0"
                                     aria-valuemax="100" style="width:<?php echo e($finalArray['OnlineEventsPer']); ?>%">

                                </div>
                            </div>
                            <br>
                            
                            <p class="text-muted font-13 mb-1">
                                <i class="mdi mdi-checkbox-blank-circle mr-2 text-success"></i>
                                <?php if($sponsor_type == 1): ?>
                                    Average Sponsorship Offered for Research
                                <?php else: ?>
                                    Average Price of Research Sponsorship
                                <?php endif; ?>

                            </p>
                            <p class="text-muted font-13 mb-1">
                                <span class="float-right"> <?php echo e($finalArray['ResearchBudgetMessage']); ?> (Based on <?php echo e($ReserachTotalUsers); ?> inputs )</span>
                            </p>
                            <a href="javascript:void(0)" id="a29" onClick="changeContent(29,30)" data-toggle="collapse"
                               data-target="#Research">View More</a>
                            <a href="javascript:void(0)" id="a30" onClick="changeContent(30,29)" data-toggle="collapse"
                               data-target="#Research">View Less</a>

                            <div id="Research" class="collapse">
                                <button href="javascript:void(0)" class="forgot_button" style="width: 200px">
                                    Commercial(<?php echo e($finalArray['commercialandscient']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button" style="width: 200px"> Scientific
                                    (<?php echo e($finalArray['scientific']); ?>)
                                </button>
                                <button href="javascript:void(0)" class="forgot_button" style="width: 160px;">Not Decided yet
                                    (<?php echo e($finalArray['notDYet11']); ?>)
                                </button>
                            </div>
                            <br>
                            <div class="progress">
                                <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar"
                                     aria-valuenow="<?php echo e($finalArray['researchUserPer']); ?>" aria-valuemin="0"
                                     aria-valuemax="100" style="width:<?php echo e($finalArray['researchUserPer']); ?>%">

                                </div>
                            </div>
                            <br>


                            <p class="text-muted font-13 mb-1">
                                <i class="mdi mdi-checkbox-blank-circle mr-2 text-success"></i> <?php if($sponsor_type == 1): ?>
                                    Average Sponsorship Offered for Other
                                <?php else: ?>
                                    Average Price of Other Sponsorship
                                <?php endif; ?>
                            </p>
                            <p class="text-muted font-13 mb-1">
                                <span class="float-right"> <?php echo e($finalArray['OtherBudgetMessage']); ?> (Based on <?php echo e($OtherTotalUsers); ?> inputs )</span>
                            </p>
                            <div class="progress">
                                <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar"
                                     aria-valuenow="<?php echo e($finalArray['OtherUserPer']); ?>" aria-valuemin="0"
                                     aria-valuemax="100" style="width:<?php echo e($finalArray['OtherUserPer']); ?>%">

                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="col-md-12 col-lg-12 align-self-center">
                            No data Found For this Country
                        </div>
                <?php endif; ?>
                <!--<div id="bardiv"></div>-->
                </div>
                <p>*Calculation based on 100 users per section</p>
            </div>


            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" onclick="closePopup()" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#a2,#a4,#a6,#a8,#a10,#a12,#a14,#a16,#a18,#a20,#a22,#a30').hide();
    });

    function changeContent(currentId, newId) {
        $('#a' + currentId).hide();
        $('#a' + newId).show();
    }
</script>
