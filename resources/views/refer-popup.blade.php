<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
    @php
        if(Auth::user()->sponsor_type == 3){
            $url = url('partner-refer').'/' .Auth::user()->refer_code;
        }
        else{
            $url = url('refer').'/' .Auth::user()->refer_code;
        }
    @endphp
    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Refer & Earn</h4>
                <h5 class="modal-title">Refer your clients, colleagues or anyone who may benefit using Ayojn. Share
                    the unique link, it comes with a USD @if(Auth::user()->sponsor_type != 3) 30 @else 100 @endif
                    discount voucher for anyone who signs up using this link. In return you would earn 30% of the
                    service fees (in cash) whenever your referred users spend at Ayojn.</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-9">
                        <span id="refer_{{ $userData->id }}" class="share-course-filed"
                              style="display: none">{{ $url }} </span>

                        <input class="form-control" value="{{ $url }}" disabled>
                    </div>
                    <div class="col-md-3">
                        <a href="javascript:void(0)" class="btn btn-primary read-more-btn  share-opp-btn-refer"
                           onclick="copyToClipboardRefered('#refer_{{ $userData->id }}')">Copy Web link</a>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12 mb-5">
                        Referral Registered : <b>{{ $existingReferedUsers->count() }}</b><br><br/>
                        Wallet Balance : <b>{{ Auth::user()->wallet_balance }} points</b>(1 Point = 1 USD) &nbsp;&nbsp;
                        <a
                            href="{{ url('redeem-request') }}" class="btn btn-primary btn-sm">Redeem</a> <br>
                    </div>
                </div>
                {{--                @if(!empty($existingReferedUsers->first()))--}}
                {{--                    @foreach($existingReferedUsers as $user)--}}
                {{--                        <div class="row">--}}
                {{--                            <div class="col-md-8">--}}
                {{--                                {{ $user->email }}--}}
                {{--                            </div>--}}
                {{--                            <div class="col-md-4">--}}
                {{--                                {{ $user->phone_no }}--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    @endforeach--}}
                {{--                @endif--}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<script>
    $(".share-opp-btn-refer").on('click', function (e) {
        toastr.success('Web Link Copied', 'Success');
    });


    function copyToClipboardRefered(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();
    }
</script>
