<?php

namespace App\Http\Controllers\UserAuth;

use App\Http\Controllers\Controller;
use App\Models\NotificationSetting;
use App\User;
use DB;
use App\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    //
    public function getNotificationSettings(Request $request)
    {
        $notificationData = NotificationSetting::where('user_id', Auth::user()->id)->first();

        return view('notification-setting', compact('notificationData'));
    }

    public function updateNotificationSettings(Request $request)
    {
//        dd($request->all());
        $notificationData = NotificationSetting::where('id', $request->id)->first();
        if (! empty($notificationData)) {
            if(!empty($request->inApp) && $request->inApp == 1){
                $notificationData->inapp = 1;
            }else{
                $notificationData->inapp = 0;
            }
            if(!empty($request->emailNotification) && $request->emailNotification == 1){
                $notificationData->email = 1;
                $notificationData->days = $request->days;
            }else{
                $notificationData->email = 0;
                $notificationData->days = '';
            }
            $notificationData->save();
            return redirect()->back()->with('success', 'Notification settings successfully updated');
        } else {
            return redirect()->back()->withErrors("Notification Data not found");
        }
    }

    public function exitingUser()
    {
        $users = User::get();
        foreach ($users as $user) {
            $notifications = new NotificationSetting();
            $notifications->user_id = $user->id;
            $notifications->inapp = 1;
            $notifications->save();
        }
    }


    public function getwallet(Request $request)
    {
       
        $logs = DB::table("wallet_logs")->where('user_id',Auth::user()->id)->get();
        $fieldset ="<table class='table_id display table table-bordered'><thead><th>ID</th><th>Transaction By</th><th>Point</th><th>Direction</th><th>Transaction Date</th></thead>";
        $y=1;
        foreach ($logs as $key => $log) 
        {
           if($log->point_type=="DR"){$ptype="<span class='badge badge-danger' style='background-color:#dc3545;'><i class='fa fa-minus'></i></span> Out";}
           if($log->point_type=="CR"){$ptype="<span class='badge badge-success' style='background-color:#28a745;'><i class='fa fa-plus'></i></span> In";} 
           
           $tras_by = "";
           $id = base64_encode($log->trans_id);
           if($log->points_by ==1){$tras_by = "Oppotunity Payment"." <a href='".url('bid-response',$id)."'>click to view</a>";}
           if($log->points_by ==2){$tras_by = "MarketPlace Redreem"." <a href='".url('marketplace-history')."'>click to view</a>";}
           if($log->points_by ==3){$tras_by = "Other user oppotunity payment"." <a href='".url('vouches',$log->trans_id)."'>click to view</a>";}
           
           $fieldset .= "<tr>
                <td>ewallet-$y</td>
                <td>$tras_by</td>
                <td>$log->point</td>
                <td>$ptype</td>
                <td>".date('d M, Y, H:i',strtotime($log->created_at))."</td>
               
                </tr>";
            $y++;    

        }
        $fieldset .= "</table>";
        return view('wallet-log', compact('fieldset'));
    }

    public function getmarketplace(Request $request)
    {
        $fieldset = "";
        $orders = DB::table("offers_order")->where('user_id',Auth::user()->id)->get();
        $x=1;
        foreach($orders as $order)
        {
            
            $items = DB::table("offers_order_item")->where('order_id',$order->id)->get();
            $y=1;
            $table ="<table class='table_id display table table-bordered'><thead><th>Sr.</th><th>Deal Type</th><th>Deal Name</th><th>Currency</th><th>Available In</th><th>Quantity</th><th>Deal Amount</th><th>Paid Amount</th><th>Weblink</th><th>Status</th></thead>";    
            foreach ($items as $key => $item) 
            {

            if($item->status==0){
                                
                    $status = "Pending";
                }
            elseif($item->status==1){
          
                $status = "Progress";
            }
            elseif($item->status==2){
                $status = "Sent ".'<a class="btn btn-danger query_button" title="query"><i class="fa fa-question-circle"></i></a>';
            }
            elseif($item->status==3){
                $status = 'Query <a class="btn btn-danger query_button" title="query"><i class="fa fa-question-circle"></i></a>';
            }
            elseif($item->status==4){
         
                $status ='<a data-id="'.$item->id.'" class="btn btn-danger query_button" title="query"><i class="fa fa-question-circle"></i></a>
                <a data-id="'.$item->id.'" class="btn btn-success feedback_button" title="Feedback"><i class="fa fa-comments"></i></a>';
            }
            elseif($item->status==5){
               
               $status ='<a data-id="'.$item->id.'" class="btn btn-danger query_button" title="query"><i class="fa fa-question-circle"></i></a>
                <a data-id="'.$item->id.'" class="btn btn-success feedback_button" title="Feedback"><i class="fa fa-comments"></i></a>';
            }


                $offers = Offer::with('industry')->where('id', $item->offer_id)->first();
                $table .= "<tr>
                <td>$y</td>
                <td>$offers->identity</td>
                <td>$offers->title</td>
                <td>$offers->currency</td>
                <td>$offers->available_in</td>
                <td>$item->qty</td>
                <td>$item->offer_amt</td>
                <td>$item->final_amt</td>
                <td><a href='$offers->weblink'>Click here</a></td>
                <td>$status</td>
                </tr>";
                
                $y++;
            }
            $table .="</table>";  

            $fieldset .= "<fieldset><legend> <span class='pull-right'>Date: $order->created_at</span> Wallet used:$order->wallet</legend>
            $table
            </fieldset>";

            
            $x++;  
        }

        
        

       // $table = DB::table("offers_order_item")->get();
        //$notificationData = NotificationSetting::where('user_id', Auth::user()->id)->first();

        return view('marketplace-history', compact('fieldset'));
    }


    public function feedback_store(Request $request)
    {
        $feedback = $request->feedback;
        $rating = $request->rating;
        $offer_item_id = $request->offer_item_id;
        $user_id = $request->user_id;

        $data = array('feedback'=>$feedback, 'rating'=>$rating, 'offer_item_id'=> $offer_item_id, 'user_id'=>$user_id);
        $rst = DB::table('offers_order_item_feedback')->insert($data);
        if($rst){
            echo "Your Feedback Save Successfully";
        }
        else{
            echo "Something went wrong";
        }
    }
    

    public function show_feedback(Request $request)
    {
        $id = $request->id;
        $result = DB::table("offers_order_item_feedback")->where('offer_item_id',$id)->get();
        echo json_encode($result);
    }

    public function show_payment(Request $request)
    {
        $id = $request->id;
        $result = DB::table("offers_order_item")->where('id',$id)->where('status','5')->get();
        echo json_encode($result);
    }

    public function store_payment(Request $request)
    {
        $id = $request->id;
        $date = $request->date;
        $remark = $request->remark;
       
        $data = array('payment_remark'=>$remark, 'appove_date'=>$date, 'status'=>5);
        $rst = DB::table('offers_order_item')->where('id',$id)->update($data);
        if($rst){
            echo "Your Payment Details Save Successfully";
        }
        else{
            echo "Something went wrong";
        }
    }


}
