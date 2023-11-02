<?php

namespace App\Http\Controllers\User;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Mail\Admin\BecomeAnIb as AdminBecomeAnIb;
use App\Mail\NewTradingAccount;
use App\Mail\User\BecomeAnIb;
use App\Models\AccountTypes;
use App\Models\IbClients;
use App\Models\KycDocuments;
use App\Models\Ledgers;
use App\Models\Leverages;
use App\Models\TradingAccounts;
use App\Models\User;
use App\Models\Wallets;
use Illuminate\Http\Request;
use CMT5Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserDashboardController extends Controller
{
    // View Folder
    protected $view = 'user.';

    public function dashboard(Request $request)
    {
        // Define global when MT5 account does not have balance initially
        global $mt5Wallet;

        /**
         * Get all tradign account for auth user id
         */
        $tradingAccounts = TradingAccounts::where('user_id', auth()->user()->id)
            ->pluck('trading_account_number')
            ->implode(',');


        /**
         * IB Client Table
         */
        $ib_id = IbClients::where('user_id', auth()->user()->id)->value('id');
        $ib_status = IbClients::where('user_id', auth()->user()->id)->value('ib_status_id');
        $ib_agent = IbClients::where('user_id', auth()->user()->id)->value('agent_account');

        /**
         * Create MT5 Request to get balance of all accounts
         */
        $mt5Request = new CMT5Request();

        // Authenticate on the server using the Auth command
        if ($mt5Request->Init(DiligentCreators('mt5_server_ip') . ':' . DiligentCreators('mt5_server_port')) && $mt5Request->Auth(DiligentCreators('mt5_server_login'), DiligentCreators('mt5_server_password'), DiligentCreators('mt5_server_build'), DiligentCreators('mt5_server_agent'))) {

            /**
             * Get Multiple Users
             */
            $result = $mt5Request->Get('/api/user/get_batch?login=' . $tradingAccounts);

            if ($result != false) {
                $json = json_decode($result);

                if ((int)$json->retcode == 0) {
                    $get = $json->answer;

                    $array = []; // Initialize the $array variable as an empty array

                    foreach ($get as $key) {
                        $array[] = $key->Balance;
                    }
                    $mt5Wallet = array_sum($array);
                } else {
                    $result = false;
                }
            } else {
                $result = false;
            }
        } else {
            $result = false;
        }

        $commission = null;
        if ($mt5Request->Init(DiligentCreators('mt5_server_ip') . ':' . DiligentCreators('mt5_server_port')) && $mt5Request->Auth(DiligentCreators('mt5_server_login'), DiligentCreators('mt5_server_password'), DiligentCreators('mt5_server_build'), DiligentCreators('mt5_server_agent'))) {
            $result = $mt5Request->Get('/api/user/get?login=' . $ib_agent);
            if ($result != false) {
                $json = json_decode($result);
                if ((int)$json->retcode == 0) {
                    $get = $json->answer;
                    $commission = $get->Balance;
                }
            }
        } else {
            $result = false;
        }
        $mt5Request->Shutdown();

        // Chart Data
        $depositDataSet = [];
        $withdrawDataSet = [];
        $internaldepositDataSet = [];
        $internalwithdrawDataSet = [];

        for ($i = 1; $i <= 12; $i++) {

            // Default Variables
            $depositValue = 0;
            $withdrawValue = 0;
            $internaldepositValue = 0;
            $internalwithdrawValue = 0;

            // Variables
            $month = ($i > 9) ? $i : "0" . $i;
            $startDate = now()->year . "-" . $month . "-01 00:00:00";
            $endDate = now()->year . "-" . $month . "-31 23:59:59";

            // Deposit
            $depositData = Ledgers::where('user_id', auth()->user()->id)->where('transaction_status_id', 3)->where('is_internal', 0)->where('deposit', '!=', '')->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->get();
            foreach ($depositData as $depositDataValue) {
                $depositValue += $depositDataValue->deposit;
            }
            $depositDataSet += [$i => $depositValue];

            // Withdraw
            $withdrawData = Ledgers::where('user_id', auth()->user()->id)->where('transaction_status_id', 3)->where('is_internal', 0)->where('withdraw', '!=', '')->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->get();
            foreach ($withdrawData as $withdrawDataValue) {
                $withdrawValue += $withdrawDataValue->withdraw;
            }
            $withdrawDataSet += [$i => $withdrawValue];

            // Internal Deposit
            $internaldepositData = Ledgers::where('user_id', auth()->user()->id)->where('is_internal', 1)->where('deposit', '!=', '')->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->get();
            foreach ($internaldepositData as $internaldepositDataValue) {
                $internaldepositValue += $internaldepositDataValue->deposit;
            }
            $internaldepositDataSet += [$i => $internaldepositValue];

            // Internal Withdraw
            $internalwithdrawData = Ledgers::where('user_id', auth()->user()->id)->where('is_internal', 1)->where('withdraw', '!=', '')->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->get();
            foreach ($internalwithdrawData as $internalwithdrawDataValue) {
                $internalwithdrawValue += $internalwithdrawDataValue->withdraw;
            }
            $internalwithdrawDataSet += [$i => $internalwithdrawValue];
        }

        // Trading Accounts
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


        $tradingAccountTypeDataSet = AccountTypes::where('is_active', 1)->get();
        $leverageDataSet = Leverages::where('is_active', 1)->get();
        $tradingAccountdataSet = TradingAccounts::where("user_id", auth()->user()->id)->get();
        $totalTradingAccountdataSet = TradingAccounts::where("user_id", auth()->user()->id)->count();

        return view(
            $this->view . 'dashboard',
            compact(
                'mt5Wallet',
                'ib_id',
                'ib_status',
                'commission',
                'depositDataSet',
                'withdrawDataSet',
                'internaldepositDataSet',
                'internalwithdrawDataSet',
                'tradingAccountTypeDataSet',
                'leverageDataSet',
                'tradingAccountdataSet',
                'totalTradingAccountdataSet'
            )
        );
    }


    /**
     * Create IB Account Request
     */
    public function becomeIbClient(Request $request)
    {
        $user_id = auth()->user()->id;

        $data = new IbClients();
        $data->user_id = $user_id;
        $data->ib_status_id = 1;
        $result = $data->save();

        if ($result) {
            // Prepare Mail Data
            $mailData = [
                'email' => Auth::user()->email,
                'first_name' => Auth::user()->first_name,
                'last_name' => Auth::user()->last_name,
                'ib_request_link' => DiligentCreators('dashboard_url').'/admin/ib-clients?id='.$data->id,
            ];
            // Add to Log
            LogActivity::addToLog($request, $mailData['first_name'].' '.$mailData['last_name'].' Wants to become an IB');

            // Send Email to Client
            $clientEmail = Mail::to($mailData['email'])->send(new BecomeAnIb($mailData));
            $adminEmail = Mail::to(DiligentCreators('to_email'))->send(new AdminBecomeAnIb($mailData));

            if($clientEmail){
                LogActivity::addToLog($request, 'Email has been sent to '. $mailData['first_name'].' '.$mailData['last_name']. ' at '. $mailData['email']);
                if($adminEmail){
                    LogActivity::addToLog($request, 'IB Request from '.$mailData['first_name'].' '.$mailData['last_name'].' sent to back office.');
                    Session::flash('message', [
                        'text' => 'IB Request has been sent to back office',
                    ]);
                }
            }


        } else {
            Session::flash('error', [
                'text' => 'Something went wrong, please try again',
            ]);
        }
        return redirect()->back();
    }



    public function createTradingAccount(Request $request)
    {
        $limitExceed = false;

        $id = auth()->user()->id;
        $totalTradingAccounts = TradingAccounts::where("user_id", auth()->user()->id)->get()->count();

        $validator = Validator::make(
            $request->all(),
            [
                'account_type_id' => 'required',
                'leverage_id' => 'required',
            ],
            [
                'account_type_id.required' => 'Account Type is required',
                'leverage_id.required' => 'Leverage is required',
            ],
        );

        if ($validator->fails()) {
            Session::flash('error', [
                'text' => $validator->errors()->first(),
            ]);
        } else {
            $account_type_id = $request->account_type_id;
            $leverage =  $request->leverage_id;

            // Required
            $masterPassword = GeneratePassword();
            $investorPassword = GeneratePassword();

            // MT5
            if ($totalTradingAccounts < DiligentCreators('mt5_trading_accounts_limit')) {
                $mt5Request = new CMT5Request();
                if ($mt5Request->Init(DiligentCreators('mt5_server_ip') . ':' . DiligentCreators('mt5_server_port')) && $mt5Request->Auth(DiligentCreators('mt5_server_login'), DiligentCreators('mt5_server_password'), DiligentCreators('mt5_server_build'), DiligentCreators('mt5_server_agent'))) {
                    $mt5Result = $mt5Request->Get('/api/user/add?login=0&pass_main=' . $masterPassword . '&pass_investor=' . $investorPassword . '&group=' . GetAccountType($account_type_id) . '&name=' . Auth::user()->first_name . '&email=' . Auth::user()->email . '&leverage=' . $leverage);
                    
                    
                    if ($mt5Result != false) {
                        $json = json_decode($mt5Result);
                        
                        if ((int)$json->retcode == 0) {
                            $answer = $json->answer;
                            $mt5TradingAccountNumber = $answer->Login;

                            if ((int)$answer->Login == true) {
                                $mt5Result = $mt5Request->Get('/api/user/get?login=' . $answer->Login);

                                if ($mt5Result != false) {
                                    $json = json_decode($mt5Result);

                                    if ((int)$json->retcode == 0) {
                                        $get = $json->answer;
                                        $get->Name = Auth::user()->first_name . " " . Auth::user()->last_name;
                                        $get->FirstName = Auth::user()->first_name;
                                        $get->LastName = Auth::user()->last_name;
                                        $get->Country = GetCountry(Auth::user()->country);
                                        $get->Phone = Auth::user()->mobile;
                                        $get->Email = Auth::user()->email;

                                        $mt5Result = $request->Post('/api/user/update', json_encode($get));

                                        if ($mt5Result != false) {

                                            $wallet_id = Wallets::where('user_id', $id)->value('id');

                                            // Create Trading Account
                                            $tradingAccountData = new TradingAccounts();
                                            $tradingAccountData->user_id = $id;
                                            $tradingAccountData->wallet_id = $wallet_id;
                                            $tradingAccountData->account_status_id = 1;
                                            $tradingAccountData->account_type_id = $account_type_id;
                                            $tradingAccountData->trading_account_number = $mt5TradingAccountNumber;
                                            $tradingAccountData->master_password = Hash::make($masterPassword);
                                            $tradingAccountData->investor_password = Hash::make($investorPassword);
                                            $tradingAccountData->leverage = $leverage;

                                            if ($tradingAccountData->save()) {
                                                LogActivity::addToLog($request, Auth::user()->first_name . ' ' . Auth::user()->last_name . ' created new trading account# ' . $mt5TradingAccountNumber);
                                                $result = true;
                                            } else {
                                                $result = false;
                                            }
                                        } else {
                                            $result = false;
                                        }
                                    } else {
                                        $result = false;
                                    }
                                } else {
                                    $result = false;
                                }
                            } else {
                                $result = false;
                            }
                        } else {
                            $result = false;
                        }
                    } else {
                        $result = false;
                    }
                } else {
                    $result = false;
                }
                $mt5Request->Shutdown();
            } else {
                $limitExceed = true;
            }

            if ($limitExceed) {
                LogActivity::addToLog($request, 'creating tradding account but limited exceeded');
                Session::flash('error', [
                    'text' => "Sorry! your account limit exceed. (only" . $totalTradingAccounts . " accounts allowed)",
                ]);
            } else {
                if ($result) {
                    // Send email
                    $user = Auth::user();
                    $mailData = [
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name,
                        'email' => $user->email,
                        'mt5Account' => $mt5TradingAccountNumber,
                        'masterPassword' => $masterPassword,
                        'investorPassword' => $investorPassword,
                    ];
                    $emailSent = Mail::to($mailData['email'])->send(new NewTradingAccount($mailData));
                    if ($emailSent) {
                        LogActivity::addToLog($request, 'new trading account details has been sent to ' . $user->email);
                    } else {
                        LogActivity::addToLog($request, 'Email could not be sent');
                    }
                    Session::flash('message', [
                        'text' => "Trading account created successfully and details has been sent to via email.",
                    ]);
                } else {
                    Session::flash('error', [
                        'text' => "Something went wrong, please try again",
                    ]);
                }
            }
        }
        return redirect()->back()->withInput();
    }
}
