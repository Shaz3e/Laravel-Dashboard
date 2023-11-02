<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Models\Countries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CountriesController extends Controller
{
    // View & Route
    protected $view = "admin.locations.countries";
    protected $route = "admin/locations/countries";

    // Direcotry to save images
    protected $directory = '/countries/flags';

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->status != null) {

            $statusUpdate = Countries::where('id', $request->id)->update([
                'is_active' => $request->status,
            ]);
            Session::flash('message', [
                'text' => "Status has been changed successfully",
            ]);
            LogActivity::addToLog($request, 'Change status of country');
        }
        $countries = Countries::all();
        LogActivity::addToLog($request, 'Viewed countries');
        
        return view($this->view . '.index', 
        compact('countries')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view($this->view . '.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:countries|regex:/^[a-zA-Z ]+$/|max:255',
                'alpha2' => 'required|regex:/^[a-zA-Z]+$/|min:1|max:2',
                'alpha3' => 'required|regex:/^[a-zA-Z]+$/|min:1|max:3',
                'flag' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
                'currency' => 'required|regex:/^[a-zA-Z]+$/|max:3',
                'currency_code' => 'required|max:20',
                'calling_code' => 'required|regex:/^[0-9]+$/|max:11',
            ],
            [
                'name.required' => 'Country name is required',
                'name.unique' => 'Country name is already exists',
                'name.regex' => 'Country name only consists on alphabets only',
                'name.max' => 'Country name must be less then 255 characters',

                'alpha2.required' => 'Alpha2 is required',
                'alpha2.regex' => 'Alpha2 is only consists on alphabets',
                'alpha2.min' => 'Alpha2 must be at least 1 characters',
                'alpha2.max' => 'Alpha2 must be less then 2 characters',

                'alpha3.required' => 'Alpha3 is required',
                'alpha3.regex' => 'Alpha3 is is only consists on alphabets',
                'alpha3.min' => 'Alpha3 must be at least 1 characters',
                'alpha3.max' => 'Alpha3 must be less then 3 characters',

                'flag.required' => 'Flag is required',
                'flag.mimes' => 'Flag must be in (jpeg, jpg, png and svg format)',
                'flag.max' => 'Flag is too large (max size: 2MB)',

                'currency.required' => 'Currency is required',
                'currency.regex' => 'Currency is is only consists on alphabets',
                'currency.max' => 'Currency must be at least less then 3 characters',

                'currency_code.required' => 'Currency Code is required',
                'currency_code.max' => 'Currency Code must be at least 20 characters',
                'calling_code.required' => 'Calling Code is required',
                'calling_code.max' => 'Calling Code must be equal or less less then 11 digits',
            ],
        );

        if ($validator->fails()) {
            Session::flash('error', [
                'text' => $validator->errors()->first(),
            ]);
            return redirect()->back()->withInput();
        } else {

            $move_path = public_path() . $this->directory;
            $file = $request->flag;
            $ext = $request->file('flag')->getClientOriginalExtension();
            $custom_filename = str_replace(' ', '-', $request->name) . '.' . $ext;
            $flag = $request->file('flag')->storeAs($this->directory, $custom_filename);

            $data = new Countries();
            $data->name = $request->name;
            $data->alpha2 = $request->alpha2;
            $data->alpha3 = $request->alpha3;
            $data->flag = $flag;
            $data->currency = $request->currency;
            $data->currency_code = $request->currency_code;
            $data->calling_code = $request->calling_code;
            $data->is_active = $request->is_active;

            $file->move($move_path, $flag);

            $result = $data->save();
            if ($result) {
                Session::flash('message', [
                    'text' => "Country is created",
                ]);
                LogActivity::addToLog($request, 'New country created');
                return redirect($this->route);
            } else {
                Session::flash('errors', [
                    'text' => "Something went wrong, please try again",
                ]);
                return redirect()->back()->withInput();
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Countries::find($id);
        if ($data) {
            return view($this->view . '.edit', compact('data'));
        } else {
            return redirect($this->route)->with('warning', [
                'text' => "Country not found",
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $path = storage_path('app/storage/');
        $data = Countries::find($id);
        if ($data) {
            return view($this->view . '.edit', compact('data', 'path'));
        } else {
            return redirect($this->route)->with('warning', [
                'text' => "Country not found",
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
                'name' => 'required|unique:countries,name,' . $id . '|regex:/^[a-zA-Z ]+$/|max:255',
                'alpha2' => 'required|regex:/^[a-zA-Z]+$/|min:1|max:2',
                'alpha3' => 'required|regex:/^[a-zA-Z]+$/|min:1|max:3',
                'flag' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
                'currency' => 'required|regex:/^[a-zA-Z]+$/|max:3',
                'currency_code' => 'required|max:20',
                'calling_code' => 'required|regex:/^[0-9]+$/|max:11',
            ],
            [
                'name.required' => 'Country name is required',
                'name.unique' => 'Country name is already exists',
                'name.regex' => 'Country name only consists on alphabets only',
                'name.max' => 'Country name must be less then 255 characters)',

                'alpha2.required' => 'Alpha2 is required',
                'alpha2.regex' => 'Alpha2 is only consists on alphabets',
                'alpha2.min' => 'Alpha2 must be at least 1 characters',
                'alpha2.max' => 'Alpha2 must be less then 2 characters',

                'alpha3.required' => 'Alpha3 is required',
                'alpha3.regex' => 'Alpha3 is is only consists on alphabets',
                'alpha3.min' => 'Alpha3 must be at least 1 characters',
                'alpha3.max' => 'Alpha3 must be less then 3 characters',

                'flag.required' => 'Flag is required',
                'flag.mimes' => 'Flag must be in (jpeg, jpg, png and svg format)',
                'flag.max' => 'Flag is too large (max size: 2MB)',

                'currency.required' => 'Currency is required',
                'currency.regex' => 'Currency is is only consists on alphabets',
                'currency.max' => 'Currency must be at least less then 3 characters',

                'currency_code.required' => 'Currency Code is required',
                'currency_code.max' => 'Currency Code must be at least 20 characters',
                'calling_code.required' => 'Calling Code is required',
                'calling_code.max' => 'Calling Code must be equal or less less then 11 digits',
            ],
        );

        $data = Countries::find($id);
        $data->name = $request->name;
        $data->alpha2 = $request->alpha2;
        $data->alpha3 = $request->alpha3;
        $data->currency = $request->currency;
        $data->currency_code = $request->currency_code;
        $data->calling_code = $request->calling_code;
        $data->is_active = $request->is_active;

        if ($validator->fails()) {
            Session::flash('error', [
                'text' => $validator->errors()->first(),
            ]);
            return redirect()->back()->withInput();
        } else {
            if ($request->hasFile('flag')) {
                $file = $request->flag;
                $move_path = public_path() . $this->directory;
                $ext = $request->file('flag')->getClientOriginalExtension();
                $custom_filename = str_replace(' ', '-', $request->name) . '.' . $ext;
                $flag = $request->file('flag')->storeAs($this->directory, $custom_filename);
                $data->flag = $flag;
                $file->move($move_path, $flag);
            }
            $result = $data->save();
            if ($result) {
                Session::flash('message', [
                    'text' => "Country is updated",
                    'type' => 'success'
                ]);
                LogActivity::addToLog($request, 'Update country');
            } else {
                Session::flash('message', [
                    'text' => "Something went wrong, please try again",
                    'type' => 'warning'
                ]);
            }
        }
        return redirect($this->route)->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        global $request;

        if (Countries::where('id', $id)->exists()) {
            $result = Countries::destroy($id);
            if ($result) {
                Session::flash('message', [
                    'text' => 'Country has been deleted',
                ]);
                LogActivity::addToLog($request, 'Delete country');
            } else {
                Session::flash('warning', [
                    'text' => 'Something went wrong, please try again',
                ]);
            }
        } else {
            Session::flash('danger', [
                'text' => 'Country not found',
            ]);
        }
        return redirect($this->route);
    }

    /**
     * Get Country code
     */
    public function getCountryCode($countryId)
    {
        $country = Countries::where('id', $countryId)->first();

        // return response()->json(['calling_code' => $country->calling_code]);
        
        if ($country) {
            return response()->json(['internalCode' => $country->calling_code]);
        } else {
            return response()->json(['internalCode' => null]);
        }
    }
}
