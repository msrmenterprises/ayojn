<?php

namespace App\Http\Controllers\ControlpanelAuth;

use App\Http\Controllers\Controller;
use App\Offer;
use App\SponsorrSpecify;
use App\SponsorrSpecifyList;
use App\User;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mail;

class PartnerController extends Controller
{
    public function partner()
    {
        return view('controlpanel.partner.list');
    }

    public function listUser($type = '')
    {
        $user_type = '';

        DB::enableQueryLog();
        DB::statement(DB::raw('set @rownum=0'));
        $userlist = User::select('*', DB::raw('@rownum  := @rownum  + 1 AS rownum'))
            ->where('id', '!=', Auth::user()->id)->where('sponsor_type', '=', 3)
            ->orderBy('id', 'desc')->get();

        return Datatables::of($userlist)
            ->addColumn('check', function ($response) {
                return '<input type="checkbox" name="selected_users[]" value="' . $response->id . '" }}">';
            })
            ->editColumn('email', function ($response) {
                if ($response->disapprove_time != null) {
                    $disapproveDate = date("Y-m-d", strtotime($response->disapprove_time));
                } else {
                    $disapproveDate = '-';
                }

                return $response->email . "<br>Register Date: " . date("Y-m-d",
                        strtotime($response->created_at));

            })
            ->addColumn('specification', function ($response) {
                $getSpecifyList = SponsorrSpecify::where('user_id', $response->id)->get();
                $specifylist = SponsorrSpecifyList::get();
                if (isset($getSpecifyList) && $getSpecifyList != null) {
                    $specifyarray = [];
                    foreach ($getSpecifyList as $userspecify) {
                        foreach ($specifylist as $item) {
                            if ($userspecify->specify_name == $item->id) {
                                $specifyarray[] = @$item->specify_name;
                            }
                        }
                    }

                    return implode(',', $specifyarray);
                } else {
                    return "-";
                }
            })
            ->editColumn('sponsor_industry', function ($response) {
                if ($response->sponsor_industry == 'test' || $response->sponsor_industry == '') {
                    return "-";
                } else {
                    return @$response->industry->name;
                }


            })
            // ->editColumn('sponsor_type', function ($response) {
            //     if ($response->sponsor_type == 1)
            //         return "Offer Sponsorship";
            //     else
            //         return "Manage Or Receive Sponsorship";
            // })

            ->addColumn('refer_by_user', function ($response) {
                //dd($response['country_name']);
                if ($response->refer_by) {
                    return 'Refer By: <br>' . $response->referBy->email;
                } else {
                    return 'Self Registered';
                }
            })
            ->addColumn('referral_count', function ($response) {
                //dd($response['country_name']);
                //$referral_count = ReferAFriend::where('user_id', $response->id)->count();
                $referral_count = User::where('refer_by', $response->id)->count();

                return $referral_count;
            })
            ->editColumn('userstatus', function ($response) {
                $cust_id = "cust_id";
                if ($response->email_verified != 1) {
                    $html = '<a  href="javascript:void(0)"><span class="label label-warning" id="cust_id' . $response->id . '"  >Not Verify</span></a>';
                } else {
                    if ($response->userstatus == 1)
                        $html = '<a  href="javascript:void(0)"  onclick="changeStatus(' . $response->id . ')"><span class="label label-success my_lable_class" id="cust_id' . $response->id . '">Approved</span></a>';
                    else
                        $html = '<a  href="javascript:void(0)"   onclick="changeStatus(' . $response->id . ')"><span class="label label-danger my_lable_class" id="cust_id' . $response->id . '"  >Disapproved</span></a>';
                }
                if ($response->is_suspend == 0) {
                    $suspend = '<a  href="javascript:void(0)"   onclick="userChangeStatusSuspendWithComment(' . $response->id . ')"><span class="label label-danger my_lable_class" id="user_id' . $response->id . '"  >Suspend</span></a>';
                } else {
                    $suspend = '<a  href="javascript:void(0)"   onclick="changeSuspendStatus(' . $response->id . ')"><span class="label label-danger my_lable_class" id="user_id' . $response->id . '"  >Suspended</span></a>';
                }

                return $html . '<br>' . $suspend;
            })
            ->addColumn('action', function ($userlist) {
                $edit = '<a href="' . url('controlpanel/editusers/' . $userlist->id) . '" title="Edit" class="btn btn-sm btn-primary pull-left"><i class="fa fa-edit"></i></a>';
                $usertype = '<a href="' . url('controlpanel/edituser-type/' . $userlist->id) . '" title="Edit Usertype" class="btn btn-sm btn-warning pull-left"><i class="fa fa-exchange"></i></a>';
                $delete = '<a href="javascript:void(0)" title="Delete" class="btn btn-sm btn-danger pull-left" onclick="deleteUser(' . $userlist->id . ')"><i class="fa fa-remove"></i></a>';

                return $edit . $delete;
            })
            ->addIndexColumn()
            ->rawColumns(['email', 'check', 'action', 'refer_by_user', 'userstatus', 'referral_count'])
            ->make(true);
    }

    public function userReviewList()
    {
        return view('controlpanel.partner.review-list');
    }

    public function listReviewUser()
    {

        DB::enableQueryLog();
        DB::statement(DB::raw('set @rownum=0'));
        $userlist = User::select('*', DB::raw('@rownum  := @rownum  + 1 AS rownum'))
            ->where('id', '!=', Auth::user()->id)->where('sponsor_type', '=', 3)
            ->orderBy('id', 'desc')->where('is_edited', 1)->get();

        return Datatables::of($userlist)
            ->addColumn('check', function ($response) {
                return '<input type="checkbox" name="selected_users[]" value="' . $response->id . '" }}">';
            })
            ->editColumn('email', function ($response) {
                if ($response->disapprove_time != null) {
                    $disapproveDate = date("Y-m-d", strtotime($response->disapprove_time));
                } else {
                    $disapproveDate = '-';
                }

                return $response->email . "<br>Register Date: " . date("Y-m-d",
                        strtotime($response->created_at));

            })
            ->addColumn('specification', function ($response) {
                $getSpecifyList = SponsorrSpecify::where('user_id', $response->id)->get();
                $specifylist = SponsorrSpecifyList::get();
                if (isset($getSpecifyList) && $getSpecifyList != null) {
                    $specifyarray = [];
                    foreach ($getSpecifyList as $userspecify) {
                        foreach ($specifylist as $item) {
                            if ($userspecify->specify_name == $item->id) {
                                $specifyarray[] = @$item->specify_name;
                            }
                        }
                    }

                    return implode(',', $specifyarray);
                } else {
                    return "-";
                }
            })
            ->editColumn('sponsor_industry', function ($response) {
                if ($response->sponsor_industry == 'test' || $response->sponsor_industry == '') {
                    return "-";
                } else {
                    return @$response->industry->name;
                }


            })
            // ->editColumn('sponsor_type', function ($response) {
            //     if ($response->sponsor_type == 1)
            //         return "Offer Sponsorship";
            //     else
            //         return "Manage Or Receive Sponsorship";
            // })

            ->addColumn('refer_by_user', function ($response) {
                //dd($response['country_name']);
                if ($response->refer_by) {
                    return 'Refer By: <br>' . $response->referBy->email;
                } else {
                    return 'Self Registered';
                }
            })
            ->addColumn('referral_count', function ($response) {
                //dd($response['country_name']);
                //$referral_count = ReferAFriend::where('user_id', $response->id)->count();
                $referral_count = User::where('refer_by', $response->id)->count();

                return $referral_count;
            })
            ->editColumn('userstatus', function ($response) {
                $cust_id = "cust_id";
                if ($response->email_verified != 1) {
                    $html = '<a  href="javascript:void(0)"><span class="label label-warning" id="cust_id' . $response->id . '"  >Not Verify</span></a>';
                } else {
                    if ($response->userstatus == 1)
                        $html = '<a  href="javascript:void(0)"  onclick="changeStatus(' . $response->id . ')"><span class="label label-success my_lable_class" id="cust_id' . $response->id . '">Approved</span></a>';
                    else
                        $html = '<a  href="javascript:void(0)"   onclick="changeStatus(' . $response->id . ')"><span class="label label-danger my_lable_class" id="cust_id' . $response->id . '"  >Disapproved</span></a>';
                }
                if ($response->is_suspend == 0) {
                    $suspend = '<a  href="javascript:void(0)"   onclick="userChangeStatusSuspendWithComment(' . $response->id . ')"><span class="label label-danger my_lable_class" id="user_id' . $response->id . '"  >Suspend</span></a>';
                } else {
                    $suspend = '<a  href="javascript:void(0)"   onclick="changeSuspendStatus(' . $response->id . ')"><span class="label label-danger my_lable_class" id="user_id' . $response->id . '"  >Suspended</span></a>';
                }

                return $html . '<br>' . $suspend;
            })
            ->addColumn('action', function ($userlist) {
                $edit = '<a href="' . url('controlpanel/editusers/' . $userlist->id) . '" title="Edit" class="btn btn-sm btn-primary pull-left"><i class="fa fa-edit"></i></a>';
                $usertype = '<a href="' . url('controlpanel/edituser-type/' . $userlist->id) . '" title="Edit Usertype" class="btn btn-sm btn-warning pull-left"><i class="fa fa-exchange"></i></a>';
                $delete = '<a href="javascript:void(0)" title="Delete" class="btn btn-sm btn-danger pull-left" onclick="deleteUser(' . $userlist->id . ')"><i class="fa fa-remove"></i></a>';

                return $edit . $delete;
            })
            ->addIndexColumn()
            ->rawColumns(['email', 'check', 'action', 'refer_by_user', 'userstatus', 'referral_count'])
            ->make(true);
    }

    public function Offers()
    {
        return view('controlpanel.partner.offers');
    }

    public function listOffer()
    {
        DB::enableQueryLog();
        DB::statement(DB::raw('set @rownum=0'));
        $bidLists = Offer::with('industry')->with(['country', 'partner'])->get();

        return Datatables::of($bidLists)
            ->addColumn('country_name', function ($response) {
                //dd($response['country_name']);
                if ($response->available_in) {
                    return $response->country->country_name;
                } else {
                    return '-';
                }
            })
            ->addColumn('partner', function ($response) {
                //dd($response['country_name']);
                if ($response->partner_id) {
                    return (!empty($response->partner)) ? $response->partner->email : '-';
                } else {
                    return '-';
                }
            })

            ->addColumn('offeruser', function ($response) {
                $rst = DB::table('offers_order_item')->where('offer_id',$response->id)->get();
                $count=0; $uid=array();
                foreach($rst as $result)
                {
                    $userid = DB::table('offers_order')->where('id',$result->order_id)->value('user_id');
                    $type = DB::table('users')->where('id', $userid)->value('sponsor_type');
                    if($type ==1){array_push($uid,$userid); $count++;}
                }

                if($count > 0){
                $str = implode (",", $uid);
                return '<input type="hidden" name="uid" value="'.$str.'" /> <a href="'.route("offer-users",[$str,$response->id]).'" class="btn btn-primary btn-sm">'.$count.'</a>';
                }
              
            })

            ->addColumn('recuser', function ($response) {
                $rst = DB::table('offers_order_item')->where('offer_id',$response->id)->get();
                $count=0; $uid=array();
                foreach($rst as $result)
                {
                    $userid = DB::table('offers_order')->where('id',$result->order_id)->value('user_id');
                    $type = DB::table('users')->where('id', $userid)->value('sponsor_type');
                    if($type ==2){array_push($uid,$userid); $count++;}
                }
                if($count > 0){
                    $str = implode (",", $uid);
                    return '<input type="hidden" name="uid" value="'.$str.'" /> <a href="'.route("offer-users",[$str,$response->id]).'" class="btn btn-success btn-sm">'.$count.'</a>';
                    }
             })


            ->addColumn('admin_status', function ($response) {
                if ($response->admin_status == 1)
                    return '<a  href="javascript:void(0)"  onclick="changeStatus(' . $response->id . ')"><span class="label label-success my_lable_class" id="cust_id' . $response->id . '">Approved</span></a>';
                else
                    return '<a  href="javascript:void(0)"   onclick="changeStatus(' . $response->id . ')"><span class="label label-danger my_lable_class" id="cust_id' . $response->id . '"  >Disapproved</span></a>';
            })->addColumn('function', function ($response) {
                if (!empty($response->industry))
                    return $response->industry->name;
                else
                    return '-';
            })
            ->addColumn('action', function ($response) {
                $link = url('offer-share') . "/" . $response->share_id;
                $delete = '<a href="javascript:void(0)" title="Delete" class="btn btn-sm btn-danger pull-left" onclick="deleteUser(' . $response->id . ')"><i class="fa fa-remove"></i></a><span id="opportunity_' . $response->id . '" class="share-course-filed"
										  style="display: none;">' . $link . '</span><a
										href="javascript:void(0)" class="label label-success my_lable_class"
										onclick="copyToClipboard(\'#opportunity_' . $response->id . '\')">Copy Web link</a><br/><a class="mt-1 label label-success my_lable_class" href="' . $response->weblink . '" role="button" target="_blank">Weblink</a>';

                return $delete;
            })
            ->addIndexColumn()
            ->rawColumns(['country_name', 'partner', 'action', 'admin_status','recuser','offeruser'])
            ->make(true);
    }

    public function Offerusers(Request $request)
    {
        $usid = explode(",",$request->type);
        $userlist = DB::table('users')->whereIn('id', $usid)->get();
        return view('controlpanel.partner.offers_users',compact('userlist'));
    }

    public function offerbuyStatus(Request $request)
    {
        $user_id = $request->user_id;
        $offer_id = $request->offer_id; 
        $order_id = DB::table('offers_order')->where('user_id', $user_id)->value('id');
        $res = DB::table('offers_order_item')->where('order_id',$order_id)->where('offer_id',$offer_id)->update(array(
            'status'=>1,
            'appove_date' => date('Y-m-d'),
            ));

        //send email to user
        $smsdata = [
            'to' => 'rambthm376@gmail.com',
            'subject' => "Offer paid successfully",
            'message' => "Your offer has been paid",
        ];
        $send_mail = send_mail($smsdata);

        return $res; 

       
    }

    public function voucher_share(Request $request)
    {
        $id = $request->id;
        $email = $request->email;

        $code = DB::table('vouch_codes')->where('id',$id)->value('vouch_code');

         //send email to user
         $smsdata = [
            'to' => $email,
            'subject' => "Get Your Voucher Code",
            'message' => "This is your voucher code - ". $code,
        ];
        $send_mail = send_mail($smsdata);

        return $send_mail;

        // if($send_mail)
        // {
        //     return true;
        // }
        // else{
        //     return false;
        // }
    }

    public function DeleteOffers(Request $request)
    {
        if (isset($request->user_id) && $request->user_id == '') {
            return json_encode(['err_msg' => 'User id  is required.', 'editItem_id' => $request->user_id]);
        }
        $user = Offer::findOrFail($request->user_id);

        $user->delete();


        return json_encode(['msg' => trans("Offer has been deleted successfully"), 'user_id' => $request->user_id]);
    }



    public function OffersOpt(Request $request)
    {
        $offers = Offer::with('industry');

      
        $offers = $offers->get();

        $orders = DB::table('offers_order_item')
        ->join('offers_order','offers_order.id', '=', 'offers_order_item.order_id')
        ->join('users','users.id', '=', 'offers_order.user_id')
        ->join('offers','offers.id', '=', 'offers_order_item.offer_id')
        ->select('users.*','offers_order.*','offers_order_item.*','offers.offerred_by','offers.offer_for','offers.deal_amount','offers.currency')
        ->get();

        //echo "<pre/>";
       // print_r($orders); die;

        return view('controlpanel.partner.offer-opt', compact('offers','orders'));

    }
}
