<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Models\SupportTicketPriority;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SupportTicketPriorityController extends Controller
{
    // View & Route
    protected $view = "admin.support-tickets.priority.";
    protected $route = "admin/support-tickets/manage/priority";
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        global $request;

        if ($request->status != null) {

            $statusUpdate = SupportTicketPriority::where('id', $request->id)->update([
                'is_active' => $request->status,
            ]);
            Session::flash('message', [
                'text' => "Status has been changed successfully",
            ]);
            LogActivity::addToLog($request, 'Changed ib status status');
        }
        
        $dataSet = SupportTicketPriority::all();
        LogActivity::addToLog($request, 'Viewed ticket priority list');
        return view($this->view . 'index', compact('dataSet'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view($this->view . 'create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|regex:/^[A-Za-z\s]+$/|unique:support_ticket_priorities|max:255',
                'is_active' => 'required|boolean',
            ],
            [
                'name.required' => 'Ticket Priority name is required',
                'name.regex' => 'Ticket Priority name should only contains letters',
                'name.max' => 'Ticket Priority must be less then 255 characters',
                'name.unique' => 'Ticket Priority is already exists, please choose a different name',
                'is_active.required' => 'Select Ticket Priority visible status',
                'is_active.boolean' => 'Ticket Priority not selected kindly refresh page and try again',
            ],
        );

        if ($validator->fails()) {
            Session::flash('error', [
                'text' => $validator->errors()->first(),
            ]);
            return redirect()->back()->withInput();
        } else {
            $data = new SupportTicketPriority();
            $data->name = $request->name;
            $data->is_active = $request->is_active;

            $result = $data->save();

            if ($result) {
                Session::flash('message', [
                    'text' => "Ticket Priority is created",
                ]);
                LogActivity::addToLog($request, 'New Ticket Priority created');
                return redirect($this->route);
            } else {
                Session::flash('errors', [
                    'text' => "Something went wrong, please try again",
                ]);
                return redirect()->back()->withInput();
            }
        }

        return redirect($this->route);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $data = SupportTicketPriority::find($id);

        if ($data) {
            return view($this->view . '.edit', compact('data'));
        } else {
            return redirect($this->route)->with('warning', [
                'text' => "Record not found",
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $data = SupportTicketPriority::find($id);

        if ($data) {
            return view($this->view . '.edit', compact('data'));
        } else {
            return redirect($this->route)->with('warning', [
                'text' => "Record not found",
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|regex:/^[A-Za-z\s]+$/|unique:support_ticket_priorities,name,' . $id . '|max:255',
                'is_active' => 'required|boolean',
            ],
            [
                'name.required' => 'Ticket Priority name is required',
                'name.regex' => 'Ticket Priority name should only contains letters',
                'name.max' => 'Ticket Priority must be less then 255 characters',
                'name.unique' => 'Ticket Priority is already exists, please choose a different name',
                'is_active.required' => 'Select Ticket Priority visible status',
                'is_active.boolean' => 'Ticket Priority not selected kindly refresh page and try again',
            ],
        );

        if ($validator->fails()) {
            Session::flash('error', [
                'text' => $validator->errors()->first(),
            ]);
            return redirect()->back()->withInput();
        } else {
            $data = SupportTicketPriority::find($id);
            $data->name = $request->name;
            $data->is_active = $request->is_active;
            $result = $data->save();

            if ($result) {
                Session::flash('message', [
                    'text' => "Record is updated",
                ]);
                LogActivity::addToLog($request, 'Support Ticket Priority updated');
            } else {
                Session::flash('error', [
                    'text' => "Something went wrong, please try again",
                ]);
            }
        }

        return redirect()->back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        global $request;

        if (SupportTicketPriority::where('id', $id)->exists()) {
            $result = SupportTicketPriority::destroy($id);

            if ($result) {
                Session::flash('message', [
                    'text' => 'Record has been deleted',
                ]);
                LogActivity::addToLog($request, 'support ticket priority deleted');
            } else {
                Session::flash('warning', [
                    'text' => 'Something went wrong, please try again',
                ]);
            }
        } else {
            Session::flash('danger', [
                'text' => 'Record not found',
            ]);
        }

        return redirect($this->route);
    }
}
