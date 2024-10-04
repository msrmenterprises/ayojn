<?php

namespace App\Http\Controllers\UserAuth;

use App\Bid;
use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Offer;
use App\ResponseBid;
use App\SponsorrSpecifyBid;
use App\Traits\ApiResponse;
use App\User;
use App\VouchCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;
use DB;
use Validator;

class BidController extends Controller
{

    use ApiResponse;

    public function myResponse(Request $request)
    {

        $bids = ResponseBid::with(['bid', 'userDetail', 'userDetail.country_name'])
            ->where('respond_user_id', Auth::user()->id)->get();

        return view('bid.my-response', compact('bids'));
    }

    public function shareBid(Request $request, $id)
    {
//        if (! empty(Auth::user())) {
//            return redirect('bid');
//        }
        $bidData = Bid::with(['country_name', 'bidResponse', 'bidSpecify', 'bidSpecify.specifyName'])
            ->where('share_id', $id)->first();
        if (!empty($bidData)) {
            session()->flash('url.intended', '/' . request()->path());

            return view('bid.share-bid', compact('bidData'));
        } else {
            return view('bid.datanotfound');
        }
    }

    public function index(Request $request)
    {
        if (Auth::user()->sponsor_type == 1) {
            $bids = new Bid();
            $bids = $bids->with(['country_name', 'bidResponseWithSpam', 'bidSpecify', 'bidSpecify.specifyName'])
                ->where('user_id', Auth::user()->id)->where('is_paid', 1);
            $unpaid = Bid::where('user_id', Auth::user()->id)->where('is_paid', 0)->count();

            if ($request->query('f')) {
                $bids = $bids->where('sponsor_for', 'like', $request->query('f'));
            }
            if ($request->query('c')) {
                $bids = $bids->where('sponsor_country', 'like', $request->query('c'));
            }
            if ($request->query('b')) {
                $bids = $bids->where('sponsor_budget', 'like', $request->query('b'));
            }
            if ($request->query('i')) {
                $bids = $bids->where('sponsor_industry', 'like', $request->query('i'));
            }
            $bids = $bids->get();

           
            return view('bid.bid', compact('bids', 'unpaid'));
        } else if (Auth::user()->sponsor_type == 2) {
            $bids = Bid::with(['bider', 'country_name', 'bidSpecify', 'bidSpecify.specifyName', 'bidResponse' => function ($query) {
                $query->where("respond_user_id", Auth::user()->id);
            }
            ])->where('status', '=', 'On')->where('is_paid', 1);
            if ($request->query('f')) {
                $bids = $bids->where('sponsor_for', 'like', $request->query('f'));
            }
            if ($request->query('c')) {
                $bids = $bids->where('sponsor_country', 'like', $request->query('c'));
            }
            if ($request->query('b')) {
                $bids = $bids->where('sponsor_budget', 'like', $request->query('b'));
            }
            if ($request->query('i')) {
                $bids = $bids->where('sponsor_industry', 'like', $request->query('i'));
            }
            if ($request->query('qa')) {
                $bids = $bids->where('identity', 'like', $request->query('qa'));
            }
            if ($request->query('f_c')) {
                $bids = $bids->where('city', 'like', $request->query('f_c'));
            }
            $bids = $bids->get();

            return view('bid.receive-bids', compact('bids'));
        }
    }

    public function unpaid(Request $request)
    {
        $bids = new Bid();
        $bids = $bids->with(['country_name', 'bidResponse', 'bidSpecify', 'bidSpecify.specifyName'])
            ->where('user_id', Auth::user()->id)->where('is_paid', 0)->get();

        return view('bid.unpaid-bid', compact('bids'));
    }

    public function myBidResponse(Request $request, $bidId)
    {

       
        if ($bidId != '') {
            $id = base64_decode($bidId);
        } else {
            $id = '';
        }
        $bidDetail = Bid::with(['bidResponse', 'bidResponse.userDetail', 'bidResponse.userDetail.country_name'])
            ->where('id', $id)->first();

        $bidResponse = ResponseBid::with(['bid', 'userDetail', 'userDetail.country_name'])->where('bid_id', $id)
            ->where('is_spam', 0);
        if ($request->query('i')) {
            $bidResponse = $bidResponse->where('is_accepted', $request->query('i'));
        }
        if ($request->query('c')) {
            $bidResponse = $bidResponse->whereHas('userDetail', function ($query) use ($request) {
                $query->where('country', $request->query('c'));
            });
        }
        if ($request->query('city')) {
            $bidResponse = $bidResponse->whereHas('userDetail', function ($query) use ($request) {
                $query->where('city', $request->query('city'));
            });
        }
        if ($request->query('f')) {
            $bidResponse = $bidResponse->whereHas('userDetail', function ($query) use ($request) {
                $query->where('identity', 'like', '%' . $request->query('f') . '%');
            });
        }

        $bidResponses = $bidResponse->get();
        //dd($bidResponse);

        // $bidId = $id;

        return view('bid.my-bid-response', compact('bidDetail', 'bidId', 'bidResponses'));
    }
    public function bookNegotiation(Request $request)
    {
        $bidId = $request->bidId;

        $bids = ResponseBid::with(['bid', 'userDetail', 'userDetail.country_name'])->where('id', $bidId)->first();
            if ($bids->is_accepted = 2) {
                $bids->is_accepted = 3;
                $bids->save();
            }

        return response()->json($bidId);
    }
    

    public function spamBid(Request $request, $bidId)
    {
        if ($bidId != '') {
            $id = base64_decode($bidId);
        } else {
            $id = '';
        }
//        $bidDetail = Bid::with(['bidSpamResponse', 'bidSpamResponse.userDetail', 'bidSpamResponse.userDetail.country_name'])
//            ->where('id', $id)->first();
        $spamBidResponse = ResponseBid::with(['userDetail', 'userDetail.country_name'])->where('bid_id', $id)
            ->where('is_spam', 1)->get();

        // $bidId = $id;

        return view('bid.my-bid-spam-response', compact('spamBidResponse', 'bidId', 'id'));
    }

    public function RestoreSpamBid(Request $request, $id)
    {
        ResponseBid::where('id', $id)->update(['is_spam' => 0]);
        $bidData = ResponseBid::where('id', $id)->first();

        return redirect(url('bid-response') . '/' . base64_encode($bidData->bid_id));
    }

    public function addReason(Request $request, $id)
    {
        $responseDetail = ResponseBid::where('id', $id)->first();
        $view = view('bid.add-reason',
            compact('responseDetail'))->render();

        return response()->json(['html' => $view, 'responseDetail' => $responseDetail]);
    }

    public function addReasonOfReason(Request $request)
    {
        $responses = ResponseBid::where('id', $request->responseId)
            ->update(['spam_reason' => $request->response, 'is_spam' => 1]);

        return $this->successResponse("Bid response has been added to spam.", ['status' => 1]);
    }

    public function recieveBids()
    {
        $bids = Bid::with(['country_name', 'bidResponse'])->get();

        return view('bid.receive-bids', compact('bids'));
    }

    public function getBidResponse(Request $request, $id)
    {
        $bids = ResponseBid::with(['bid', 'userDetail', 'userDetail.country_name'])->where('id', $id)->first();
        if (Auth::user()->sponsor_type == 1) {
            if ($bids->is_accepted < 2) {
                $bids->is_accepted = 1;
                $bids->save();
            }

            if ($bids->is_counted == 0) {

                $receiverUser = User::find($bids->respond_user_id);

                if (!empty($receiverUser) && $receiverUser->free_response > 0) {

                    $receiverUser->free_response = $receiverUser->free_response - 1;
                    $receiverUser->save();
                    $bids->is_counted = 1;
                    $bids->save();
                }
            }
        }


        //dd($bids);
        $view = view('bid.read-response', compact('bids'))->render();

        return response()->json(['html' => $view]);
    }

    public function acceptBid(Request $request, $responseId)
    {
       
        $responses = ResponseBid::where('id', $responseId)->first();
        $responses->is_accepted = $request->status;
        $responses->save();
        if($request->status==1)
        {
            return $this->successResponse("Bid Has been Accepted.", ['status' => 1]);
        }
        if($request->status==2)
        {
            return $this->successResponse("Bid Has been Booked.", ['status' => 1]);
        }
        if($request->status==3)
        {
            return $this->successResponse("Bid Has been Paid.", ['status' => 1]);
        }
       
    }

    public function addNewBid(Request $request)
    {
        $rules = [
            'status' => 'required',
            'sponsorr_type_bid' => 'required',
            'specify_bid' => 'required',
            'country_bid' => 'required',
            'industry_bid' => 'required',
            'budget_bid' => 'required',
            'city_bidder_from' => 'required',

        ];
        $messsages = [
            'status.required' => 'Select Status',
            'sponsorr_type_bid.required' => 'Select Sponsor For',
            'specify_bid.required' => 'Select Specify',
            'country_bid.required' => 'Select Country for Bid',
            'industry_bid.required' => 'Select Industry',
            'budget_bid.required' => 'Select budget of Bid',
            'city_bidder_from.required' => 'Select bidder city',
        ];
        $validator = Validator::make($request->all(), $rules, $messsages);
        if ($validator->fails()) {
            return $this->validationErrors($validator)->setStatusCode(200);
        }
        $bidData = [
            'user_id' => Auth::user()->id,
            'sponsor_for' => $request->sponsorr_type_bid,
            'sponsor_budget' => $request->budget_bid,
            'sponsor_industry' => $request->industry_bid,
            'sponsor_country' => $request->country_bid,
            'city' => $request->city_bid,
            'city_bidder_from' => $request->city_bidder_from,
            'contacted_by' => $request->contacted_by,
            'identity' => $request->identity_bid,
            'status' => $request->status,
            'bid_start_date' => date('Y-m-d H:i:s'),
            'country' => Auth::user()->country
        ];
        if (!empty($request->likeSponsorr)) {
            $bidData['likeSponsorr'] = implode(',', $request->likeSponsorr);
        }
        $response = Bid::create($bidData);
        $response->share_id = $this->uniquiShareId($response->id);
        $response->save();

        if (isset($request->specify_bid) && !empty($request->specify_bid)) {
            foreach ($request->specify_bid as $sponsor_specify) {
                $specifyUser_list = [
                    'specify_name' => $sponsor_specify,
                    'user_id' => Auth::user()->id,
                    'bid_id' => $response->id
                ];

                $specifyUser = SponsorrSpecifyBid::create($specifyUser_list);
            }
        }
        if ($response) {
            return $this->successResponse("Bid Has been Added.");
        } else {
            return $this->failResponse("Error Occured!Please try again later")->setStatusCode(200);
        }
    }

    public function addNewVouchCode(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'vouch_code' => "required",
        ], [
            'vouch_code.required' => "Vouch code is required",
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()])
                ->setStatusCode(200);
        }
        $vouchCode = VouchCode::where('vouch_code', $request->vouch_code)->first();
        if (!empty($vouchCode)) {
            $today = Carbon::now()->format('Y-m-d');
            if ($today <= $vouchCode->expeiry_date) {
                $bidData = Bid::find($request->bid_id);
                $bidData->is_paid = 1;
                $bidData->vouch_code = $request->vouch_code;
                $bidData->pay_via = 2;
                $bidData->save();

                return response()
                    ->json(['status' => 1, 'message' => "This opportunity is now listed for Bids."])
                    ->setStatusCode(200);
            } else {
                return response()->json(['status' => 0, 'message' => "Vouch code Expried"])
                    ->setStatusCode(200);
            }

        } else {
            return response()->json(['status' => 0, 'message' => "Vouch code doesn't Exist"])
                ->setStatusCode(200);
        }
    }

    public function uniquiShareId($id)
    {
        return md5(uniqid(rand() . $id, true));
    }

    public function addBidResponse(Request $request)
    {
        $rules = [
            'bid_id' => 'required',
            'description' => 'required',
            'portfolio_link' => 'required',
        ];
        $messsages = [
            'bid_id.required' => 'Select any bid for response',
            'description.required' => 'Enter Description',
            'portfolio_link.required' => 'Enter Portfolio Link',

        ];
        $validator = Validator::make($request->all(), $rules, $messsages);
        if ($validator->fails()) {
            return $this->validationErrors($validator)->setStatusCode(200);
        }
        $bidData = [
            'respond_user_id' => Auth::user()->id,
            'bid_id' => $request->bid_id,
            'description' => $request->description,
            'portfolio_link' => $request->portfolio_link,
//            'bid_start_date'=>date('Y-m-d H:i:s'),
        ];
        $user = User::find(Auth::user()->id);
        $user->free_response = $user->free_response + 1;
        $user->is_paid = 0;
        $user->save();
        $bidDetail = Bid::with('bider')->where('id', $request->bid_id)->first();
        $userDetails = User::find($bidDetail->user_id);
        $url = url('bid-response/') . '/' . base64_encode($bidDetail->id);
        $linkName = '<a href="' . $url . '">Click here</a>';
        $message = "Your opportunity received a bid, please " . $linkName . " to view the details.";
        CommonHelper::sendNotification($userDetails, $message, $url);
//        if (! empty($bidDetail->bider)) {
//
//            $smsdata = [
//                'to' => 'bhalani.akashb@gmail.com',
//                'subject' => "Bid Response at Sponsorr",
//                'message' => "There has been activity on your bids, please check it.",
//            ];
//            $path = 'mail/template';
//            //$send_mail = send_mail($smsdata);
//            $data = ['to' => $bidDetail->bider->email,
//                'from' => env('MAIL_USERNAME'),
//                'reply_to' => env('MAIL_USERNAME'),
//                'from_name' => '',
//                'subject' => "Bid Response at Sponsorr",
//                'message' => "There has been activity on your bids, please check it.",
//                'path' => $path];
//
//            Mail::send('/mail/template', ['data' => $data], function ($m) use ($data) {
//                $m->to($data['to'])->subject("Bid Response at Sponsorr")->getSwiftMessage()
//                    ->getHeaders()
//                    ->addTextHeader('x-mailgun-native-send', 'true');
//            });
//            $bidDetail->next_at = Carbon::tomorrow();
//            $bidDetail->save();
//        }

        $response = ResponseBid::create($bidData);
        if ($response) {
            return $this->successResponse("Bid response Has been Added.");
        } else {
            return $this->failResponse("Error Occured!Please try again later")->setStatusCode(200);
        }
    }

    public function cronForDailyMail()
    {
        echo "testsetsetset";
        $bids = Bid::with('bider')->where('next_at', Carbon::now()->format('Y-m-d'))->get();
        if (!empty($bids->first())) {
            foreach ($bids as $bid) {
                $smsdata = [
                    'to' => $bid->bider->email,
                    'subject' => "Bid Response at Ayojn",
                    'message' => "There has been activity on your bids, please check it.",
                ];
                $send_mail = send_mail($smsdata);

                $bid->next_at = Carbon::tomorrow();
                $bid->save();
            }
        }
    }

    public function changeBidStatus(Request $request)
    {
        if ($request->status == 'On') {
            $status = 'Off';
        } else {
            $status = 'On';
        }
        $bid = Bid::find($request->id);

        $bid->status = $status;
        $bid->save();
        if ($bid) {
            return $this->successResponse("Bid status Has been Changed.");
        } else {
            return $this->failResponse("Error Occured!Please try again later")->setStatusCode(200);
        }
    }

    public function editNewBid(Request $request)
    {
        $bid = Bid::with('bidSpecify')->where('id', $request->id)->first();

        return response()->json(['bid' => $bid, 'status' => 1]);
    }

    public function updateNewBid(Request $request)
    {
        $rules = [
            'status' => 'required',
            'sponsorr_type_bid' => 'required',
            //'specify_bid' => 'required',
            'country_bid' => 'required',
            'industry_bid' => 'required',
            'budget_bid' => 'required',

        ];
        $messsages = [
            'status.required' => 'Select Status',
            'sponsorr_type_bid.required' => 'Select Sponsor For',
            //'specify_bid.required' => 'Select Specify',
            'country_bid.required' => 'Select Country for Bid',
            'industry_bid.required' => 'Select Industry',
            'budget_bid.required' => 'Select budget of Bid',
        ];
        $validator = Validator::make($request->all(), $rules, $messsages);
        if ($validator->fails()) {
            return $this->validationErrors($validator)->setStatusCode(200);
        }
        $bid = Bid::find((int)$request->bidid);
        $bid->sponsor_for = $request->sponsorr_type_bid;
        $bid->sponsor_budget = $request->budget_bid;
        $bid->sponsor_industry = $request->industry_bid;
        $bid->sponsor_country = $request->country_bid;
        $bid->city = $request->city_bid;
        $bid->contacted_by = $request->contacted_by;
        $bid->identity = $request->identity_bid;
        $bid->status = $request->status;
        $bid->save();
        if (isset($request->specify_bid) && !empty($request->specify_bid)) {
            SponsorrSpecifyBid::where('bid_id', $bid->id)->forceDelete();
            foreach ($request->specify_bid as $sponsor_specify) {
                $specifyUser_list = [
                    'specify_name' => $sponsor_specify,
                    'user_id' => Auth::user()->id,
                    'bid_id' => $bid->id
                ];

                $specifyUser = SponsorrSpecifyBid::create($specifyUser_list);
            }
        }
        if ($bid) {
            return $this->successResponse("Bid Has been Updated.");
        } else {
            return $this->failResponse("Error Occured!Please try again later")->setStatusCode(200);
        }
    }

    public function Offers()
    {
        $offers = Offer::with('industry')->where('status', 'On')->where('admin_status', 1);
        if (Auth::user()->sponsor_type == 1) {
            $offers = $offers->where(function ($query) {
                $query->where('offer_for', '=', 'Clients')
                    ->orWhere('offer_for', '=', 'Both');
            });
        } else {
            $offers = $offers->where(function ($query) {
                $query->where('offer_for', '=', 'Agencies')
                    ->orWhere('offer_for', '=', 'Both');
            });
        }

        $offers = $offers->get();

        return view('user.offers', compact('offers'));
    }


    //add by ram 24 sept add cart
    public function addToCart($id)
    {
        $offer = Offer::with('industry')->findOrFail($id);

        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        }  else {
            $cart[$id] = [
                "id" => $offer->id,
                'identity' => $offer->identity,
                'industry' =>(!empty($offer->industry) ? $offer->industry->name :'-'),
                "title" => $offer->title,
                'discount'=>$offer->discount,
                'deal_amount' =>$offer->deal_amount,
                'country_name'=>$offer->country->country_name,
                'weblink' =>$offer->weblink,
                'notification_email' => $offer->notification_email,
                "quantity" => 1
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Offer add to cart successfully!');
    }

    public function update(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart successfully updated!');
        }
    }

    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product successfully removed!');
        }
    }

    public function cart()
    {
         return view('user.cart',array('rstorder'=>0));
          
    }

    public function checkout(Request $request)
    {
        
        $carts = session('cart');
        if($carts)
        {
            $pay_hidden = $request->post('pay_hidden');
            $usewallet = $request->post('walletamt_hidden');
            $wallet_balance = $request->post('wallet_balance')??'0';
            $wallet_use = $request->post('wallet_use');
            $paidamt = $request->post('paidamt_hidden');
            $voucher_code = $request->post('voucher_code_new'); 
            $data = array(
                'user_id'=>Auth::user()->id, 
                'pay_amt'=>$pay_hidden, 
                'wallet' => $wallet_use??0,
                'total_amt'=>$paidamt);
            $rstorder = DB::table('offers_order')->insertGetId($data);
            
            if($rstorder)
            {
                foreach ($carts as $key => $cart) 
                {
                    $finalamt = $cart['deal_amount']*$cart['quantity'];
                    $items = array('order_id'=>$rstorder,'offer_id'=>$cart['id'],'offer_amt'=>$cart['deal_amount'],'qty'=>$cart['quantity'],'final_amt'=>$finalamt);
                    $rstitem = DB::table('offers_order_item')->insert($items);
                    
                  

                   /* $path = 'mail/template';
                    $data = ['to' => "rambthm376@gmail.com",
                        'from' => env('MAIL_USERNAME'),
                        'reply_to' => env('MAIL_USERNAME'),
                        'from_name' => '',
                        'subject' => "Bid Response at Sponsorr",
                        'message' => "There has been activity on your bids, please check it.",
                        'path' => $path];

                    Mail::send('/mail/template', ['data' => $data], function ($m) use ($data) {
                        $m->to($data['to'])->subject("Bid Response at Sponsorr")->getSwiftMessage()
                            ->getHeaders()
                            ->addTextHeader('x-mailgun-native-send', 'true');
                    });*/
                    



                }
    
                if($wallet_use > 0)
                {
                    $insarray = array(
                        'user_id'=>Auth::user()->id,
                        'points_by'=>2,
                        'trans_id'=>$rstorder,
                        'point'=>$wallet_use,
                        'point_type'=>'DR',
                        'created_at'=>now()
                    );
                    DB::table('wallet_logs')->insert($insarray);
                    $walletupdate = DB::table('users')->where('id',Auth::user()->id)->update(array('wallet_balance'=>DB::raw("wallet_balance - $wallet_use")));
        
                }

                if($voucher_code != '')
                {
                    DB::table('vouch_codes')->where('vouch_code',$voucher_code)->update(array('used_by'=>Auth::user()->id,'status'=>1));
                    $flag = 1;
                }
    
                $request->session()->forget('cart');
                return view('user.cart',array('rstorder'=>$rstorder));
    
            }
            else{
    
                $request->session()->forget('cart');
                return view('user.cart',array('rstorder'=>0));
            }
    
        }
        else{
            $request->session()->forget('cart');
            return view('user.cart',array('rstorder'=>0));
        }

    }

    //add by ram 7 jan 2024
    public function payOportunity(Request $request)
    {

        $bidId = $request->bidId;

        $wallet = $request->wallet;

        $userid = Auth::user()->id;

        $amt = $request->amt;

        $voucher_code = $request->voucher_code;
       
        $flag = 0;

        $bid = Bid::find($bidId);

        $bid->is_paid = 1;

        $bid->save();

        if($bid->save())
        {
            if($wallet > 0)
            {
                $walletupdate = DB::table('users')->where('id',$userid)->update(array('wallet_balance'=>DB::raw("wallet_balance - $wallet")));
                $insarray = array('user_id'=>$userid,'points_by'=>1,'trans_id'=>$bidId,'point'=>$wallet,'point_type'=>'DR','created_at'=>now());
                DB::table('wallet_logs')->insert($insarray);
                $flag = 1;
            }
    
            if($voucher_code != '')
            {
                DB::table('vouch_codes')->where('vouch_code',$voucher_code)->update(array('used_by'=>$userid,'status'=>1));
                $flag = 1;
            }
    
    
            if($amt>0)
            {
                $per = DB::table('bids')->where('id',$bidId)->value('per');
                if($per>0){$rate = $per;}else{$rate = '10';}
        
                $wallet_amt = round($amt*$rate/100,0);
                $walletupdate = DB::table('users')->where('id',$userid)->update(array('wallet_balance'=>DB::raw("wallet_balance + $wallet_amt")));
                $insarray = array('user_id'=>$userid,'points_by'=>1,'trans_id'=>$bidId,'point'=>$wallet_amt,'point_type'=>'CR','created_at'=>now());
                DB::table('wallet_logs')->insert($insarray);
                $flag = 1;
            }
           
        }

        return $flag;

    }



    //add by ram for paynow button 21 sep 2023  ---- update function 07 jan 2024
    public function payNow(Request $request)
    {
        $bidId = $request->bidId;

        $wallet = $request->wallet;

        $bid_close_amount = $request->bid_close_amount;

        $userid = Auth::user()->id;

        $amt = $request->amt;

        $voucher_code = $request->voucher_code;

        $bids = \App\ResponseBid::with(['bid', 'userDetail', 'userDetail.country_name'])->where('id', $bidId)->first();

            if ($bids->is_accepted = 3) {
                $bids->is_accepted = 4;
                $bids->bid_close_amount = $bid_close_amount;
                $bids->save();
            }

            $flag = 0;

            if($bids->save())
            {
                if($wallet > 0)
                {
                    $walletupdate = DB::table('users')->where('id',$userid)->update(array('wallet_balance'=>DB::raw("wallet_balance - $wallet")));
                    $insarray = array('user_id'=>$userid,'points_by'=>1,'trans_id'=>$bids->bid_id,'point'=>$wallet,'point_type'=>'DR','created_at'=>now());
                    DB::table('wallet_logs')->insert($insarray);
                    $flag = 1;
                }

                if($voucher_code != '')
                {
                   DB::table('vouch_codes')->where('vouch_code',$voucher_code)->update(array('used_by'=>$userid,'status'=>1));
                   $flag = 1;
                }


                $per = DB::table('bids')->where('id',$bids->bid_id)->value('per');
                if($per>0){$rate = $per;}else{$rate = '10';}

                $wallet_amt = round($amt*$rate/100,0);
                $walletupdate = DB::table('users')->where('id',$userid)->update(array('wallet_balance'=>DB::raw("wallet_balance + $wallet_amt")));
                $insarray = array('user_id'=>$userid,'points_by'=>1,'trans_id'=>$bids->bid_id,'point'=>$wallet_amt,'point_type'=>'CR','created_at'=>now());
                DB::table('wallet_logs')->insert($insarray);
                $flag = 1;
             
            }   

        return $flag;
    }

    public function getBidbyid(Request $request, $id)
    {
        $bid_id = ResponseBid::where('id', $id)->value('bid_id');
        $bids = Bid::with(['user','bidResponse'])->where('id',$bid_id)->first();
        $view = view('bid.ram-response', compact('bids'))->render();
        return response()->json(['html' => $view]); 
    }


    public function paymentproofget(Request $request)
    {
        $id = $request->id;
        $file = DB::table('bids')->where('id',$id)->value('payment_proof');
        echo $file;
    }


    public function paymentproof(Request $request)
    {

        if($request->hasFile('payment_proof_img')) {
            $file = $request->file('payment_proof_img'); 

            $ext =  $file->getClientOriginalExtension();

            $allowed_extensions = array("jpg", "jpeg", "png", "pdf", "doc", "docx");
            if(in_array($ext, $allowed_extensions))
            {

                //you also need to keep file extension as well
                $name = "proof_".rand().'.'.$file->getClientOriginalExtension();
                
                //using the array instead of object
                $image['filePath'] = $name;
                $file->move(public_path().'/uploads/', $name);

                $data = array(
                    'payment_proof' => $name
                ); 
                $rst = DB::table('bids')->where('id',$request->proof_bid)->update($data); 
                if($rst)
                {
                    echo json_encode(array("status"=> true));
                } 
           
            }
            else{
                echo json_encode(array("status"=> false));
            }
                  
         }
    }


}
