<?php

namespace App\Http\Controllers\UserAuth;

use App\Bid;
use App\Country;
use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\UniqueOpportunity;
use App\Offer;
use App\Opportunity;
use App\OpportunityUser;
use App\Traits\ApiResponse;
use App\User;
use App\Vouche;
use App\VouchUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Mail;
use DB;

class OppertunityController extends Controller
{

    use ApiResponse;


    public function index(Request $request)
    {
        //  dd(Auth::user()->sponsor_type);
        if (Auth::user()->sponsor_type == 1) {

            $uniqueOpportunity = UniqueOpportunity::pluck('opportunity_id')->toArray();
            $bids = Opportunity::with(['industry', 'country_name', 'opportunityUser', 'vouchResponse' => function ($query) {
                $query->where("offer_id", Auth::user()->id);
            }
            ])->whereIn('id', $uniqueOpportunity);
//            dd($bids->get());

            if ($request->query('f')) {
                $bids = $bids->where('hashtag', 'like', '%' . $request->query('f') . '%');
            }
            if ($request->query('c')) {
                $bids = $bids->where('country_code', 'like', $request->query('c'));
            }
            if ($request->query('city')) {
                $bids = $bids->where('opportunity_city', 'like', $request->query('city'));
            }
//            if ($request->query('b')) {
//                $bids = $bids->whereHas('vouchesResponse', function ($query) use ($request) {
//                    $query->where('vouch_value', 'like', '%' . $request->query('b') . '%');
//                });
//            }
            if ($request->query('i')) {
                $bids = $bids->where('industry_id', 'like', $request->query('i'));
            }
            $bids = $bids->where('status', 1)->get();

            //  dd($bids);

            return view('opportunity.lunched-opportunity', compact('bids'));
        } else if (Auth::user()->sponsor_type == 2) {
            if ($request->query('f')) {
                $bids = Opportunity::whereHas('OpportunityMapping', function ($query) use ($request) {
                    $query->where('user_id', Auth::user()->id)
                        ->where('hashtag', 'like', '%' . $request->query('f') . '%');
                })->with(['industry', 'country_name', 'opportunityUser', 'vouchesResponse']);
            } else {
                $bids = Opportunity::whereHas('OpportunityMapping', function ($query) {
                    $query->where('user_id', Auth::user()->id);
                })->with(['industry', 'country_name', 'opportunityUser', 'vouchesResponse']);
            }
            if ($request->query('c')) {
                $bids = $bids->where('country_code', 'like', $request->query('c'));
            }
            if ($request->query('i')) {
                $bids = $bids->where('industry_id', 'like', $request->query('i'));
            }
            if ($request->query('b')) {
                $bids = $bids->whereHas('vouchesResponse', function ($query) use ($request) {
                    $query->where('vouch_value', 'like', '%' . $request->query('b') . '%');
                });
            }
            $bids = $bids->get();

            return view('opportunity.opportunity-list', compact('bids'));
        }
    }

    public function OpportunityStatus(Request $request)
    {
        if ($request->status == 'On') {
            $status = 'Off';
        } else {
            $status = 'On';
        }
        $bid = Vouche::find($request->id);

        $bid->is_active = $status;
        $bid->save();
        if ($bid) {
            return $this->successResponse("Vouch status Has been Changed.");
        } else {
            return $this->failResponse("Error Occured!Please try again later")->setStatusCode(200);
        }
    }

    public function myResponse(Request $request)
    {

        $bids = Vouche::with(['opportunity'])
            ->where('offer_id', Auth::user()->id)->get();

        return view('opportunity.my-vouches', compact('bids'));
    }

    public function vouchList(Request $request, $id)
    {

        $vouchLists = Vouche::with(['opportunity', 'VouchUser'])->where('opportunity_id', $id);
        $vouchLists = $vouchLists->get();
        $identity = Auth::user()->identity;

        $opportunityData = Opportunity::find($id);

        return view('opportunity.vouch-response-list', compact('vouchLists', 'opportunityData', 'identity'));
    }

    public function vouchListExport(Request $request, $id)
    {
        $records = Vouche::with(['opportunity', 'userDetail'])->where('opportunity_id', $id)->get()->toArray();

        foreach ($records as $key => $record) {
            $data[$key]['Vouch Id'] = "#" . $record['id'];
            $data[$key]['Vouch Value'] = $record['vouch_value'];
            if ($record['vouch_contacted'] == "Mobile") {
                $data[$key]['Email'] = "";
                $data[$key]['Mobile'] = $record['user_detail']['phone_no'];
            } else if ($record['vouch_contacted'] == "Email") {
                $data[$key]['Email'] = $record['user_detail']['email'];
                $data[$key]['Mobile'] = '';
            } else {
                $data[$key]['Email'] = $record['user_detail']['email'];
                $data[$key]['Mobile'] = $record['user_detail']['phone_no'];
            }
        }

        $opportunityData = Opportunity::find($id);

        return Excel::create($opportunityData->hashtag, function ($excel) use ($data) {
            $excel->sheet('mySheet', function ($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->download('xlsx');
    }


    public function updateVouch(Request $request, $id)
    {
        $vouchData = VouchUser::find($id);
        $vData = Vouche::where('id', $vouchData->vouches_id)->first();
        $userDetails = User::where('id', $vData->offer_id)->first();

        if ($vData->is_active == "On") {
            $vouchData->status = 2;
            $vouchData->save();

            $vData->status = 2;
            $vData->save();
            $linkName = '<a href="' . url('my-vouches') . '">Click here</a>';
            $message = "Your vouch is accepted by the opportunity holder. Please " . $linkName . " to watch their contact details";
            $link = url('my-vouches');
            CommonHelper::sendNotification($userDetails, $message, $link);

            return redirect('vouches/' . $vData->opportunity_id);
        } else {
            return redirect()->back()->with('success_messagesss', '');
        }

    }

    public function buildOpportunity()
    {
        return view('opportunity.build-opportunity');
    }

    public function getHashtags(Request $request)
    {
        $hashTags = Opportunity::where('country_code', $request->countryId)->where('industry_id', $request->industryId)
            ->where('opportunity_city', $request->opportunity_city)
            ->get();
        $hashs = '';
        $hashArrays = [];
        if (! empty($hashTags->first())) {
            foreach ($hashTags as $hash) {
                $hashArrays[] = ltrim($hash->hashtag, '#');

            }
            if (! empty($hashArrays)) {
                $hashs = implode(',', $hashArrays);
            }
        }

        return response()->json(['hashTags' => $hashs]);
    }

    public function addVouch(Request $request, $id)
    {
        $opportunityDetail = Opportunity::where('id', $id)->first();
        $opportunities = Opportunity::where('hashtag', $opportunityDetail->hashtag)
            ->where('industry_id', $opportunityDetail->industry_id)->groupBy('country_code')->where('status', 1)->get();
//        dd($opportunities);
        $countries = Country::get();
        $view = view('opportunity.add-vouch',
            compact('opportunityDetail', 'countries', 'opportunities'))->render();

        return response()->json(['html' => $view, 'opportunityData' => $opportunityDetail]);
    }

    public function getCities(Request $request, $id)
    {
        $opportunity = Opportunity::find($id);
        $opportunities = Opportunity::with(['city_name'])->where('hashtag', $opportunity->hashtag)
            ->where('industry_id', $opportunity->industry_id)->where('country_code', $opportunity->country_code)
            ->where('status', 1)->get();

        return $this->jsonResponse('Success', [
            'opportunities' => $opportunities
        ]);
    }

    public function addNewVouch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vouch_value' => "required",
            'vouch_identity' => "required",
            'vouch_city' => "required",
            'vouch_country' => "required",
            'vouch_contacted' => "required",
        ], [
            'vouch_value.required' => "Vouch value is required",
            'vouch_identity.required' => "Identity is required",
            'vouch_city.required' => "City is required",
            'vouch_country.required' => "Country is required",
            'vouch_contacted.required' => "Contact type is required",
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => json_encode($validator->errors()->first())])
                ->setStatusCode(200);
        }
        $opps = Opportunity::find($request->opportunity_id);
        $opportunity = Opportunity::where('opportunity_city', $request->vouch_city)
            ->where('country_code', $request->vouch_country)->where('hashtag', $opps->hashtag)
            ->where('industry_id', $opps->industry_id)->first();
        $data = [
            'offer_id' => Auth::user()->id,
            'opportunity_id' => $opportunity->id,
            'vouch_value' => $request->vouch_value,
            'vouch_identity' => $request->vouch_identity,
            'vouch_city' => $request->vouch_city,
            'vouch_country' => $request->vouch_country,
            'vouch_contacted' => $request->vouch_contacted,
            'status' => 1
        ];
        $user = User::find(Auth::user()->id);
        $user->free_vouch = $user->free_vouch + 1;
        $user->is_paid = 0;
        $user->save();
        $getVouch = Vouche::where('opportunity_id', $opportunity->id)->where('offer_id', Auth::user()->id)->first();
        if (! empty($getVouch)) {
            return response()->json(['status' => 2, 'message' => "You have already vouched this opportunity"])
                ->setStatusCode(200);
        }
        $vouchData = Vouche::create($data);
        $opportunityUser = OpportunityUser::where('opportunity_id', $opportunity->id)->get();
        if (! empty($opportunityUser)) {
            foreach ($opportunityUser as $oUser) {
                $userDetail = User::find($oUser->user_id);
                if (! empty($userDetail)) {
                    $path = 'mail/template';
                    //$send_mail = send_mail($smsdata);
                    $data = ['to' => $userDetail->email,
                        'from' => env('MAIL_USERNAME'),
                        'reply_to' => env('MAIL_USERNAME'),
                        'from_name' => '',
                        'subject' => "Vouched Response at Ayojn",
                        'message' => "There has been activity at the opportunity you created. Please check it.<br>See you at <a href='https://ayojn.com'>Sponsorr.Co</a>",
                        'path' => $path];

//                    Mail::send('/mail/template', ['data' => $data], function ($m) use ($data) {
//                        $m->to($data['to'])->subject("Vouched Response at Sponsorr")->getSwiftMessage()
//                            ->getHeaders()
//                            ->addTextHeader('x-mailgun-native-send', 'true');
//                    });
                }
                VouchUser::create(['offer_id' => $oUser->user_id, 'vouches_id' => $vouchData->id, 'status' => 1]);
            }
        }
        if (! empty($vouchData)) {
            return response()->json(['status' => 1, 'message' => "Vouche has been successfully added"])
                ->setStatusCode(200);
        } else {
            return response()->json(['status' => 0, 'message' => "Vouche has been not added"])->setStatusCode(200);
        }

    }

    public function addNewOpportunity(Request $request)
    {
        //$i = 1;

        $validator = Validator::make($request->all(), [
            'opportunity_country' => "required",
            'opportunity_city' => "required",
            'opportunity_industry' => "required",
            'hashtags' => "required",
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('error_contact', 'Please fill all fields data')
                ->withInput();
        }
        $hashTags = preg_replace("/[^a-zA-Z0-9\s]/", "",
            str_replace(' ', '', $request->hashtags));
        $existHashTags = Opportunity::where('hashtag', '#' . $hashTags)
            ->where('country_code', $request->opportunity_country)->where('industry_id', $request->opportunity_industry)
            ->where('opportunity_city', $request->opportunity_city)
            ->first();
        $getSamehashTag = Opportunity::where('hashtag', '#' . $hashTags)
            ->where('industry_id', $request->opportunity_industry)->first();
        if (empty($existHashTags)) {
            $data = [
                'receiver_id' => Auth::user()->id,
                'hashtag' => "#" . preg_replace("/[^a-zA-Z0-9\s]/", "",
                        str_replace(' ', '', $request->hashtags)),
                'country_code' => $request->opportunity_country,
                'opportunity_city' => $request->opportunity_city,
                'industry_id' => $request->opportunity_industry,
            ];
            $existHashTags = Opportunity::create($data);
            $existHashTags->share_id = $this->uniquiShareId($existHashTags->id);
            $existHashTags->save();
        }
        if (empty($getSamehashTag)) {
            UniqueOpportunity::create(['opportunity_id' => $existHashTags->id]);

        }
        $opportunityUser = [
            'opportunity_id' => $existHashTags->id,
            'user_id' => Auth::user()->id
        ];
        $existingOppUserData = OpportunityUser::where($opportunityUser)->first();
        if (empty($existingOppUserData)) {
            $opportunityData = OpportunityUser::create($opportunityUser);
        }


        return redirect()->back()->with('success_messagesss', 'You are successfully added opportunity');


    }

    public function uniquiShareId($id)
    {
        return md5(uniqid(rand() . $id, true));
    }

    public function shareIdStore()
    {
        $opportunity = Bid::get();
        if (! empty($opportunity)) {
            foreach ($opportunity as $o) {
                $o->share_id = $this->uniquiShareId($o->id);
                $o->save();
            }
        }

        $opportunity = Opportunity::get();
        if (! empty($opportunity)) {
            foreach ($opportunity as $o) {
                $o->share_id = $this->uniquiShareId($o->id);
                $o->save();
            }
        }
    }

    public function shareBid(Request $request, $id)
    {
        $bidData = Opportunity::with(['industry', 'country_name', 'opportunityUser'])->where('share_id', $id)
            ->where('status', 1)->first();
        if (! empty($bidData)) {
            session()->flash('url.intended', '/' . request()->path());

            return view('opportunity.share-opportunity', compact('bidData'));
        } else {
            return view('bid.datanotfound');
        }
    }

    public function shareOffer($id)
    {
        $offer = Offer::where('share_id', $id)->where('status', 'On')->where('admin_status', 1)->first();
        session()->flash('url.intended', '/' . request()->path());

        return view('partner.share-offer', compact('offer'));
    }

    public function check_vouch_code(Request $request)
    {
        $code = $request->code;
        $rst = DB::table('vouch_codes')->where('vouch_code',$code)->where('status',0)->value('vouch_amount');
        if($rst>0)
        {
            return $rst;
        }
        else{
            return 0;
        }
        

    }


     //add by ram for paynow button 21 sep 2023
     public function paynow_vouch(Request $request)
     {
         $opid = $request->opid;

         $vid = $request->vid;
 
         $wallet = $request->wallet;
 
         $userid = Auth::user()->id;
 
         $amt = $request->amt;

         $voucher_code = $request->voucher_code;

         $flag = 0;

         $update = Opportunity::where('id',$opid)->update(array('status'=>2));

         if($update)
         {
            if($wallet > 0)
            {
               $walletupdate = DB::table('users')->where('id',$userid)->update(array('wallet_balance'=>DB::raw("wallet_balance - $wallet")));
               $insarray = array('user_id'=>$userid,'points_by'=>3,'trans_id'=>$vid,'point'=>$wallet,'point_type'=>'DR','created_at'=>now());
               DB::table('wallet_logs')->insert($insarray);
               $flag = 1;
            }
   
            if($voucher_code != '')
            {
               DB::table('vouch_codes')->where('vouch_code',$voucher_code)->update(array('used_by'=>$userid,'status'=>1));
               $flag = 1;
            }
         }
 
        
           
       
             
 
         return $flag;
     }
 

}
