<?php

namespace App\Http\Controllers\Partner;

use App\Country;
use App\Currency;
use App\Http\Controllers\Controller;
use App\Offer;
use App\Traits\ApiResponse;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Helpers\CommonHelper;

class UserController extends Controller
{
    use ApiResponse;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        $offers = Offer::with('industry')->where('partner_id', Auth::user()->id);

        if ($request->query('f')) {
            $offers = $offers->where('offer_for', $request->query('f'));
        }
        if ($request->query('c')) {
            $offers = $offers->where('available_in', $request->query('c'));
        }
        if ($request->query('b')) {
            $offers = $offers->where('identity', $request->query('b'));
        }
        if ($request->query('i')) {
            $offers = $offers->where('function', $request->query('i'));
        }
        if ($request->query('cu')) {
            $offers = $offers->where('currency', $request->query('cu'));
        }
        $offers = $offers->get();

        return view('partner.home', compact('offers'));
    }

    public function offer_details(Request $request)
    {

        $offers = Offer::with('industry')->where('partner_id', Auth::user()->id)->where('id',$request->id);

        if ($request->query('f')) {
            $offers = $offers->where('offer_for', $request->query('f'));
        }
        if ($request->query('c')) {
            $offers = $offers->where('available_in', $request->query('c'));
        }
        if ($request->query('b')) {
            $offers = $offers->where('identity', $request->query('b'));
        }
        if ($request->query('i')) {
            $offers = $offers->where('function', $request->query('i'));
        }
        if ($request->query('cu')) {
            $offers = $offers->where('currency', $request->query('cu'));
        }
        $offers = $offers->get();

        $orders = DB::table('offers_order_item')
        ->join('offers_order','offers_order.id', '=', 'offers_order_item.order_id')
        ->join('users','users.id', '=', 'offers_order.user_id')
        ->select('users.*','offers_order.*','offers_order_item.*','offers_order_item.id as mid')
        ->where('offer_id',$request->id)->get();

        return view('partner.offer-details', compact('offers','orders'));
    }

    public function changeOfferUser(Request $request)
    {
        $id = $request->id;
        $status = $request->status;
        $update = DB::table('offers_order_item')->where('id',$id)->update(array('status'=>$status));
        if ($update) {


            if($status==0){               
                    $status = "Pending";
                    $message = "Your Offer Status has been changed ".$status.".";
                }
            elseif($status==1){
            
                $status = "Progress";
                $message = "Your Offer Status has been changed ".$status.".";
            }
            elseif($status==2){
                $status = "Sent";
                $message = "Your Offer Status has been changed ".$status.".";
            }
            elseif($status==3){
                $status = 'Query';
                $message = "Your Offer Status has been changed ".$status.".";
            }
            elseif($status==4){
            
                $status ='Delivered';
                $message = "Thank you! Please sent your feedback.";
            }

            $order_id = DB::table('offers_order_item')->where('id',$id)->value('order_id');
            $user_id = DB::table('offers_order')->where('id',$order_id)->value('user_id');
            $userDetails = User::find($user_id);
            $linkName = '<a href="' . url('marketplace-history') . '">Click here</a>';
           
            $link = url('marketplace-history');
            CommonHelper::sendNotification($userDetails, $message, $link);



            return $this->successResponse("Offer status has been changed.");
        } else {
            return $this->failResponse("Error Occured!Please try again later")->setStatusCode(200);
        }


    }

    public function pending()
    {
        if (! empty(Auth::user()) && Auth::user()->is_edited == 1) {
            return redirect('review');
        }

        if (Auth::user()->userstatus) {
            return redirect('partner/home');
        } else {
            return view('partner.pending');
        }
    }

    public function suspend()
    {
        if (Auth::user()->is_suspend) {
            return view('partner.suspend');
        } else {
            return redirect('partner/home');
        }

    }

    public function updateUserProfile(Request $request)
    {
        $user = Auth::user();
        $alluser = User::where('id', '!=', $user->id)->where('email', $request->useremail_edit)->get();
        if (count($alluser) > 0) {
            $result = [
                'status' => 0,
                'msg' => 'Email Address is already in use'
            ];

            return response()->json($result)->setStatusCode(200);
        }
        $user_id = $user->id;
        $user->edit_count = (int)$user->edit_count + 1;
        $user->email = $request->useremail_edit;
        $user->contact_person = $request->contact_person;
        $user->company_name = $request->edit_company_name;
        $user->phone_no = $request->phone_no_edit;
        $user->userstatus = 0;
        $user->is_edited = 1;
        $user->save();
        $result = [
            'status' => 1,
            'msg' => 'Profile Edited Successfully.'
        ];

        return response()->json($result)->setStatusCode(200);

    }

    public function newOffer()
    {
        $countries = Country::all();
        $Currency = Currency::all();

        return view('partner.add-offer', compact('Currency', 'countries'));
    }

    public function storeOffer(Request $request)
    {
        $rules = [
            'offer_for' => 'required',
            'partner_identity' => 'required',
            'function' => 'required',
            'title' => 'required',
            'available_in' => 'required',
            'currency' => 'required',
            'deal_amount' => 'required',
            'incentive' => 'required',
            'discount' => 'required',
            'weblink' => 'required',
            'notification_email' => 'required',
        ];
        $messsages = [
            'offer_for' => 'Please select offer for',
            'partner_identity' => 'Please select identity',
            'function' => 'Please select function',
            'title' => 'Please enter title',
            'available_in' => 'Please select country',
            'currency' => 'Please select currency',
            'deal_amount' => 'Please enter deal amount',
            'incentive' => 'Please enter Ayojn incentive',
            'discount' => 'Please enter discount',
            'weblink' => 'Please enter weblink',
            'notification_email' => 'Please enter Email for Notification',
        ];
        $validator = Validator::make($request->all(), $rules, $messsages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors->first());
        }
        $offerData = [
            'partner_id' => Auth::user()->id,
            'offerred_by' => Auth::user()->company_name,
            'offer_for' => $request->offer_for,
            'identity' => $request->partner_identity,
            'function' => $request->function,
            'title' => $request->title,
            'available_in' => $request->available_in,
            'currency' => $request->currency,
            'deal_amount' => $request->deal_amount,
            'incentive' => $request->incentive,
            'discount' => $request->discount,
            'weblink' => $request->weblink,
            'notification_email' => $request->notification_email,
            'status' => "On"
        ];


        
        $orderresponse = Offer::create($offerData);
        $orderresponse->share_id = $this->uniquiShareId($orderresponse->id);
        $orderresponse->save();
        if (! empty($orderresponse)) {
            return redirect('partner/home')->with('success', 'offer successfully created');
        } else {
            return redirect()->back()->withErrors('Something went wrong');
        }
    }

    public function changeOfferStatus(Request $request)
    {
        if ($request->status == 'On') {
            $status = 'Off';
        } else {
            $status = 'On';
        }
        $offer = Offer::find($request->id);

        $offer->status = $status;

        $offer->save();
        if ($offer) {
            return $this->successResponse("Offer status has been changed.");
        } else {
            return $this->failResponse("Error Occured!Please try again later")->setStatusCode(200);
        }
    }

    public function uniquiShareId($id)
    {
        return md5(uniqid(rand() . $id, true));
    }

    public function shareOffer($id)
    {
        $offer = Offer::where('share_id', $id)->where('status', 'On')->first();
        session()->flash('url.intended', '/' . request()->path());

        return view('partner.share-offer', compact('offer'));
    }

}
