<?php

namespace App\Http\Controllers\UserAuth;

use App\Country;
use App\Http\Controllers\Controller;
use App\Industry;
use App\Models\Attendee;
use App\Models\Collaborate;
use App\Models\ColResponse;
use App\Models\Event;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class CollaborateController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $myEvents = Collaborate::with('specifyName')->where('user_id', Auth::user()->id);
        if ($request->query('f')) {
            $myEvents = $myEvents->where('collaborate_for', 'like', $request->query('f'));
        }
        if ($request->query('os')) {
            $myEvents = $myEvents->where('objective', 'like', $request->query('os'));
        }
        if ($request->query('c')) {
            $myEvents = $myEvents->where('geo_focus', 'like', $request->query('c'));
        }
        if ($request->query('b')) {
            $myEvents = $myEvents->where('budget', 'like', $request->query('b'));
        }
        if ($request->query('i')) {
            $myEvents = $myEvents->where('industry_focus', 'like', $request->query('i'));
        }
        $myEvents = $myEvents->get();


        $othersEvents = Collaborate::with(['organizer'])->where('user_id', '!=', Auth::user()->id)->where('status', 1);
        if ($request->query('of')) {
            $othersEvents = $othersEvents->where('collaborate_for', 'like', $request->query('of'));
        }
        if ($request->query('so')) {
            $othersEvents = $othersEvents->where('objective', 'like', $request->query('so'));
        }
        if ($request->query('oc')) {
            $othersEvents = $othersEvents->where('geo_focus', 'like', $request->query('oc'));
        }
        if ($request->query('ob')) {
            $othersEvents = $othersEvents->where('budget', 'like', $request->query('ob'));
        }
        if ($request->query('oi')) {
            $othersEvents = $othersEvents->where('industry_focus', 'like', $request->query('oi'));
        }
        $othersEvents = $othersEvents->get();

        $industryLists = Industry::all();
        $countries = Country::all();
        return view('collaborate.index', compact('myEvents', 'othersEvents', 'industryLists', 'countries'));
    }

    public function addCollaboration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'collaborate_for' => "required",
            'sub' => "required",
            'remote_opportunity' => "required",
            'geo_focus' => "required",
            'industry_focus' => "required",
            'with_local_focus' => "required",
            'collaborate_with' => "required",
            'budget' => "required",
            'objective' => "required",
            'expiry_date' => "required",
        ], [
            'collaborate_for.required' => "Please enter any one",
            'sub.required' => "Please enter any one",
            'remote_opportunity.required' => "Please select any one",
            'geo_focus.required' => "Please select geo focus",
            'industry_focus.required' => "Please select industry focus",
            'with_local_focus.required' => "Please select any one",
            'collaborate_with.required' => "Please select any one",
            'budget.required' => "Please select budget",
            'objective.required' => "Please select objective",
            'expiry_date.required' => "Please select objective",
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'message' => $validator->errors()->first()])
                ->setStatusCode(200);
        }
        if (($request->remote_opportunity == 'Yes') && ($request->remote_country == '' || $request->remote_city)) {
            return response()->json(['status' => 0, 'message' => 'Please select country or city'])
                ->setStatusCode(200);
        }
        $sub = '';
        if (!empty($request->sub)) {
            $sub = implode(', ', $request->sub);
        }
        $collaboration = [
            'user_id' => Auth::user()->id,
            'collaborate_for' => $request->collaborate_for,
            'sub' => $sub,
            'remote_opportunity' => $request->remote_opportunity,
            'remote_country' => $request->remote_country,
            'remote_city' => $request->remote_city,
            'geo_focus' => $request->geo_focus,
            'industry_focus' => $request->industry_focus,
            'with_local_focus' => $request->with_local_focus,
            'collaborate_with' => $request->collaborate_with,
            'budget' => $request->budget,
            'status' => 0,
            'objective' => $request->objective,
            'expiry_date' => date('Y-m-d',strtotime($request->expiry_date)),
        ];
        $collaborationResponse = Collaborate::create($collaboration);
        $collaborationResponse->share_id = $this->uniquiShareId($collaborationResponse->id);
        $collaborationResponse->save();

        if (!empty($collaborationResponse)) {
            return response()->json(['status' => 1, 'message' => 'Collaboration is successfully created.'])
                ->setStatusCode(200);
        } else {
            return response()->json(['status' => 0, 'message' => 'Something went wrong'])
                ->setStatusCode(200);
        }

    }

    public function uniquiShareId($id)
    {
        return md5(uniqid(rand() . $id, true));
    }

    public function addCollaborationResponse(Request $request)
    {
        $rules = [
            'col_id' => 'required',
            'description' => 'required',
            'portfolio_link' => 'required',
        ];
        $messsages = [
            'col_id.required' => 'Select any bid for response',
            'description.required' => 'Enter Description',
            'portfolio_link.required' => 'Enter Portfolio Link',

        ];
        $validator = Validator::make($request->all(), $rules, $messsages);
        if ($validator->fails()) {
            return $this->validationErrors($validator)->setStatusCode(200);
        }
        $collResponse = [
            'respond_user_id' => Auth::user()->id,
            'col_id' => $request->col_id,
            'description' => $request->description,
            'portfolio_link' => $request->portfolio_link,
            'status' => 0,
        ];
        $response = ColResponse::create($collResponse);
        if ($response) {
            return $this->successResponse("Collaboration response Has been Added.");
        } else {
            return $this->failResponse("Error Occured!Please try again later")->setStatusCode(200);
        }
    }

    public function collaboratorList($colId)
    {
        $eventId = base64_decode($colId);
        $event = Collaborate::where('id', $eventId)->where('user_id', Auth::user()->id)->first();
        if (empty($event)) {
            return redirect('events');
        }
        $attendeedList = ColResponse::with(['user'])->where('col_id', $eventId)->get();

        return view('collaborate.collaborator-list', compact('attendeedList', 'eventId'));
    }

    public function changeStatusCollaborator($id)
    {
        $attendeedList = ColResponse::where('id', $id)->first();
        if ($attendeedList->status == 1) {
            $attendeedList->status = 0;
        } else {
            $attendeedList->status = 1;
        }
        $attendeedList->save();
        return json_encode(['status' => 1, 'msg' => trans("status has been updated successfully")]);
    }

    public function shareCol(Request $request, $colId)
    {
        $othersEvents = Collaborate::with(['organizer'])->where('share_id', $colId)->where('status', 1)->get();
        if (!empty($othersEvents->first())) {
            session()->flash('url.intended', '/' . request()->path());

            return view('collaborate.share-col', compact('othersEvents'));
        } else {
            return view('collaborate.datanotfound');
        }

    }

    public function ExportCollaborator($id){
        $records = ColResponse::with('user')->where('col_id', $id)->get();

        foreach ($records as $key => $record) {
            $data[$key]['User Email'] = (!empty($record->user)) ? $record->user->email : '-';
            $data[$key]['User Entity'] = (!empty($record->user)) ? $record->user->entity : '-';
            $data[$key]['User Phone'] = (!empty($record->user)) ? $record->user->phone_no : '-';
            $data[$key]['description'] = $record->description;
            $data[$key]['portfolio_link'] = $record->portfolio_link;
            if ($record->status == 0) {
                $data[$key]['Status'] = 'Pending';
            } else if ($record->status == 1) {
                $data[$key]['Status'] = 'Approved';
            } else if ($record->status == 2) {
                $data[$key]['Status'] = 'Cancel';
            }
        }
        $event = Event::find($id);

        return Excel::create('Collaborators', function ($excel) use ($data) {
            $excel->sheet('Collaborators', function ($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->download('xlsx');
    }
}
