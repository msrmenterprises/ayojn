<?php

namespace App\Http\Controllers\Controlpanel;

use App\Bid;
use App\Http\Controllers\Controller;
use App\Industry;
use App\Offer;
use App\Opportunity;
use App\ResponseBid;
use App\Role;
use App\SponsorrSpecify;
use App\SponsorrSpecifyList;
use App\User;
use App\Vouche;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Validator;

class UserController extends Controller
{
    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('controlpanel.user.userlist');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, User $user)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {

        if ($user->delete()) {
            return response()->json(['status' => 1, 'msg' => 'User Deleted Successfully!']);
        } else {
            return response()->json(['status' => 0, 'msg' => 'Something Went Wrong']);
        }

    }

    public function listUser($type = '')
    {
        $user_type = '';

        DB::enableQueryLog();
        DB::statement(DB::raw('set @rownum=0'));
        if ($type == "offer") {
            $userlist = User::with('country_name', 'country_sponsorr', 'industry', 'Specify')
                ->select('*', DB::raw('@rownum  := @rownum  + 1 AS rownum'))->where('sponsor_type', '=', 1)
                ->where('sponsor_for', '!=', '')->where('id', '!=', Auth::user()->id)->orderBy('id', 'desc')->get();
        } else if ($type == "manage") {
            $userlist = User::with('country_name', 'country_sponsorr', 'industry', 'specification')
                ->select('*', DB::raw('@rownum  := @rownum  + 1 AS rownum'))->where('sponsor_type', '=', 2)
                ->where('sponsor_for', '!=', '')->where('id', '!=', Auth::user()->id)->orderBy('id', 'desc')->get();
        } else if ($type == "incomplete") {
            $userlist = User::with('country_name', 'country_sponsorr', 'specification')
                ->select('*', DB::raw('@rownum  := @rownum  + 1 AS rownum'))->whereNull('sponsor_for')
                ->where('id', '!=', Auth::user()->id)->orderBy('id', 'desc')->get();
        } else {
            $userlist = User::with('country_name', 'country_sponsorr', 'industry', 'specification')
                ->select('*', DB::raw('@rownum  := @rownum  + 1 AS rownum'))->where('id', '!=', Auth::user()->id)
                ->orderBy('id', 'desc')->get();

        }
        $userlist= $userlist->where('sponsor_type', '!=', 3);


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
                        strtotime($response->created_at)) . "<br>Valid Upto: " . $disapproveDate;

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
            ->editColumn('sponsor_type', function ($response) {
                if ($response->sponsor_type == 1)
                    return "Offer Sponsorship";
                // return '<a  href="javascript:void(0)"  onclick="changeType(' . $response->id . ')"><span class="label label-warning my_lable_class" id="user_id' . $response->id . '">Offer Sponsorship</span></a>';
                else
                    return "Manage Or Receive Sponsorship";
                // return '<a  href="javascript:void(0)"   onclick="changeType(' . $response->id . ')"><span class="label label-info my_lable_class" id="user_id' . $response->id . '"  >Manage Or Receive Sponsorship</span></a>';
            })
            ->editColumn('sponsor_budget', function ($response) {
                return '<span class="label label-success my_lable_class" >' . $response->sponsor_for . '</span><br>' . $response->sponsor_budget;
            })
            ->addColumn('country_name', function ($response) {
                //dd($response['country_name']);
                if ($response->country_name) {
                    return $response->country_name->country_name;
                } else {
                    return '-';
                }
            })->addColumn('city_name', function ($response) {
                //dd($response['country_name']);
                if ($response->city_name) {
                    return $response->city_name->name;
                } else {
                    return '-';
                }
            })->addColumn('refer_by_user', function ($response) {
                //dd($response['country_name']);
                if ($response->refer_by && !empty($response->referBy)) {
                    return 'Refer By: <br>' . $response->referBy->email;
                } else {
                    return 'Self Registered';
                }
            })
            ->addColumn('country_sponsorr', function ($response) {
                //dd($response['country_name']);
                if ($response->country_sponsorr) {
                    return $response->country_sponsorr->country_name;
                } else {
                    return '-';
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

                return $edit . $usertype . $delete;
            })
            ->addIndexColumn()
            ->rawColumns(['email', 'check', 'action', 'refer_by_user', 'sponsor_type', 'specification', 'userstatus', 'sponsor_budget', 'country_name', 'referral_count', 'city_name'])
            ->make(true);
    }

    public function userChangeStatusSuspendForm(Request $request, $id)
    {
        $view = view('controlpanel.user.add-reason',
            compact('id'))->render();

        return response()->json(['html' => $view]);
    }

    public function userChangeStatusSuspendWithComment(Request $request)
    {
        $user = User::findOrFail($request->userId);
        if (! empty($user)) {
            $user->is_suspend = 1;
            $user->suspend_reason = $request->suspend_reason;
            $user->save();

            return json_encode(['status' => 1, 'msg' => trans("User status has been updated successfully"), 'user_id' => $request->userId]);
        } else {
            return json_encode(['err_msg' => 'User id  is required.', 'user_id' => $request->user_id]);
        }
    }

    public function userChangeStatusSuspend(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        if (! empty($user)) {
            if ($user->is_suspend == 0) {
                $user->is_suspend = 1;
            } else {
                $user->is_suspend = 0;
            }
            $user->save();

            return json_encode(['status' => $user->is_suspand, 'msg' => trans("User status has been updated successfully"), 'user_id' => $request->user_id]);
        } else {
            return json_encode(['err_msg' => 'User id  is required.', 'user_id' => $request->user_id]);
        }
    }

    public function userChangeStatus(Request $request)
    {
        if (empty($request->user_id)) {
            return json_encode(['err_msg' => 'User id  is required.', 'user_id' => $request->user_id]);
        }
        $user = User::findOrFail($request->user_id);
        if ($user->userstatus == 1) {
            $user->userstatus = 0;
            $user->save();

            return json_encode(['status' => $user->userstatus, 'msg' => trans("User status has been updated successfully"), 'user_id' => $request->user_id]);
        } else {
            if ($user->is_3refer == 1) {
                $user->userstatus = 1;
                $user->is_edited = 0;
                $user->disapprove_time = date("Y-m-d H:i:s", strtotime('+12 month'));
            } else {
                $user->userstatus = 1;
                $user->is_edited = 0;
                $user->disapprove_time = date("Y-m-d H:i:s", strtotime('+48 hours'));
            }
            $user->save();
            if ($user->sponsor_type == 1) {
                Mail::send('/mail/offer_approve', ['user' => $user], function ($m) use ($user) {
                    $m->to($user->email)->subject("Profile validated to access Ayojn")->getSwiftMessage()
                        ->getHeaders()
                        ->addTextHeader('x-mailgun-native-send', 'true');
                });
            }
            if ($user->sponsor_type == 2) {
                Mail::send('/mail/receive_approve', ['user' => $user], function ($m) use ($user) {
                    $m->to($user->email)->subject("Profile validated to access Ayojn")->getSwiftMessage()
                        ->getHeaders()
                        ->addTextHeader('x-mailgun-native-send', 'true');
                });
            }
            if ($user->sponsor_type == 3) {
                Mail::send('/mail/partner_approve', ['user' => $user], function ($m) use ($user) {
                    $m->to($user->email)->subject("Profile validated to access Ayojn")->getSwiftMessage()
                        ->getHeaders()
                        ->addTextHeader('x-mailgun-native-send', 'true');
                });
            }


            // $send_mail = send_mail($data);
            return json_encode(['status' => $user->userstatus, 'msg' => trans("User status has been updated successfully"), 'user_id' => $request->user_id]);
        }
    }

    public function offerChangeStatus(Request $request)
    {
        if (empty($request->user_id)) {
            return json_encode(['err_msg' => 'Offer id  is required.', 'user_id' => $request->user_id]);
        }
        $user = Offer::findOrFail($request->user_id);
        if ($user->admin_status == 1) {
            $user->admin_status = 0;
            $user->save();

            return json_encode(['status' => $user->userstatus, 'msg' => trans("Offer status has been updated successfully"), 'user_id' => $request->user_id]);
        } else {
            $user->admin_status = 1;
            $user->save();

            // $send_mail = send_mail($data);
            return json_encode(['status' => $user->admin_status, 'msg' => trans("Offer status has been updated successfully"), 'user_id' => $request->user_id]);
        }
    }

    public function usersChangeStatus(Request $request)
    {
        if (empty($request->userIds)) {
            return json_encode(['msg' => 'Please select atleast one user']);
        } else {
            foreach ($request->userIds as $userId) {
                $user = User::findOrFail($userId);
                $user->userstatus = $request->status;

                $user->save();
                if ($request->status == 1) {
                    $bid = Bid::where('user_id', $user->id)->update(['status' => "On"]);
                    if ($user->sponsor_type == 1) {
                        Mail::send('/mail/offer_approve', ['user' => $user], function ($m) use ($user) {
                            $m->to($user->email)->subject("Profile validated to access Ayojn")->getSwiftMessage()
                                ->getHeaders()
                                ->addTextHeader('x-mailgun-native-send', 'true');
                        });
                    }
                    if ($user->sponsor_type == 2) {
                        Mail::send('/mail/receive_approve', ['user' => $user], function ($m) use ($user) {
                            $m->to($user->email)->subject("Profile validated to access Ayojn")->getSwiftMessage()
                                ->getHeaders()
                                ->addTextHeader('x-mailgun-native-send', 'true');
                        });
                    }
                }
            }

            return json_encode(['msg' => trans("User status has been updated successfully")]);
        }
    }

    public function deleteUsers(Request $request)
    {
        if (empty($request->userIds)) {
            return json_encode(['msg' => 'Please select atleast one user']);
        } else {
            foreach ($request->userIds as $userId) {
                $user = User::findOrFail($userId);
                $opportunity = Opportunity::where('receiver_id', $user->id)->get();

                if (! empty($opportunity->first())) {
                    foreach ($opportunity as $o) {

                        $vouche = Vouche::where('opportunity_id', $o->id)->get();
                        if (! empty($vouche->first())) {
                            foreach ($vouche as $v) {
                                $v->delete();
                            }
                        }
                        $o->delete();
                    }
                }
                $vouche = Vouche::where('offer_id', $user->id)->get();
                if (! empty($vouche->first())) {
                    foreach ($vouche as $v) {
                        $v->delete();
                    }
                }
                $bids = Bid::where('user_id', $user->id)->get();
                if (! empty($bids->first())) {
                    foreach ($bids as $bid) {

                        $rBids = ResponseBid::where('bid_id', $bid->id)->get();
                        if (! empty($rBids->first())) {
                            foreach ($rBids as $rBid) {
                                $rBid->delete();
                            }
                        }
                        $bid->delete();
                    }
                }
                $rBids = ResponseBid::where('respond_user_id', $user->id)->get();
                if (! empty($rBids->first())) {
                    foreach ($rBids as $rBid) {
                        $rBid->delete();
                    }
                }
                $user->delete();
            }

            return json_encode(['msg' => trans("User status has been updated successfully")]);
        }
    }

    public function userType(Request $request)
    {
        if (empty($request->user_id)) {
            return json_encode(['err_msg' => 'User id  is required.', 'user_id' => $request->user_id]);
        }
        $user = User::findOrFail($request->user_id);
        if ($user->sponsor_type == 1) {
            $user->sponsor_type = 2;
            $user->save();

            return json_encode(['sponsor_type' => $user->sponsor_type, 'msg' => trans("Sponsor Type has been updated successfully"), 'user_id' => $request->user_id]);
        } else {
            $user->sponsor_type = 1;
            $user->save();

            return json_encode(['sponsor_type' => $user->sponsor_type, 'msg' => trans("Sponsor Type has been updated successfully"), 'user_id' => $request->user_id]);
        }
    }

    public function deleteUser(Request $request)
    {
        if (isset($request->user_id) && $request->user_id == '') {
            return json_encode(['err_msg' => 'User id  is required.', 'editItem_id' => $request->user_id]);
        }
        $user = User::findOrFail($request->user_id);
        $opportunity = Opportunity::where('receiver_id', $user->id)->get();
        if (! empty($opportunity->first())) {
            foreach ($opportunity as $o) {
                $vouche = Vouche::where('opportunity_id', $o->id)->get();
                if (! empty($vouche->first())) {
                    foreach ($vouche as $v) {
                        $v->delete();
                    }
                }
                $o->delete();
            }
        }
        $vouche = Vouche::where('offer_id', $user->id)->get();
        if (! empty($vouche->first())) {
            foreach ($vouche as $v) {
                $v->delete();
            }
        }

        $bids = Bid::where('user_id', $user->id)->get();
        if (! empty($bids->first())) {
            foreach ($bids as $bid) {

                $rBids = ResponseBid::where('bid_id', $bid->id)->get();
                if (! empty($rBids->first())) {
                    foreach ($rBids as $rBid) {
                        $rBid->delete();
                    }
                }
                $bid->delete();
            }
        }
        $rBids = ResponseBid::where('respond_user_id', $user->id)->get();
        if (! empty($rBids->first())) {
            foreach ($rBids as $rBid) {
                $rBid->delete();
            }
        }
        $user->delete();


        return json_encode(['msg' => trans("User has been deleted successfully"), 'user_id' => $request->user_id]);
    }

    public function editusers($id)
    {
        $user = User::where('id', $id)->first();

        return view('controlpanel.user.useredit', compact('user'));
    }

    public function editUserType($id)
    {
        $user = User::where('id', $id)->first();

        $industries = Industry::all();

        return view('controlpanel.user.usertypeedit', compact('user', 'industries'));
    }

    public function updateUserType(Request $request)
    {
        $users = User::find($request->userid);
        $users->sponsor_type = $request->userType;
        $users->sponsor_industry = $request->sponsorIndustry;
        $users->save();

        return redirect('controlpanel/user-list')->with('success', 'User type has been successfully updated');

    }

    public function updateuser(Request $request)
    {
        $id = $request->userid;
        //dd($id);
        //'company_email'=>'required|email|unique:companydetails,company_email,'.$data['company_id'],
        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                Rule::unique('users')->where(function ($q) use ($id) {
                    $q->where('deleted_at', null)->where('id', '!=', $id);
                })
            ],
        ], [
            'email.required' => 'User Email is required',
            'email.unique' => 'User Email Has Already Been Taken',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        } else {
            $data = [
                'email' => $request->get('email'),
                'remark' => $request->get('remark'),
                'identity' => $request->get('identity'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $where = [
                'id' => $request->get('userid'),
            ];
            $userid = User::where($where)->update($data);

            return redirect('controlpanel/user-list')->with('success', 'Profile Updated Successfully');
        }
    }
}
