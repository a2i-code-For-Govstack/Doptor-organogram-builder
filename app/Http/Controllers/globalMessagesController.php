<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\MessageView;
use App\Models\OfficeMinistry;
use App\Models\OfficeLayer;
use App\Models\Office;
use App\Models\OfficeOriginUnit;
use App\Models\OfficeUnit;
use App\Models\OfficeUnitOrganogram;
use Illuminate\Support\Facades\Auth;

class globalMessagesController extends Controller
{
    public function index()
    {
        $office_ministries = OfficeMinistry::all();
        $msgs = Message::where('is_deleted', 0)->orderBy('id', 'DESC')->paginate(10);
        return view('messages.index', compact('office_ministries','msgs'));
    }

    public function list()
    {
        $msgs = Message::where('is_deleted', 0)->paginate(15);
        return view('messages.data', compact('msgs'));
    }

    public function show($id)
    {
        $data = Message::find($id);
        return response()->json(["title" => $data->title, "msg" => $data->message], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'message' => 'required'
        ],[
            'title.required' => 'Title is a must!',
            'message.required' => 'Message required!'
        ]);

        $organograms = $request->office_unit_org_id;
        $auth = Auth::user()->id;

        if (empty($organograms)) {
            $organograms = $request->office_organogram_id;
        }
        if (empty($organograms)) {
            $units = $request->unit_select;
        }

        if (!empty($organograms)) {
            foreach ($organograms as $organogram) {
                $obj = new Message;
                $obj->title = $request->title;
                $obj->message = $request->message;
                $obj->message_for = 'organogram';
                $obj->related_id = $organogram;
                $obj->is_deleted = 0;
                $obj->message_by = $auth;
                $obj->save();
            }
        } elseif(!empty($units)) {
            foreach ($units as $unit) {
                $obj = new Message;
                $obj->title = $request->title;
                $obj->message = $request->message;
                $obj->message_for = 'unit';
                $obj->related_id = $unit;
                $obj->is_deleted = 0;
                $obj->message_by = $auth;
                $obj->save();
            }
        } else {
            $obj = new Message;
            $obj->title = $request->title;
            $obj->message = $request->message;
            if ($request->office_unit_id && $request->office_unit_id > 0) {
                $obj->message_for = 'unit';
                $obj->related_id = $request->office_unit_id;
            } elseif ($request->office_id && $request->office_id > 0) {
                $obj->message_for = 'office';
                $obj->related_id = $request->office_id;
            } elseif ($request->layer_level && $request->layer_level > 0) {
                $obj->message_for = 'layer';
                $obj->related_id = $request->layer_level;
            }  elseif ($request->layer_id && $request->layer_id > 0) {
                $obj->message_for = 'layer';
                $obj->related_id = $request->layer_id;
            } elseif ($request->message_office_origin_id && $request->message_office_origin_id > 0) {
                $obj->message_for = 'office_origin';
                $obj->related_id = $request->message_office_origin_id;
            } elseif ($request->message_office_layer_id && $request->message_office_layer_id > 0) {
                $obj->message_for = 'office_layer';
                $obj->related_id = $request->message_office_layer_id;
            } elseif ($request->message_office_ministry_id && $request->message_office_ministry_id > 0) {
                $obj->message_for = 'office_ministry';
                $obj->related_id = $request->message_office_ministry_id;
            } elseif ($request->message_for && $request->message_for == 1) {
                if (!empty(Auth::user()->current_office_id())) {
                    $obj->message_for = "office";
                    $obj->related_id = Auth::user()->current_office_id();;
                } else {
                    $obj->message_for = "all";
                    $obj->related_id = 0;
                }
            } else {
                return redirect()->back()->with('error', 'The correct recipient was not selected. Please try again.');
            }
            $obj->is_deleted = 0;
            $obj->message_by = $auth;
            $obj->save();
        }
        return redirect()->back()->with('success', 'New message saved.');
    }

    public function destroy($id)
    {

        $msg = Message::find($id);
        $msg->is_deleted = 1;
        $msg->save();
        return response()->json([
            'success' => 'Message deleted successfully!'
        ], 200);
    }

    public function loadLayersByMinistry($id)
    {
        $layers = OfficeLayer::where('office_ministry_id', $id)->get();
        return response()->json(['layers' => $layers], 200);
    }

    public function loadOfficesByMinistryAndLayer($id, $layer)
    {
        $offices = Office::where('active_status', 1)->where('office_ministry_id', $id)->where('office_layer_id', $layer)->get();
        return response()->json(['offices' => $offices], 200);
    }

    public function loadOriginOffices($id)
    {
        $origin = OfficeOriginUnit::where('office_origin_id', $id)->where('active_status', 1)->get();
        return response()->json(['origin' => $origin], 200);
    }

    public function loadOfficeUnits($id)
    {
        $unit = OfficeUnit::where('active_status', 1)->orderBy('unit_level')->where('office_id', $id)->get();
        return response()->json(['unit' => $unit], 200);
    }

    public function loadOfficeUnitOrganogramsWithName($id)
    {
        $units = OfficeUnitOrganogram::where('office_unit_id', $id)->get();
        $data = [];
        foreach ($units as $unit) {
            $data[] = [
                "id" => $unit->id,
                "designation" => $unit->designation_bng,
                "title" => @$unit->officeEmployee()->name_bng,
                "title_id" => @$unit->officeEmployee()->id
            ];
        }
        return response()->json(['units' => $data], 200);
    }

    public function notificationMessage()
    {
        $auth = Auth::user();
        $office_id = $auth->current_office_id();
        $unit_id = $auth->current_office_unit_id();
        $org_id = $auth->current_designation_id();

        $office = Office::find($office_id);
        $officeLayer = OfficeLayer::find($office->office_layer_id);
        $custom_layer_id = $officeLayer->custom_layer_id;

        $messageTables = Message::where('message_for', 'all')->where('is_deleted', 0)->orWhere(function($query)use($office_id){
            $query->where(['message_for' => 'office', 'related_id' => $office_id]);
        })->orWhere(function($query)use($unit_id){
            $query->where(['message_for' => 'unit', 'related_id' => $unit_id]);
        })->orWhere(function($query)use($org_id){
            $query->where(['message_for' => 'organogram', 'related_id' => $org_id]);
        })->orWhere(function($query)use($custom_layer_id){
            $query->where(['message_for' => 'layer', 'related_id' => $custom_layer_id]);
        });
        $g_messages = $messageTables->orderBy('id', 'desc')->get();
        $global_messages = [];
        foreach($g_messages as $global_message) {
            $messageView = MessageView::where(['message_id' => $global_message->id, 'organogram_id' => $org_id]);
            if ($messageView->count() > 0) {
                $global_messages['read'][] = $global_message;
            } else {
                $global_messages['unread'][] = $global_message;
            }
        }
        $total_message = !empty($global_messages['unread']) ? count($global_messages['unread']) : '';
        return response()->json(['notification' => $global_messages, 'count' => $total_message]);
    }

    public function showPopUpNotification(Request $request)
    {
        $organogram_id = Auth::user()->current_designation_id();
        $show_message = Message::find($request->id);

        $already_shows = MessageView::where(['message_id' => $show_message->id, 'organogram_id' => $organogram_id])->first();

        if (!empty($show_message) && $already_shows === null) {
            $obj = new MessageView;
            $obj->message_id = $show_message->id;
            $obj->is_view = 1;
            $obj->organogram_id = $organogram_id;
            $obj->view_count = 1;
            $obj->save();
        } else {
            $obj['view_count'] = $already_shows->view_count+1;
            $messageView = MessageView::where('message_id', $show_message->id);
            $messageView->update($obj);
        }

        return response()->json([$show_message]);
    }

    public function getUnitList(Request $request)
    {
        $office_id = $request->office_id;
        $unit = [];
        if (!empty($office_id)) {
            $units = OfficeUnit::where('office_id', $office_id)
            ->where('active_status', 1)
            ->get();
        }
        return view('messages.select_unit_list', compact('units'));
    }

    public function getUnitOrganogramList(Request $request)
    {
        $unit_id = $request->unit_id;
        $organograms = [];
        if (!empty($unit_id)) {
            $organograms = OfficeUnitOrganogram::whereIn('office_unit_id', $unit_id)
            ->where('status', 1)
            ->get();
        }
        return view('messages.select_org_list', compact('organograms'));
    }
}
