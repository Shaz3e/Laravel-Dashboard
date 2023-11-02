<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\States;
use App\Models\Cities;

class CitiesController extends Controller
{
    // View & Route
    protected $view = "admin.locations.cities";
    protected $route = "admin/locations/cities";

    public function index(Request $request)
    {

        // if ($request->status != null) {
        //     $statusUpdate = Cities::where('id', $request->id)->update([
        //         'is_active' => $request->status,
        //     ]);
        //     Session::flash('message', [
        //         'text' => "Status has been changed successfully",
        //     ]);
        //     LogActivity::addToLog($request, 'Change status of city');
        // } else {
        //     LogActivity::addToLog($request, 'Viewed city');
        // }

        // $dataSet = Cities::select(
        //     'cities.*',
        //     'states.state_name as stateName',
        //     'countries.name as countryName',
        //     'countries.flag'
        // )
        //     ->leftJoin('states', 'states.id', 'cities.state_id')
        //     ->leftJoin('countries', 'countries.id', 'states.country_id')
        //     ->get();
        // return view($this->view . '.index', compact('dataSet'));

        if ($request->status != null) {

            $statusUpdate = States::where('id', $request->id)->update([
                'is_active' => $request->status,
            ]);
            Session::flash('message', [
                'text' => "Status has been changed successfully",
            ]);
            LogActivity::addToLog($request, 'Change status of city');
        }

        $dataSet = Cities::select(
            'cities.*',
            'states.state_name as stateName',
            'countries.name as countryName',
            'countries.flag'
        )
            ->leftJoin('states', 'states.id', 'cities.state_id')
            ->leftJoin('countries', 'countries.id', 'states.country_id')
            ->get();
        return view($this->view . '.index', compact('dataSet'));
    }

    public function create()
    {
        $dataSet = States::orderBy('state_name', 'ASC')->get();
        return view($this->view . '.create', compact('dataSet'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'state_id' => 'required',
                'city_name' => 'required|unique:cities|regex:/^[a-zA-Z ]+$/|max:255',
            ],
            [
                'state_id.required' => 'Please select country',
                'city_name.required' => 'City name is required',
                'city_name.unique' => 'City name is already exists',
                'city_name.regex' => 'City name only consists on alphabets only',
                'city_name.max' => 'City name must be less then 255 characters',
            ],
        );
        if ($validator->fails()) {

            Session::flash('error', [
                'text' => $validator->errors()->first(),
            ]);

            return redirect()->back()->withInput();
        } else {

            $data = new Cities();
            $data->state_id = $request->state_id;
            $data->city_name = $request->city_name;
            $data->is_active = $request->is_active;

            $result = $data->save();

            if ($result) {

                Session::flash('message', [
                    'text' => "City is created",
                ]);
                LogActivity::addToLog($request, 'New city created');
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
        $data = Cities::find($id);
        if ($data) {
            return view($this->view . '.edit', compact('data'));
        } else {
            return redirect($this->route)->with('warning', [
                'text' => "City not found",
            ]);
        }
    }

    public function edit(string $id)
    {
        $data = Cities::find($id);
        if ($data) {
            $dataSet = States::orderBy('state_name', 'ASC')->get();
            return view($this->view . '.edit', compact('data', 'dataSet'));
        } else {
            return redirect($this->route)->with('warning', [
                'text' => "City not found",
            ]);
        }
    }

    public function update(Request $request, string $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'state_id' => 'required',
                'city_name' => 'required|unique:cities,city_name,' . $id . '|regex:/^[a-zA-Z ]+$/|max:255',
            ],
            [
                'state_id.required' => 'Please select country',
                'city_name.required' => 'City name is required',
                'city_name.unique' => 'City name is already exists',
                'city_name.regex' => 'City name only consists on alphabets only',
                'city_name.max' => 'City name must be less then 255 characters',
            ],
        );

        $data = Cities::find($id);
        $data->state_id = $request->state_id;
        $data->city_name = $request->city_name;
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
                    'text' => "City is updated",
                    'type' => 'success'
                ]);
                LogActivity::addToLog($request, 'Update city');
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

        if (Cities::where('id', $id)->exists()) {
            $result = Cities::destroy($id);
            if ($result) {
                Session::flash('message', [
                    'text' => 'City has been deleted',
                ]);
                LogActivity::addToLog($request, 'Delete city');
            } else {
                Session::flash('warning', [
                    'text' => 'Something went wrong, please try again',
                ]);
            }
        } else {
            Session::flash('danger', [
                'text' => 'City not found',
            ]);
        }
        return redirect($this->route);
    }

    public function getCitiesByStates($state_id)
    {
        $cities = Cities::where('state_id', $state_id)->get();
        return response()->json($cities);
    }
}
