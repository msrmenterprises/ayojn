@extends('layout')

@section('content')
	<style>
		.error {
			color: red;
		}

		/*the container must be positioned relative:*/
		.autocomplete {
			position: relative;
			display: inline-block;
		}

		input {
			border: 1px solid transparent;
			background-color: #f1f1f1;
			padding: 10px;
			font-size: 16px;
		}

		input[type=text] {
			background-color: #f1f1f1;
			width: 100%;
		}

		input[type=submit] {
			background-color: DodgerBlue;
			color: #fff;
			cursor: pointer;
		}

		.autocomplete-items {
			position: absolute;
			border: 1px solid #d4d4d4;
			border-bottom: none;
			border-top: none;
			z-index: 99;
			/*position the autocomplete items to be the same width as the container:*/
			top: 100%;
			left: 0;
			right: 0;
		}

		.autocomplete-items div {
			padding: 10px;
			cursor: pointer;
			background-color: #fff;
			border-bottom: 1px solid #d4d4d4;
		}

		/*when hovering an item:*/
		.autocomplete-items div:hover {
			background-color: #e9e9e9;
		}

		/*when navigating through the items using the arrow keys:*/
		.autocomplete-active {
			background-color: DodgerBlue !important;
			color: #ffffff;
		}
	</style>
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
		<div class="container" style="text-align: center;padding-top: 15px;">

			<div class="row">
				<h3>Build Opportunities</h3>
			</div>
			<div class="row">
				<div class="col-md-3"></div>
				<div class="col-md-6">
					Let’s build opportunities based on your past, present & future expertise
				</div>
			</div>

			<br>
			<form name="add-opportunity" method="post" id="add-opportunity" action="{{ url('add-new-opportunity') }}">
				<div id="add-opporutnity-form">
					<div class="row">
						<div class="col-md-3"></div>
						<div class="col-md-6">
							<select class="form-group form-control opportunity_country" name="opportunity_country"
									onchange="changeEffect();getCity(8)"
									id="opportunity_country" required>
								<option value="">Select Country</option>
								@if(!empty($countries))
									@foreach($countries as $c)
										<option value="{{$c->country_code}}">{{ $c->country_name }}</option>
									@endforeach
								@endif
							</select>
						</div>
					</div>
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <select class="form-group form-control opportunity_country" name="opportunity_city" id="opportunity_city" required onchange="changeEffect()">
                                <option value="">Select City</option>
                            </select>
                        </div>
                    </div>
					<div class="row">
						<div class="col-md-3"></div>
						<div class="col-md-6">
							<select class="form-group form-control opportunity_industry" name="opportunity_industry"
									onchange="changeEffect()"
									id="opportunity_industry" required>
								<option value="">Select Industry</option>
								@foreach($industries as $in){
								<option value="{{ $in->id}}">{{ $in->name}}</option>
								}
								@endforeach
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3"></div>
						<div class="col-md-6 autocomplete" style="width: 584px;">
							<input type="text" name="hashtags" class="form-group form-control hashtag"
								   placeholder="#BuildAnOpportunity" id="hashtags" required readonly>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<button type="submit" class="btn btn-primary"
						>Submit
						</button> &nbsp;
						{{--						<a title="Add More" id="add_fields" class="btn btn-primary"--}}
						{{--						>Add More</a>--}}
					</div>
				</div>

				<input type="hidden" id="counter" name="counter" value="1">
			</form>
			<br>
		</div>
		<div id="myModal" class="modal fade" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-body">
						<br>
						<br>
						<p>Great to see you launch a new opportunity, wait for a while for the vouch from the clients.
							We will notify you once the first vouch comes in.</p>
						<br>
						<!--<p>In the meanwhile let's prepare you to build a winning proposal using <a
								href="https://www.proposify.com/" target="_blank">Proposify.</a></p> -->

						<br>
						<a href="{{ url('opportunity') }}" class="btn btn-primary">Go to My Opportunities</a>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>

			</div>
		</div>
	</section>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
	@if(session()->has('success_messagesss'))
		<script>
          setTimeout(function () {
            $("#myModal").modal('show');
          }, 2000)
		</script>
	@endif
	<script>
      $(document).ready(function () {
        $('#add_fields').click(function () {
          add_inputs()
        });

        $(document).on('click', '.remove_fields', function () {
          $(this).closest('.record').remove();
        });

        function add_inputs() {
          var counter = parseInt($('#counter').val());
          var html = '<hr ><span class="record"><div class="row">' +
            '<div class="col-md-3"></div>' +
            '<div class="col-md-6">' +
            '<input type="text" class="form-group form-control hashtag" name="hashtags[' + counter + ']" placeholder="BuildAnOpportunity " required>' +
            '</div>' +
            '</div>' +
            '<div class="row">' +
            '<div class="col-md-3"></div>' +
            '<div class="col-md-6">' +
            '<select class="form-group form-control opportunity_country" name="opportunity_country[' + counter + ']" required>' +
            '<option value="">Select Country</option>';
            <?php
                if(! empty($countries)) {
                foreach($countries as $c) {?>
              html += '<option value="{{$c->country_code}}" >{{ $c->country_name }}</option>';
            <?php }
                }
                ?>
              html += '</select>' +
              '</div>' +
              '</div>' +
              '<div class="row">' +
              '<div class="col-md-3"></div>' +
              '<div class="col-md-6">' +
              '<select class="form-group form-control opportunity_industry" name="opportunity_industry[' + counter + ']" required>' +
              '<option value="">Select Industry</option>';
            <?php
                if(! empty($industries)) {
                foreach($industries as $in){ ?>
              html += '<option value="{{$in->id}}">{{ trim($in->name) }}</option>';
            <?php }
                }
                ?>
              html += '</select>' +
              '</div><div class="col-md-3"><a title="Add More" class=" remove_fields btn btn-danger">' +
              'Remove</a></div>' +
              '</div> </span>';


          // var html = '<div class="record"><input type="text" placeholder="Name" name="name_' + counter + '" class="name_input"><input type="email" name="email_' + counter + '" placeholder="Email" class="email_input"><button type="button" class="remove_fields">-</button></div>';

          $('#add-opporutnity-form').append(html);
          $('#counter').val(counter + 1);
        }
      });
      $("#add-opportunity").validate();

      function displayEmail(email) {
        swal(email);
      }

      function OpenPopup(bidId) {
        $("#bid_id").text("#" + bidId);
        $("#bid_input_id").val(bidId);
        $("#add-bid").modal('show');
      }

      function addBid() {
        var bid_id = $("#bid_input_id").val();
        var description = $("#description").val();
        var portfolio = $("#portfolio").val();
        $.ajax({
          type: 'POST',
          url: '{{ url('add-bid-response') }}',
          headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
          data: {
            bid_id: bid_id,
            description: description,
            portfolio_link: portfolio,
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
	</script>
	<script src="{{ asset('js/jquery1.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('js/typed.min.js') }}"></script>
	<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script>
      /*An array containing all the country names in the world:*/
      var Hashtags = [];

      function changeEffect() {
        var countryId = $("#opportunity_country").val();
        var industryId = $("#opportunity_industry").val();
        var opportunity_city = $("#opportunity_city").val();
        if (countryId != '' && industryId != ''&& opportunity_city != '') {

          $("#hashtags").attr("readonly", false);
          $.ajax({
            type: 'GET',
            url: '{{ url('get-hashtags') }}',
            headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
            data: {
              countryId: countryId,
              industryId: industryId,
                opportunity_city: opportunity_city,
            },
            success: function (response) {
              //console.log(response.status);

              if (response.hashTags != '') {
                Hashtags = response.hashTags.split(',');
              }
              autocomplete(document.getElementById("hashtags"), Hashtags);
            },
            error: function (response) {
            },
          });
        }
      }

      function autocomplete(inp, arr) {
        /*the autocomplete function takes two arguments,
		the text field element and an array of possible autocompleted values:*/
        var currentFocus;
        /*execute a function when someone writes in the text field:*/
        inp.addEventListener("input", function (e) {
          var a, b, i, val = this.value;
          /*close any already open lists of autocompleted values*/
          closeAllLists();
          if (!val) {
            return false;
          }
          currentFocus = -1;
          /*create a DIV element that will contain the items (values):*/
          a = document.createElement("DIV");
          a.setAttribute("id", this.id + "autocomplete-list");
          a.setAttribute("class", "autocomplete-items");
          /*append the DIV element as a child of the autocomplete container:*/
          this.parentNode.appendChild(a);
          /*for each item in the array...*/
          for (i = 0; i < arr.length; i++) {
            /*check if the item starts with the same letters as the text field value:*/
            if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
              /*create a DIV element for each matching element:*/
              b = document.createElement("DIV");
              /*make the matching letters bold:*/
              b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
              b.innerHTML += arr[i].substr(val.length);
              /*insert a input field that will hold the current array item's value:*/
              b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
              /*execute a function when someone clicks on the item value (DIV element):*/
              b.addEventListener("click", function (e) {
                /*insert the value for the autocomplete text field:*/
                inp.value = this.getElementsByTagName("input")[0].value;
                /*close the list of autocompleted values,
				(or any other open lists of autocompleted values:*/
                closeAllLists();
              });
              a.appendChild(b);
            }
          }
        });
        /*execute a function presses a key on the keyboard:*/
        inp.addEventListener("keydown", function (e) {
          var x = document.getElementById(this.id + "autocomplete-list");
          if (x) x = x.getElementsByTagName("div");
          if (e.keyCode == 40) {
            /*If the arrow DOWN key is pressed,
			increase the currentFocus variable:*/
            currentFocus++;
            /*and and make the current item more visible:*/
            addActive(x);
          } else if (e.keyCode == 38) { //up
            /*If the arrow UP key is pressed,
			decrease the currentFocus variable:*/
            currentFocus--;
            /*and and make the current item more visible:*/
            addActive(x);
          } else if (e.keyCode == 13) {
            /*If the ENTER key is pressed, prevent the form from being submitted,*/
            e.preventDefault();
            if (currentFocus > -1) {
              /*and simulate a click on the "active" item:*/
              if (x) x[currentFocus].click();
            }
          }
        });

        function addActive(x) {
          /*a function to classify an item as "active":*/
          if (!x) return false;
          /*start by removing the "active" class on all items:*/
          removeActive(x);
          if (currentFocus >= x.length) currentFocus = 0;
          if (currentFocus < 0) currentFocus = (x.length - 1);
          /*add class "autocomplete-active":*/
          x[currentFocus].classList.add("autocomplete-active");
        }

        function removeActive(x) {
          /*a function to remove the "active" class from all autocomplete items:*/
          for (var i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active");
          }
        }

        function closeAllLists(elmnt) {
          /*close all autocomplete lists in the document,
		  except the one passed as an argument:*/
          var x = document.getElementsByClassName("autocomplete-items");
          for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
              x[i].parentNode.removeChild(x[i]);
            }
          }
        }

        /*execute a function when someone clicks in the document:*/
        document.addEventListener("click", function (e) {
          closeAllLists(e.target);
        });
      }


      /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
	</script>
	<script>

      $(document).ready(function () {

        $('#table_id').DataTable();
      });
	</script>
@endsection
