<?php $__env->startSection('content'); ?>

	<!-- banner section start -->
	<link rel="stylesheet" href="<?php echo e(asset('css/slick-theme.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(asset('css/slick.css')); ?>">
	<style>
		.body-contianer.only-scroll-content {
			overflow: hidden;
			padding-bottom: 0;
		}
	</style>
	<div class="flw main-body stories">
		<div class="inner-main-body">
			<div class="container">
				<div class="row section">
					<div class="col-lg-6 col-xs-12">
						<div class="text-container">
							<h1>Sponsorship Index</h1>
							<h2>Global spend Index of Sponsorship by the users at Sponsay. </h2>
							<a href="#" class="btn btn-primary-new" data-toggle="modal" data-target="#loginForm">Who's spending, How much ?</a>
						</div>
					</div>
					<div class="col-lg-6 col-xs-12">
						<img src="images/solution.png" class="img-responsive"/>
					</div>
				</div>

				<div class="row section rtl">
					<div class="col-lg-6 col-xs-12">
						<div class="text-container">
							<h1>Bids Listing</h1>
							<h2>Activate & Manage the bidding process for Sponsorship activities.</h2>
							<a href="#" class="btn btn-primary-new" data-toggle="modal" data-target="#loginForm">List Yours</a>
						</div>
					</div>
					<div class="col-lg-6 col-xs-12">
						<img src="images/solution2.png" class="img-responsive"/>
					</div>
				</div>
				<div class="row section">
					<div class="col-lg-6 col-xs-12">
						<div class="text-container">
							<h1>Opportunities Discovery</h1>
							<h2>Discover potential sponsorable Opportunities. </h2>
							<a href="#" class="btn btn-primary-new" data-toggle="modal" data-target="#loginForm">Discover</a>
						</div>
					</div>
					<div class="col-lg-6 col-xs-12">
						<img src="images/solution3.png" class="img-responsive"/>
					</div>
				</div>
				<div class="row section rtl">
					<div class="col-lg-6 col-xs-12">
						<div class="text-container">
							<h1>Events Support</h1>
							<h2>Run your events efficiently.</h2>
							<a href="#" class="btn btn-primary-new" data-toggle="modal" data-target="#loginForm">Explore</a>
						</div>
					</div>
					<div class="col-lg-6 col-xs-12">
						<img src="images/Events_pic.jpg" class="img-responsive"/>
					</div>
				</div>

			</div>

		</div>
	</div>

	<script src="<?php echo e(asset('js/jquery1.min.js')); ?>"></script>
	<script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
	<script src="<?php echo e(asset('js/typed.min.js')); ?>"></script>
	<script src="<?php echo e(asset('js/slick.min.js')); ?>"></script>
	<script>


      (function ($) {
        if ($.fn.typed) {
          var $typedStrings = $('.typed-strings');
          $typedStrings.typed({
            strings: ['connect at sponsay.com', ' You can also follow us on ', 'Twitter, LinkedIn, Quora', 'and Medium '],
            typeSpeed: 130,
            loop: true,
            showCursor: false
          });
        } else {
          console.log('Animated typing: Plugin "typed" is not loaded.');
        }


//$(document).on('click','.nextOption',function(){
        //$(this).parent('.formClass').hide();
        //$(this).parent('.formClass').next('.formClass').show();

//})


        $(document).on('click', '.secondFormNext', function () {

        });

        //slider
        $('.slider-main .slider-inner').slick({
          infinite: true,
          slidesToShow: 1,
          slidesToScroll: 1,
          arrows: false,
          dots:false,
          autoplay: true,
          autoplaySpeed: 2000,
        });

        $('#wrapper').removeClass('body-contianer only-scroll-content');


      })(jQuery);

	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>