
<div class="modal" id="read-more-response" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
				<h4 class="modal-title" id="myModalLabel" style="text-align: center">Response Detail</h4>
				<h4 id="bid_id" style="text-align: center"></h4>
			</div>
			<div class="modal-body">
				<form class="addBidForm" id="addBidForm" method="post" onsubmit="return false"
					  name="addBidForm">

					<div class="form-group autocomplete">
						<label>
							<strong>Bidder's Pitch</strong>
						</label>
						<textarea id="description" disabled="disabled" name="description"
								  class="form-control">{{ $bids->description }}</textarea>
					</div>
					<div class="form-group autocomplete">
						<label>
							<strong>Portfolio Link</strong>

						</label>
						<input id="portfolio" disabled name="portfolio" value="{{ $bids->portfolio_link }}"
							   class="form-control">
					</div>
					<div class="form-group autocomplete">
						<label>
							<strong>Email</strong>

						</label>

						@if($bids->is_accepted ==2)
							<input disabled name="country"
								   value="{{ (!empty($bids->userDetail)) ? $bids->userDetail->email : "" }}"
								   class="form-control">

						@else
							<input disabled name="country"
								   value="XXXX@gmail.com"
								   class="form-control">
						@endif
					</div>
					<div class="form-group autocomplete">
						<label>
							<strong>Country</strong>

						</label>
						<input disabled name="country"
							   value="{{ (!empty($bids->userDetail->country_name)) ? $bids->userDetail->country_name->country_name : ""}}"
							   class="form-control">
					</div>
					<div class="form-group autocomplete">
						@if($bids->is_accepted == 2 || $bids->is_accepted == 1)
						<label>
							<strong>Status</strong>

						</label>
						@if($bids->is_accepted == 2)
							<span class="label label-success">Open for Negotiation </span>
						@elseif($bids->is_accepted == 1)
							<span class="label label-success">Read</span>
						@endif
							@endif
					</div>


				</form>

			</div>

		</div>
	</div>
</div>
