<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;

use App\Models\AppSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class MailSettingsController extends Controller
{
    // View folder name
    protected $view = "admin/mail-settings";

    // route name
    protected $route = "admin/mail-settings";

    public function view()
    {
        global $request;
        $smtp_host = AppSettings::where('setting_name', 'smtp_host')->value('setting_value');
        $smtp_email = AppSettings::where('setting_name', 'smtp_email')->value('setting_value');
        $smtp_password = AppSettings::where('setting_name', 'smtp_password')->value('setting_value');
        $smtp_port = AppSettings::where('setting_name', 'smtp_port')->value('setting_value');
        $smtp_secure = AppSettings::where('setting_name', 'smtp_secure')->value('setting_value');
        $from_name = AppSettings::where('setting_name', 'from_name')->value('setting_value');
        $from_email = AppSettings::where('setting_name', 'from_email')->value('setting_value');
        $to_email = AppSettings::where('setting_name', 'to_email')->value('setting_value');
        $bcc_email = AppSettings::where('setting_name', 'bcc_email')->value('setting_value');

        $dataSet = [
            'smtp_host' => $smtp_host,
            'smtp_email' => $smtp_email,
            'smtp_password' => $smtp_password,
            'smtp_port' => $smtp_port,
            'smtp_secure' => $smtp_secure,
            'from_name' => $from_name,
            'from_email' => $from_email,
            'to_email' => $to_email,
            'bcc_email' => $bcc_email,
        ];
        LogActivity::addToLog($request, 'Viewed Email setup');
        return view($this->view . '.index', compact('dataSet'));
    }

    public function postData(Request $request)
    {
        

        $validator = Validator::make(
            $request->all(),
            [
                'smtp_host' => 'required|regex:/^(?!:\/\/)(?=.{1,255}$)((.{1,63}\.){1,127}(?![0-9]*$)[a-z0-9-]+\.?)$/i|max:255',
                'smtp_email' => 'required|email|max:255',
                'smtp_password' => 'required|min:8|max:64',
                'smtp_port' => 'required|digits_between:2,6',
                'smtp_secure' => 'required|max:255',
                'from_name' => 'required|max:255',
                'from_email' => 'required|email|max:255',
                'to_email' => 'required|email|max:255',
                'bcc_email' => 'required|email|max:255',
            ],
            [
                'smtp_host.required' => 'Smtp host is required',
                'smtp_host.regex' => 'SMTP Host is invalid.',
                'smtp_host.max' => 'Smtp host must me less then 255 characters.',
                'smtp_email.required' => 'Smtp email is required',
                'smtp_email.max' => 'Smtp email must me less then 255 characters.',
                'smtp_password.required' => 'Smtp password is required',
                'smtp_password.max' => 'Smtp password must me less then 64 characters.',
                'smtp_port.required' => 'Smtp port is required',
                'smtp_port.digits_between' => 'Smtp port must me between 2 to 6 characters.',
                'smtp_secure.required' => 'Smtp secure is required',
                'smtp_secure.max' => 'Smtp secure must me less then 255 characters.',
                'from_name.required' => 'From name is required',
                'from_name.max' => 'From name must me less then 255 characters.',
                'from_email.required' => 'From email is required',
                'from_email.email' => 'From email is invalid.',
                'from_email.max' => 'From email must me less then 255 characters.',
                'to_email.required' => 'To email is required',
                'to_email.email' => 'To email is invalid.',
                'to_email.max' => 'To email must me less then 255 characters.',
                'bcc_email.required' => 'Bcc email is required',
                'bcc_email.email' => 'Bcc email is invalid.',
                'bcc_email.max' => 'Bcc email must me less then 255 characters.',
            ],
        );

        if ($validator->fails()) {
            Session::flash('error', [
                'text' => $validator->errors()->first(),
            ]);
            return redirect()->back()->withInput();
        } else {
            // Update or create the settings
            AppSettings::updateOrCreate(
                ['setting_name' => 'smtp_host'],
                ['setting_value' => $request->smtp_host]
            );

            AppSettings::updateOrCreate(
                ['setting_name' => 'smtp_email'],
                ['setting_value' => $request->smtp_email]
            );

            AppSettings::updateOrCreate(
                ['setting_name' => 'smtp_password'],
                ['setting_value' => $request->smtp_password]
            );

            AppSettings::updateOrCreate(
                ['setting_name' => 'smtp_port'],
                ['setting_value' => $request->smtp_port]
            );

            AppSettings::updateOrCreate(
                ['setting_name' => 'smtp_secure'],
                ['setting_value' => $request->smtp_secure]
            );

            AppSettings::updateOrCreate(
                ['setting_name' => 'from_name'],
                ['setting_value' => $request->from_name]
            );

            AppSettings::updateOrCreate(
                ['setting_name' => 'from_email'],
                ['setting_value' => $request->from_email]
            );

            AppSettings::updateOrCreate(
                ['setting_name' => 'to_email'],
                ['setting_value' => $request->to_email]
            );

            AppSettings::updateOrCreate(
                ['setting_name' => 'bcc_email'],
                ['setting_value' => $request->bcc_email]
            );

            Session::flash('message', [
                'text' => 'Mail settings updated',
                'type' => 'success'
            ]);

            $envPath = base_path('.env');
            $envContent = File::get($envPath);

            $envData = [
                'MAIL_HOST' => $request->smtp_host,
                'MAIL_PORT' => $request->smtp_port,
                'MAIL_USERNAME' => $request->smtp_email,
                'MAIL_PASSWORD' => $request->smtp_password,
                'MAIL_ENCRYPTION' => $request->smtp_secure,
                'MAIL_FROM_ADDRESS' => $request->from_email,
                'MAIL_FROM_NAME' => "'$request->from_name'",
            ];

            // Update the key-value pairs
            foreach ($envData as $key => $value) {
                $envContent = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $envContent);
            }

            File::put($envPath, $envContent);

            LogActivity::addToLog($request, 'Update mail settings');
            
            Artisan::call('optimize');
            return redirect()->back();
        }
    }
}
