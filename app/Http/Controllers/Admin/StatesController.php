<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;

use App\Models\Countries;
use App\Models\States;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class StatesController extends Controller
{
    // View & Route
    protected $view = "admin.locations.states";
    protected $route = "admin/locations/states";

    public function index(Request $request)
    {

        if ($request->status != null) {

            $statusUpdate = States::where('id', $request->id)->update([
                'is_active' => $request->status,
            ]);
            Session::flash('message', [
                'text' => "Status has been changed successfully",
            ]);
            LogActivity::addToLog($request, 'Change status of state');
        }

        $dataSet = States::select(
            'states.*',
            'countries.name as countryName',
            'countries.flag as flag'
        )
            ->leftJoin('countries', 'countries.id', 'states.country_id')
            ->paginate(100);
        LogActivity::addToLog($request, 'Viewed States');
        return view(
            $this->view . '.index',
            [
                'dataSet' => $dataSet
            ]
        );
    }


    public function create()
    {

        $dataSet = Countries::orderBy('name', 'ASC')->get();
        return view($this->view . '.create', compact('dataSet'));
    }


    public function store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'country_id' => 'required',
                'state_name' => 'required|unique:states|regex:/^[a-zA-Z ]+$/|max:255',
            ],
            [
                'country_id.required' => 'Please select country',

                'state_name.required' => 'State name is required',
                'state_name.unique' => 'State name is already exists',
                'state_name.regex' => 'State name only consists on alphabets only',
                'state_name.max' => 'State name must be less then 255 characters',
            ],
        );
        if ($validator->fails()) {
            Session::flash('error', [
                'text' => $validator->errors()->first(),
            ]);
            return redirect()->back()->withInput();
        } else {
            $data = new States();
            $data->country_id = $request->country_id;
            $data->state_name = $request->state_name;
            $data->is_active = $request->is_active;

            $result = $data->save();

            if ($result) {
                Session::flash('message', [
                    'text' => "State is created",
                ]);
                LogActivity::addToLog($request, 'New state created');
                return redirect($this->route);
            } else {
                Session::flash('errors', [
                    'text' => "Something went wrong, please try again",
                ]);
                return redirect()->back()->withInput();
            }
        }
    }


    public function show(string $id)
    {

        $data = States::find($id);
        if ($data) {
            return view($this->view . '.edit', compact('data'));
        } else {
            return redirect($this->route)->with('warning', [
                'text' => "State not found",
            ]);
        }
    }


    public function edit(string $id)
    {

        $data = States::find($id);
        if ($data) {
            $dataSet = Countries::orderBy('name', 'ASC')->get();
            return view($this->view . '.edit', compact('data', 'dataSet'));
        } else {
            return redirect($this->route)->with('warning', [
                'text' => "State not found",
            ]);
        }
    }


    public function update(Request $request, string $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'country_id' => 'required',
                'state_name' => 'required|unique:states,state_name,' . $id . '|regex:/^[a-zA-Z ]+$/|max:255',
            ],
            [
                'country_id.required' => 'Please select country',
                'state_name.required' => 'State name is required',
                'state_name.unique' => 'State name is already exists',
                'state_name.regex' => 'State name only consists on alphabets only',
                'state_name.max' => 'State name must be less then 255 characters',
            ],
        );

        $data = States::find($id);
        $data->country_id = $request->country_id;
        $data->state_name = $request->state_name;
        $data->is_active = $request->is_active;

        if ($validator->fails()) {
            Session::flash('error', [
                'text' => $validator->errors()->first(),
            ]);
            return redirect()->back()->withInput();
        } else {
            $result = $data->save();
            if ($result) {
                Session::flash('message', [
                    'text' => "State is updated",
                    'type' => 'success'
                ]);
                LogActivity::addToLog($request, 'Update state');
            } else {
                Session::flash('message', [
                    'text' => "Something went wrong, please try again",
                    'type' => 'warning'
                ]);
            }
        }
        return redirect($this->route)->withInput();
    }


    public function destroy(string $id)
    {
        global $request;

        if (States::where('id', $id)->exists()) {
            $result = States::destroy($id);
            if ($result) {
                Session::flash('message', [
                    'text' => 'State has been deleted',
                ]);
                LogActivity::addToLog($request, 'Delete state');
            } else {
                Session::flash('warning', [
                    'text' => 'Something went wrong, please try again',
                ]);
            }
        } else {
            Session::flash('danger', [
                'text' => 'State not found',
            ]);
        }
        return redirect($this->route);
    }

    public function getStatesByCountry(Request $request, string $country_id)
    {
        $states = States::where('country_id', $country_id)->get();
        return response()->json($states);
    }
}
