<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Models\TicketStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SupportTicketStatusController extends Controller
{
    // View & Route
    protected $view = "admin.support-tickets.status.";
    protected $route = "admin/support-tickets/manage/status";
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->status != null) {

            $statusUpdate = TicketStatus::where('id', $request->id)->update([
                'is_active' => $request->status,
            ]);
            Session::flash('message', [
                'text' => "Status has been changed successfully",
            ]);
            LogActivity::addToLog($request, 'Changed ib status status');
        }
        LogActivity::addToLog($request, 'Viewed ticket priority list');

        $dataSet = TicketStatus::all();
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
                'name' => 'required|regex:/^[A-Za-z\s]+$/|unique:ticket_statuses|max:255',
                'slug' => 'nullable|unique:ticket_statuses|max:255',
                'description' => 'nullable|max:65535',
                'is_active' => 'required|boolean',
            ],
            [
                'name.required' => 'Ticket Status name is required',
                'name.regex' => 'Ticket Status name should only contains letters',
                'name.max' => 'Ticket Status must be less then 255 characters',
                'name.unique' => 'Ticket Status is already exists, please choose a different name',
                'slug.unique' => 'Ticket status slug is exists please try different name',
                'slug.max' => 'Ticket status slug should not be greater than 255 character',
                'description.max' => 'Ticket status description should not be greater than 65,535 character',
                'is_active.required' => 'Select Ticket Status visible status',
                'is_active.boolean' => 'Ticket Status not selected kindly refresh page and try again',
            ],
        );

        if ($validator->fails()) {
            Session::flash('error', [
                'text' => $validator->errors()->first(),
            ]);
            return redirect()->back()->withInput();
        } else {
            $data = new TicketStatus();
            $data->name = $request->name;
            $data->slug = $request->slug;
            $data->description = $request->description;
            $data->is_active = $request->is_active;

            $result = $data->save();

            if ($result) {
                Session::flash('message', [
                    'text' => "Ticket Status is created",
                ]);
                LogActivity::addToLog($request, 'New Ticket Status created');
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

        $data = TicketStatus::find($id);

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

        $data = TicketStatus::find($id);

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
                'name' => 'required|regex:/^[A-Za-z\s]+$/|unique:ticket_statuses,name,' . $id . '|max:255',
                'slug' => 'nullable|unique:ticket_statuses,slug,' . $id . '|max:255',
                'description' => 'nullable|max:65535',
                'is_active' => 'required|boolean',
            ],
            [
                'name.required' => 'Ticket Priority name is required',
                'name.regex' => 'Ticket Status name should only contains letters',
                'name.max' => 'Ticket Priority must be less then 255 characters',
                'name.unique' => 'Ticket Priority is already exists, please choose a different name',
                'slug.unique' => 'Ticket status slug exists please change status name',
                'slug.max' => 'Ticket status slug should not be greater than 255 character',
                'description.max' => 'Ticket status description should not be greater than 65,535 character',
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
            $data = TicketStatus::find($id);
            $data->name = $request->name;
            $data->slug = $request->slug;
            $data->description = $request->description;
            $data->is_active = $request->is_active;
            $result = $data->save();

            if ($result) {
                Session::flash('message', [
                    'text' => "Record is updated",
                ]);
                LogActivity::addToLog($request, 'Support Ticket status updated');
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

        if (TicketStatus::where('id', $id)->exists()) {
            $result = TicketStatus::destroy($id);

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
