<?php

namespace App\Http\Controllers\User;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Mail\Admin\ChangeAgentAccountPassword;
use App\Models\AccountTypes;
use App\Models\IbClients;
use App\Models\KycDocuments;
use App\Models\LoginHistories;
use App\Models\TradingAccounts;
use App\Models\User;
use App\Models\Wallets;
use CMT5Request;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserProfileController extends Controller
{

    // View folder name
    protected $view = "user.profile.";

    // route name
    protected $route = "profile";

    // Direcotry to save KYC Document
    protected $directory = '/kyc';


    /**
     * Display a listing of the resource.
     */
    public function View(Request $request)
    {
        if ($request->account != null) {
            $mt5Request = new CMT5Request();
            if ($mt5Request->Init(DiligentCreators('mt5_server_ip') . ':' . DiligentCreators('mt5_server_port')) && $mt5Request->Auth(DiligentCreators('mt5_server_login'), DiligentCreators('mt5_server_password'), DiligentCreators('mt5_server_build'), DiligentCreators('mt5_server_agent'))) {
                $result = $mt5Request->Get('/api/user/account/get_batch?login=' . $request->account);

                if ($result != false) {
                    $json = json_decode($result);

                    if ((int)$json->retcode == 0) {
                        $get = $json->answer;

                        foreach ($get as $key => $value) {
                            if ($key == 0) {
                                $credit = $value->Credit;
                                $balance = $value->MarginFree - $value->Credit;
                                $accountUpdate = TradingAccounts::where('trading_account_number', $request->account)->update([
                                    'balance' => $balance,
                                    'credit' => $credit,
                                ]);
                            }
                        }
                    }
                } else {
                    $result = false;
                }
            }

            Session::flash('message', [
                'text' => "Trading account is updated",
            ]);
        }

        $data = User::find(auth()->user()->id);

        $tradingAccountTypeDataSet = AccountTypes::where('is_active', 1)->get();
        $tradingAccountdataSet = TradingAccounts::where("user_id", auth()->user()->id)->get();
        $totalTradingAccountdataSet = TradingAccounts::where("user_id", auth()->user()->id)->count();

        $loginHistory = LoginHistories::where('user_id', $data->id)->get();

        // Caculate Age
        $dateOfBirth = $data->dob;
        $age = Carbon::parse($dateOfBirth)->age;
        LogActivity::addToLog($request, 'viewed profile');


        return view(
            $this->view . 'index',
            compact(
                'age',
                'data',
                'tradingAccountTypeDataSet',
                'tradingAccountdataSet',
                'totalTradingAccountdataSet',
                'loginHistory'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function Update(Request $request)
    {
        $limitExceed = false;

        if ($request->has('username')) {

            $id = auth()->user()->id;
            $data = User::find($id);

            $validator = Validator::make(
                $request->all(),
                [
                    // 'email' => 'required|max:255|email|unique:users,email,' . $id,
                    // 'first_name' => 'required|regex:/^[a-zA-Z]+$/|max:255',
                    // 'last_name' => 'required|regex:/^[a-zA-Z]+$/|max:255',
                    'username' => 'nullable|regex:/^[a-zA-Z0-9]*$/|max:50|unique:users,username,' . $id,
                    // 'mobile' => 'required|regex:/^[0-9+]+$/|unique:users,mobile,' . $id,
                    // 'dob' => 'required|date',
                    'company' => 'max:255',
                    'house_number' => 'required|max:255',
                    'address1' => 'required|max:255',
                    'address2' => 'max:255',
                ],
                [
                    // 'email.required' => 'Email is required',
                    // 'email.email' => 'Email is invalid',
                    // 'email.unique' => 'Email already exists',
                    // 'email.max' => 'Email must be less then 255 characters',

                    // 'first_name.required' => 'First Name is required',
                    // 'first_name.regex' => 'Space not allowed in First Name',
                    // 'first_name.max' => 'First Name must be less then 255 characters',

                    // 'last_name.required' => 'Last Name is required',
                    // 'last_name.regex' => 'Space not allowed in Last Name',
                    // 'last_name.max' => 'Last Name must be less then 255 characters',

                    'username.unique' => 'User Name already exists',
                    'username.max' => 'User Name must be less then 50 characters',
                    'username.regex' => 'Username must contain alphabet or number no special character or spaces are allowed.',

                    // 'mobile.required' => 'Mobile Number is required',
                    // 'mobile.regex' => 'Mobile is invalid',
                    // 'mobile.unique' => 'Mobile already exists',
                    // 'mobile.min' => 'Mobile must be at least 10 digits',
                    // 'mobile.max' => 'Mobile must be less then 13 digits',

                    // 'dob.required' => 'Date of birth is required',
                    // 'dob.date' => 'Date of birth is invalid',

                    'account_type_id.required' => 'Account type is required',
                    'account_type_id.numeric' => 'Account type is invalid',

                    // 'company.required' => 'Company is required',
                    'company.max' => 'Company must be less then 255 characters',

                    'house_number.required' => 'House Number is required',
                    'house_number.max' => 'House Number must be less then 255 characters',

                    'address1.required' => 'Address is required',
                    'address1.max' => 'Address must be less then 255 characters',

                    'address2.max' => 'address2 must be less then 255 characters',
                ],
            );

            // $data->email = $request->email;
            // $data->first_name = $request->first_name;
            // $data->last_name = $request->last_name;
            // $data->mobile = $request->mobile;
            $data->username = $request->username;
            // $data->dob = $request->dob;
            $data->company = $request->company;
            $data->house_number = $request->house_number;
            $data->address1 = $request->address1;
            $data->address2 = $request->address2;

            if ($validator->fails()) {
                Session::flash('error', [
                    'text' => $validator->errors()->first(),
                ]);
            } else {
                $result = $data->save();
                LogActivity::addToLog($request, 'update profile');
                if ($result) {
                    Session::flash('message', [
                        'text' => "Profile updated",
                    ]);
                } else {
                    Session::flash('errors', [
                        'text' => "Something went wrong, please try again",
                    ]);
                }
            }

            return redirect()->back()->withInput();
        } else if ($request->has('password')) {

            $id = auth()->user()->id;
            $data = User::find($id);

            $validator = Validator::make(
                $request->all(),
                [
                    'password' => 'required',
                    'new_password' => 'required|min:8|max:64',
                    'confirm_new_password' => 'required|same:new_password',
                ],
                [
                    'password.required' => 'Current Password is required',

                    'new_password.required' => 'New Password is required',
                    'new_password.password' => 'New Password must be different then password',
                    'new_password.min' => 'New Password must be at least 8 characters',
                    'new_password.max' => 'New Password must be less then 64 characters',

                    'confirm_new_password.required' => 'Confirm New Password is required',
                    'confirm_new_password.same' => 'Confirm New Password does not matched',
                ],
            );

            if ($validator->fails()) {
                Session::flash('error', [
                    'text' => $validator->errors()->first(),
                ]);
            } else {
                if (Hash::check($request->password, $data->password)) {
                    $data->password = Hash::make($request->new_password);
                    $result = $data->save();
                    LogActivity::addToLog($request, 'changed password');

                    if ($result) {
                        Session::flash('message', [
                            'text' => "Password updated",
                        ]);
                    } else {
                        Session::flash('errors', [
                            'text' => "Something went wrong, please try again",
                        ]);
                    }
                } else {
                    Session::flash('error', [
                        'text' => 'Incorrect current password',
                    ]);
                }
            }
            return redirect()->back()->withInput();
        }
    }

    /**
     * Upload KYC
     */
    public function UpdateKyc(Request $request)
    {
        $user_id = User::where('id', auth()->user()->id)->value('id');

        $validator = Validator::make(
            $request->all(),
            [
                'id_card_number' => 'required',
                'id_proof_address' => 'required',
                'id_side_a' => 'required|mimetypes:image/jpeg,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,image/png,image/jpeg|max:2048',
                'id_side_b' => 'required|mimetypes:image/jpeg,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,image/png,image/jpeg|max:2048',
                'proof_address' => 'required|mimetypes:image/jpeg,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,image/png,image/jpeg|max:2048',
            ],
            [
                'id_card_number.required' => 'Please enter national id card number',
                'id_proof_address.required' => 'Please proof address',

                'id_side_a.required' => 'Identification (Front Side) is required',
                'id_side_a.mimetypes' => 'Identification (Front Side) must be in (jpeg, jpg, png and pdf format)',
                'id_side_a.max' => 'Identification (Front Side) is too large (max size: 2MB)',

                'id_side_b.required' => 'Identification (Back Side) is required',
                'id_side_b.mimetypes' => 'Identification (Back Side) must be in (jpeg, jpg, png and pdf format)',
                'id_side_b.max' => 'Identification (Back Side) is too large (max size: 2MB)',

                'proof_address.required' => 'Proof Address is required',
                'proof_address.mimetypes' => 'Proof Address must be in (jpeg, jpg, png and pdf format)',
                'proof_address.max' => 'Proof Address is too large (max size: 2MB)',
            ],
        );

        if ($validator->fails()) {
            Session::flash('error', [
                'text' => $validator->errors()->first(),
            ]);
            return redirect()->back()->withInput();
        } else {
            /**
             * Upload KYC Directory
             */
            $move_path = public_path() . $this->directory;

            /**
             * ID Side A
             * @param id_side_a
             */
            $id_side_a = $user_id . '-id_side_a';
            $id_side_a_file = $request->id_side_a;
            $ext = $request->file('id_side_a')->getClientOriginalExtension();
            $id_side_a = $request->file('id_side_a')->storeAs($this->directory, $id_side_a . '.' . $ext);
            $move_id_side_a_file = $id_side_a_file->move($move_path, $id_side_a);

            /**
             * ID Side B
             * @param id_side_b
             */
            $id_side_b = $user_id . '-id_side_b';
            $id_side_b_file = $request->id_side_b;
            $ext = $request->file('id_side_b')->getClientOriginalExtension();
            $id_side_b = $request->file('id_side_b')->storeAs($this->directory, $id_side_b . '.' . $ext);
            $move_id_side_b_file = $id_side_b_file->move($move_path, $id_side_b);

            /**
             * Payment Proof
             * @param proof_address
             */
            $proof_address = $user_id . '-proof_address';
            $proof_address_file = $request->proof_address;
            $ext = $request->file('proof_address')->getClientOriginalExtension();
            $proof_address = $request->file('proof_address')->storeAs($this->directory, $proof_address . '.' . $ext);
            $move_proof_address_file = $proof_address_file->move($move_path, $proof_address);

            if ($move_id_side_a_file && $move_id_side_b_file && $move_proof_address_file) {

                /**
                 * Create KYC Record
                 */
                $data = new KycDocuments();
                $data->user_id = $user_id;
                $data->kyc_status_id = 4;
                $data->id_card_number = $request->id_card_number;
                $data->id_proof_address = $request->id_proof_address;
                $data->id_side_a = $id_side_a;
                $data->id_side_b = $id_side_b;
                $data->proof_address = $proof_address;
                $result = $data->save();

                /**
                 * Change KYC Status ID in @param users table
                 */
                User::where('id', $user_id)->update(['kyc_status_id' => 4]);

                if ($result) {
                    Session::flash('message', [
                        'text' => 'KYC Document uploaded and request has been sent to back office'
                    ]);
                }
            } else {
                Session::flash('error', [
                    'text' => 'Could not upload document, please try again'
                ]);
            }
            return redirect()->back();
        }
    }

    public function agentAccount(){
        $agent_account = IbClients::where('user_id', Auth::user()->id)->value('agent_account');

        return view(
            $this->view . 'agent-account.index',
            compact(
                'agent_account'
            )
        );
    }

    public function changeAgentAccount(Request $request)
    {
        $agent_account = IbClients::where('user_id', Auth::user()->id)->value('agent_account');

        // Change Agent Account Password
        if ($request->has('changeAgentAccountPassword')) {

            $validator = Validator::make(
                $request->all(),
                [
                    'password' => 'required|min:8|max:16',
                ],
                [
                    'password.required' => 'Please type master password',
                    'password.min' => 'Password must be at least 8 characters',
                    'password.max' => 'Password must be at most 16 characters',
                ],
            );

            if ($validator->fails()) {
                Session::flash('error', [
                    'text' => $validator->errors()->first(),
                ]);
                return redirect()->back()->withInput();
            } else {

                // Initialize
                $mt5Request = new CMT5Request();

                if ($mt5Request->Init(DiligentCreators('mt5_server_ip') . ':' . DiligentCreators('mt5_server_port')) && $mt5Request->Auth(DiligentCreators('mt5_server_login'), DiligentCreators('mt5_server_password'), DiligentCreators('mt5_server_build'), DiligentCreators('mt5_server_agent'))) {
                    // Changing Master Password
                    $mt5Result = $mt5Request->Get('/api/user/change_password?login=' . $agent_account . '&type=main&password=' . $request->password);

                    if ($mt5Result != false) {
                        $json = json_decode($mt5Result);

                        if ((int)$json->retcode == 0) {
                            // Changing Investor Password
                            $mt5Result = $mt5Request->Get('/api/user/change_password?login=' . $agent_account . '&type=investor&password=' . $request->password);

                            if ($mt5Result != false) {
                                $json = json_decode($mt5Result);

                                if ((int)$json->retcode == 0) {

                                    // Get current user data
                                    $data = User::where('id', Auth::user()->id)->first();

                                    // Prepair mail data
                                    $mailData = [
                                        'first_name' => $data->first_name,
                                        'last_name' => $data->last_name,
                                        'email' => $data->email,
                                        'agent_account' => $agent_account,
                                        'password' => $request->password
                                    ];

                                    $sendEmail = Mail::to($mailData['email'])->send(new ChangeAgentAccountPassword($mailData));

                                    if ($sendEmail) {
                                        LogActivity::addToLog($request, $mailData['first_name'] . ' ' . $mailData['last_name'] . ' Changed password for agent account# ' . $agent_account);
                                        LogActivity::addToLog($request, 'Email has been sent to ' . $mailData['email']);
                                        Session::flash('message', [
                                            'text' => 'Agent account password has been changed'
                                        ]);
                                    } else {
                                        Session::flash('error', [
                                            'text' => 'Agent account password could not be changed. Try again.'
                                        ]);
                                    }
                                }
                            }
                        }
                    } else {
                        LogActivity::addToLog($request, 'Could not connect to MT5 server');
                    }
                }
                $mt5Request->Shutdown();
            }
        }

        return redirect()->back();
    }
}
