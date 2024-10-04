<?php

namespace App\Http\Controllers\ControlpanelAuth;

use App\Http\Controllers\Controller;
use App\Opportunity;
use App\Traits\ApiResponse;
use DataTables;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class OpportunityController extends Controller
{

    use ApiResponse;


    public function index()
    {
        return view('controlpanel.opportunity.opportunitylist');
    }

    public function vouchList()
    {
        return view('controlpanel.opportunity.vouchlist');
    }

    public function listOpportunity($type = '')
    {
        $user_type = '';

        DB::enableQueryLog();
        DB::statement(DB::raw('set @rownum=0'));
        $bidLists = Opportunity::with(['opportunityUsers', 'country_name', 'industry'])->get();

        return Datatables::of($bidLists)
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
            })
            ->addColumn('opportunity_email', function ($response) {
                //dd($response['country_name']);
                if ($response->opportunityUsers) {
                    $email = [];
                    foreach ($response->opportunityUsers as $user) {
                        $email[] = $user->email;
                    }
                    if (! empty($email)) {
                        return wordwrap(implode(", ", $email));
                    } else {
                        return "-";
                    }

                    return "-";
                    // return $response->opportunityUser->email;
                } else {
                    return '-';
                }
            })
            ->editColumn('status', function ($response) {
                if ($response->status == 1)
                    return '<a  href="javascript:void(0)"  onclick="changeStatus(' . $response->id . ')"><span class="label label-success my_lable_class" id="cust_id' . $response->id . '">Active</span></a>';
                else
                    return '<a  href="javascript:void(0)"   onclick="changeStatus(' . $response->id . ')"><span class="label label-danger my_lable_class" id="cust_id' . $response->id . '"  >Inactive</span></a>';
            })->editColumn('s', function ($response) {
                if ($response->status == 1)
                    return 'Active';
                else
                    return 'Inactive';
            })
            ->addColumn('responseCount', function ($response) {
                $url = url('controlpanel/vouchlist/') . "/" . $response->id;

                return '<a href="' . $url . '" > <span class="badge badge-light" >' . $response->vouchesResponse->count() . '</span > </a > ';
            })
            ->addColumn('sponsor_industry', function ($response) {
                if (empty($response->industry)) {
                    return "-";
                } else {
                    return @$response->industry->name;
                }
            })
            ->addColumn('action', function ($response) {
                $link = url('share-opportunity') . "/" . $response->share_id;
                $delete = '<a href="javascript:void(0)" title="Delete" class="btn btn-sm btn-danger pull-left" onclick="deleteUser(' . $response->id . ')"><i class="fa fa-remove"></i></a><span id="opportunity_' . $response->id . '" class="share-course-filed"
										  style="display: none;">' . $link . '</span><a
										href="javascript:void(0)" class="btn btn-primary read-more-btn  share-opp-btn"
										onclick="copyToClipboard(\'#opportunity_' . $response->id . '\')">Copy Web link</a>';

                return $delete;
            })
            ->addIndexColumn()
            ->rawColumns(['country_name', 'opportunity_email', 'status', 'sponsor_industry', 'responseCount', 'action','city_name'])
            ->make(true);
    }

    public function opportunityChangeStatus(Request $request)
    {
        if (empty($request->opportunityId)) {
            return json_encode(['err_msg' => 'Please select opportunity', 'user_id' => $request->opportunityId]);
        }
        $user = Opportunity::findOrFail($request->opportunityId);
        if ($user->status == 1) {
            $user->status = 0;
            $user->save();

            return json_encode(['status' => $user->status, 'msg' => trans("Opportunity status has been updated successfully"), 'user_id' => $request->opportunityId]);
        } else {
            $user->status = 1;
            $user->save();

            // $send_mail = send_mail($data);
            return json_encode(['status' => $user->status, 'msg' => trans("Opportunity status has been updated successfully"), 'user_id' => $request->opportunityId]);
        }
    }

    public function listVouch(Request $request)
    {
        DB::enableQueryLog();
        DB::statement(DB::raw('set @rownum=0'));
        $bidLists = \App\Vouche::with(['opportunity', 'userDetail'])
            ->where('opportunity_id', $request->id)->get();

        return Datatables::of($bidLists)
            ->addColumn('userEmail', function ($response) {
                //dd($response['country_name']);
                if ($response->userDetail) {
                    return $response->userDetail->email;
                } else {
                    return '-';
                }
            })
            ->addColumn('status', function ($response) {

                if ($response->is_accepted != 2)
                    return '<a href="javascript:void(0)"><span
													class="label label-warning ">Accepted</span></a>';
                else
                    return '<a href = "javascript:void(0)" ><span
													class="label label-success" > Open for Negotiation </span ></a>';

            })
            ->addIndexColumn()
            ->rawColumns(['status', 'userEmail'])
            ->make(true);
    }

    public function deleteOpportunity(Request $request)
    {
        Opportunity::where('id', $request->user_id)->delete();

        return json_encode(['msg' => trans("Opportunity has been deleted successfully"), 'bid_id' => $request->user_id]);
    }
}
