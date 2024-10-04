@extends('layout')

@section('content')
	<div class="container">
		<br />
		<br />
		<br />
		<br />
		<div class="panel-group" id="accordion" style="margin-top: 47px;">
			<div class="faqHeader">Some of the most frequent thoughts you may have are answered here. If NOT then we are always around via live chat or send us an email at connect (at) ayojn.com</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Why is my profile pending? </a>
					</h4>
				</div>
				<div id="collapseOne" class="panel-collapse collapse">
					<div class="panel-body">
						Most likely because of the lack of evidence we could find to establish if you are a legitimate entity as per the information you shared.

					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">How can my profile be approved?  </a>
					</h4>
				</div>
				<div id="collapseTwo" class="panel-collapse collapse">
					<div class="panel-body">
						By referring users since our approval tracking system works on how many users have joined in using your unique link. You can find the unique web link from the Recommend tab.
						Make sure you use a professional/ business email to sign-up. You may edit it from the Profile tab.

					</div>
				</div>
			</div>

		</div>
	</div>
	<style>
		.faqHeader {
			font-size: 27px;
			margin: 20px;
		}

		.panel-heading [data-toggle="collapse"]:after {
			font-family: 'Glyphicons Halflings';
			/*content: "/f061"; !* "play" icon *!*/
			float: right;
			color: #F58723;
			font-size: 18px;
			line-height: 22px;
			/* rotate "play" icon from > (right arrow) to down arrow */
			-webkit-transform: rotate(-90deg);
			-moz-transform: rotate(-90deg);
			-ms-transform: rotate(-90deg);
			-o-transform: rotate(-90deg);
			transform: rotate(-90deg);
		}

		.panel-heading [data-toggle="collapse"].collapsed:after {
			/* rotate "play" icon from > (right arrow) to ^ (up arrow) */
			-webkit-transform: rotate(90deg);
			-moz-transform: rotate(90deg);
			-ms-transform: rotate(90deg);
			-o-transform: rotate(90deg);
			transform: rotate(90deg);
			color: #454444;
		}
	</style>
@endsection
