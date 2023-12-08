<?php

namespace App\Http\Controllers\Admin;

use App\Models\AppSettings;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AppSettingsController extends Controller
{
    // View & Route
    protected $view = "admin.app-settings.";
    protected $route = "admin/app-settings/";

    // Brand Logo Directory
    protected $directory = '/logos';

    /**
     * App Setting Root
     */
    public function appSettings()
    {    
        return view($this->view . 'app-settings');
    }
    public function appSettingsPost(Request $request)
    {
        
        if ($request->settings == 'optimize_clear') {
            Session::flash('message', [
                'text' => "System has been optimized",
            ]);
            Artisan::call('optimize:clear');
        }

        if ($request->settings == 'optimize') {
            Session::flash('message', [
                'text' => "System has been optimized",
            ]);
            Artisan::call('optimize');
        }
        if ($request->settings == 'system-route-cache') {
            Session::flash('message', [
                'text' => "Route cache has been purged",
            ]);
            Artisan::call('route:cache');
        }

        if ($request->settings == 'system-config-cache') {
            Session::flash('message', [
                'text' => "Config cache has been purged",
            ]);
            Artisan::call('route:cache');
        }

        if ($request->settings == 'system-clear-cache') {
            Session::flash('message', [
                'text' => "System cache has been purged",
            ]);
            Artisan::call('route:cache');
        }

        if ($request->settings == 'system-view-clear') {
            Session::flash('message', [
                'text' => "View cache has been purged",
            ]);
            Artisan::call('route:cache');
        }

        return redirect()->back();
    }


    /**
     * Basic Settings
     * Show
     * Store
     */
    public function BasicSettings()
    {
        global $request;
        $site_name = AppSettings::where('setting_name', 'site_name')->value('setting_value');
        $site_url = AppSettings::where('setting_name', 'site_url')->value('setting_value');
        $dashboard_url = AppSettings::where('setting_name', 'dashboard_url')->value('setting_value');
        $site_timezone = AppSettings::where('setting_name', 'site_timezone')->value('setting_value');
        $enable_country = AppSettings::where('setting_name', 'enable_country')->value('setting_value');
        $enable_state = AppSettings::where('setting_name', 'enable_state')->value('setting_value');
        $enable_city = AppSettings::where('setting_name', 'enable_city')->value('setting_value');
        $dob_is_active = AppSettings::where('setting_name', 'dob_is_active')->value('setting_value');
        $enable_mobile = AppSettings::where('setting_name', 'enable_mobile')->value('setting_value');
        $age_limit = AppSettings::where('setting_name', 'age_limit')->value('setting_value');
        $user_auto_login = AppSettings::where('setting_name', 'user_auto_login')->value('setting_value');

        $dataSet = [
            'site_name' => $site_name,
            'site_url' => $site_url,
            'dashboard_url' => $dashboard_url,
            'site_timezone' => $site_timezone,
            'enable_country' => $enable_country,
            'enable_state' => $enable_state,
            'enable_city' => $enable_city,
            'dob_is_active' => $dob_is_active,
            'enable_mobile' => $enable_mobile,
            'age_limit' => $age_limit,
            'user_auto_login' => $user_auto_login,
        ];
        LogActivity::addToLog($request, 'Viewed Basic app settings');
        return view($this->view . 'basic.index', compact('dataSet'));
    }
    public function BasicSettingsUpdate(Request $request)
    {

        if ($request->has('basicSettings')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'site_name' => 'required|max:255',
                    'site_timezone' => 'required|max:255',
                    'site_url' =>  'required|url|max:255',
                    'dashboard_url' => 'required|url|max:255',
                ],
                [
                    'site_name.required' => 'Site name is required',
                    'site_name.max' => 'Site name must me less then 255 characters.',
                    'site_timezone.required' => 'Site timezone is required',
                    'site_timezone.max' => 'Site timezone must me less then 255 characters.',
                    'site_url.required' => 'Site url is required',
                    'site_url.url' => 'Site url is invalid.',
                    'site_url.max' => 'Site url must me less then 255 characters.',
                    'dashboard_url.required' => 'Dashboard url is required',
                    'dashboard_url.url' => 'Dashboard url is invalid.',
                    'dashboard_url.max' => 'Dashboard url must me less then 255 characters.',
                ]
            );

            if ($validator->fails()) {
                Session::flash('error', [
                    'text' => $validator->errors()->first(),
                ]);
                return redirect()->back()->withInput();
            } else {
                /**
                 * Set Timezone
                 */
                $site_timezone = AppSettings::where('setting_name', 'site_timezone')->value('setting_value');
                config(['app.timezone' => $site_timezone]);
                // date_default_timezone_set($site_timezone);

                // Update or create the CRM Settings
                AppSettings::updateOrCreate(
                    ['setting_name' => 'site_name'],
                    ['setting_value' => $request->site_name]
                );

                AppSettings::updateOrCreate(
                    ['setting_name' => 'site_url'],
                    ['setting_value' => $request->site_url],
                );

                AppSettings::updateOrCreate(
                    ['setting_name' => 'dashboard_url'],
                    ['setting_value' => rtrim($request->dashboard_url, '/')],
                );

                AppSettings::updateOrCreate(
                    ['setting_name' => 'site_timezone'],
                    ['setting_value' => $request->site_timezone]
                );

                Session::flash('message', [
                    'type' => 'success',
                    'text' => 'App Baic Settings updated'
                ]);

                $envPath = base_path('.env');
                $envContent = File::get($envPath);

                $envData = [
                    'APP_URL' => rtrim($request->dashboard_url, '/'),
                    'APP_TIMEZONE' => $request->site_timezone,
                ];

                // Update the key-value pairs
                foreach ($envData as $key => $value) {
                    $envContent = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $envContent);
                }

                File::put($envPath, $envContent);

                LogActivity::addToLog($request, 'Update Basic app settings');

                // run php artisan optimize
                Artisan::call('optimize:clear');
                return redirect()->back();
            }
        }

        if ($request->has('registrationFormFields')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'enable_country' => 'required|boolean',
                    'enable_state' => 'required|boolean',
                    'enable_city' => 'required|boolean',
                    'dob_is_active' => 'required|boolean',
                    'age_limit' => 'required|numeric|gt:-1',
                    'enable_mobile' => 'required|numeric',
                    'user_auto_login' => 'required|boolean',
                ],
                [
                    'enable_country.required' => 'Something went wrong, pleaes refresh the page and try again.',
                    'enable_country.boolean' => 'Country should be enable or disable, please refresh the page and try again',
                    'enable_state.required' => 'Something went wrong, pleaes refresh the page and try again.',
                    'enable_state.boolean' => 'State should be enable or disable, please refresh the page and try again',
                    'enable_city.required' => 'Something went wrong, pleaes refresh the page and try again.',
                    'enable_city.boolean' => 'City should be enable or disable, please refresh the page and try again',
                    'dob_is_active.required' => 'Age limit is required.',
                    'age_limit.required' => 'Please enter age limit in numbers.',
                    'age_limit.numeric' => 'Please enter age limit in numbers.',
                    'age_limit.gt' => 'Age limit should be in positive numbers',
                    'enable_mobile.required' => 'Please enter mobile number.',
                    'enable_mobile.numeric' => 'Please enter enter valid mobile number.',
                    'user_auto_login.required' => 'Select Auto login option',
                    'user_auto_login.boolean' => 'Auto login option is invalid',
                ],
            );

            if ($validator->fails()) {
                Session::flash('error', [
                    'text' => $validator->errors()->first(),
                ]);
                return redirect()->back()->withInput();
            } else {
                // Update or create the CRM Settings
                AppSettings::updateOrCreate(
                    ['setting_name' => 'enable_country'],
                    ['setting_value' => $request->enable_country]
                );
                AppSettings::updateOrCreate(
                    ['setting_name' => 'enable_state'],
                    ['setting_value' => $request->enable_state]
                );

                AppSettings::updateOrCreate(
                    ['setting_name' => 'enable_city'],
                    ['setting_value' => $request->enable_city]
                );

                AppSettings::updateOrCreate(
                    ['setting_name' => 'dob_is_active'],
                    ['setting_value' => $request->dob_is_active]
                );

                AppSettings::updateOrCreate(
                    ['setting_name' => 'enable_mobile'],
                    ['setting_value' => $request->enable_mobile]
                );
                AppSettings::updateOrCreate(
                    ['setting_name' => 'age_limit'],
                    ['setting_value' => $request->age_limit]
                );

                AppSettings::updateOrCreate(
                    ['setting_name' => 'user_auto_login'],
                    ['setting_value' => $request->user_auto_login]
                );

                Session::flash('message', [
                    'type' => 'success',
                    'text' => 'Registration Form Fields Settings updated'
                ]);
                LogActivity::addToLog($request, 'Update Registeration form basic app settings');
                return redirect()->back();
            }
        }
    }


    /**
     * Theme & Notification Settings
     */
    public function ThemeSettings()
    {

        global $request;
        $dark_mode = AppSettings::where('setting_name', 'dark_mode')->value('setting_value');
        $theme_color = AppSettings::where('setting_name', 'theme_color')->value('setting_value');
        $theme_settings_is_active = AppSettings::where('setting_name', 'theme_settings_is_active')->value('setting_value');

        // Notification Type
        $notification_type = AppSettings::where('setting_name', 'notification_type')->value('setting_value');

        // Toastr Notification Visibility Settings
        $toastr_notification_position_class = AppSettings::where('setting_name', 'toastr_notification_position_class')->value('setting_value');
        $toastr_notification_close_button = AppSettings::where('setting_name', 'toastr_notification_close_button')->value('setting_value');
        $toastr_notification_progress_bar = AppSettings::where('setting_name', 'toastr_notification_progress_bar')->value('setting_value');
        $toastr_notification_time_out = AppSettings::where('setting_name', 'toastr_notification_time_out')->value('setting_value');
        
        // SweetAlerts Notification Visibility Settings
        $sweet_alerts_type = AppSettings::where('setting_name', 'sweet_alerts_type')->value('setting_value');
        $sweet_alerts_position = AppSettings::where('setting_name', 'sweet_alerts_position')->value('setting_value');
        $sweet_alerts_timer = AppSettings::where('setting_name', 'sweet_alerts_timer')->value('setting_value');
        $sweet_alerts_timer_progress_bar = AppSettings::where('setting_name', 'sweet_alerts_timer_progress_bar')->value('setting_value');        
        $sweet_alerts_animation = AppSettings::where('setting_name', 'sweet_alerts_animation')->value('setting_value');
        $sweet_alerts_icon_color = AppSettings::where('setting_name', 'sweet_alerts_icon_color')->value('setting_value');
        $sweet_alerts_text_color = AppSettings::where('setting_name', 'sweet_alerts_text_color')->value('setting_value');
        $sweet_alerts_background_color = AppSettings::where('setting_name', 'sweet_alerts_background_color')->value('setting_value');
        $sweet_alerts_confirm_button = AppSettings::where('setting_name', 'sweet_alerts_confirm_button')->value('setting_value');
        $sweet_alerts_cancel_button = AppSettings::where('setting_name', 'sweet_alerts_cancel_button')->value('setting_value');
        $sweet_alerts_show_confirm_button = AppSettings::where('setting_name', 'sweet_alerts_show_confirm_button')->value('setting_value');


        $dataSet = [
            'dark_mode' => $dark_mode,
            'theme_color' => $theme_color,
            'theme_settings_is_active' => $theme_settings_is_active,

            'notification_type' => $notification_type,

            // Toastr Notification Visibility Settings
            'toastr_notification_position_class' => $toastr_notification_position_class,
            'toastr_notification_close_button' => $toastr_notification_close_button,
            'toastr_notification_progress_bar' => $toastr_notification_progress_bar,
            'toastr_notification_time_out' => $toastr_notification_time_out,

            // SweetAlerts Notification Visibility Settings
            'sweet_alerts_type' => $sweet_alerts_type,
            'sweet_alerts_position' => $sweet_alerts_position,
            'sweet_alerts_timer' => $sweet_alerts_timer,
            'sweet_alerts_timer_progress_bar' => $sweet_alerts_timer_progress_bar,
            'sweet_alerts_animation' => $sweet_alerts_animation,
            'sweet_alerts_icon_color' => $sweet_alerts_icon_color,
            'sweet_alerts_text_color' => $sweet_alerts_text_color,
            'sweet_alerts_background_color' => $sweet_alerts_background_color,
            'sweet_alerts_confirm_button' => $sweet_alerts_confirm_button,
            'sweet_alerts_cancel_button' => $sweet_alerts_cancel_button,
            'sweet_alerts_show_confirm_button' => $sweet_alerts_show_confirm_button,
        ];
        LogActivity::addToLog($request, 'Viewed Basic app settings');
        return view($this->view . 'theme.index', compact('dataSet'));
    }
    public function ThemeSettingsUpdate(Request $request)
    {

        /**
         * Theme Settings
         */
        if ($request->has('themeSettings')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'dark_mode' => 'required|boolean',
                    'theme_color' => 'required',
                    'theme_settings_is_active' => 'required|boolean',
                ],
                [
                    'dark_mode.required' => 'Something went wrong, pleaes refresh the page and try again.',
                    'dark_mode.boolean' => 'dark mode should be enable or disable, please refresh the page and try again',
                    'theme_color.required' => 'Something went wrong, pleaes refresh the page and try again.',
                    'theme_settings_is_active.boolean' => 'dark mode should be enable or disable, please refresh the page and try again',
                ],
            );

            if ($validator->fails()) {
                Session::flash('error', [
                    'text' => $validator->errors()->first(),
                ]);
                return redirect()->back()->withInput();
            } else {
                // Update or create the CRM Settings
                AppSettings::updateOrCreate(
                    ['setting_name' => 'dark_mode'],
                    ['setting_value' => $request->dark_mode]
                );

                AppSettings::updateOrCreate(
                    ['setting_name' => 'theme_color'],
                    ['setting_value' => $request->theme_color]
                );

                AppSettings::updateOrCreate(
                    ['setting_name' => 'theme_settings_is_active'],
                    ['setting_value' => $request->theme_settings_is_active]
                );

                Session::flash('message', [
                    'type' => 'success',
                    'text' => 'Theme Settings updated'
                ]);
                LogActivity::addToLog($request, 'Theme settings updated');
                return redirect()->back();
            }
        }

        /**
         * Toaster Notification Settings
         */
        if ($request->has('notificationSettings')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'notification_type' => 'required',
                    'toastr_notification_position_class' => 'required',
                    'toastr_notification_close_button' => 'required',
                    'toastr_notification_progress_bar' => 'required',
                    'toastr_notification_time_out' => [
                        'required',
                        function ($attribute, $value, $fail) {
                            if ($value !== 'infinite' && !is_numeric($value)) {
                                $fail("Time out should be numeric value or 'infinite'.");
                            }
                        },
                    ],
                    'sweet_alerts_type' => 'required',
                    'sweet_alerts_position' => 'required',
                    'sweet_alerts_timer' => 'required',
                    'sweet_alerts_timer_progress_bar' => 'required',
                    'sweet_alerts_animation' => 'required',
                    'sweet_alerts_show_confirm_button' => 'required',
                ],
            );

            if ($validator->fails()) {
                Session::flash('error', [
                    'text' => $validator->errors()->first(),
                ]);
                return redirect()->back()->withInput();
            } else {
                // Update or create the CRM Settings
                AppSettings::updateOrCreate(
                    ['setting_name' => 'notification_type'],
                    ['setting_value' => $request->notification_type]
                );

                // Toastr Notification Visibility Settings
                AppSettings::updateOrCreate(
                    ['setting_name' => 'toastr_notification_position_class'],
                    ['setting_value' => $request->toastr_notification_position_class]
                );
                AppSettings::updateOrCreate(
                    ['setting_name' => 'toastr_notification_close_button'],
                    ['setting_value' => $request->toastr_notification_close_button]
                );
                AppSettings::updateOrCreate(
                    ['setting_name' => 'toastr_notification_progress_bar'],
                    ['setting_value' => $request->toastr_notification_progress_bar]
                );
                AppSettings::updateOrCreate(
                    ['setting_name' => 'toastr_notification_time_out'],
                    ['setting_value' => $request->toastr_notification_time_out]
                );

                // SweetAlerts Notification Visibility Settings
                AppSettings::updateOrCreate(
                    ['setting_name' => 'sweet_alerts_type'],
                    ['setting_value' => $request->sweet_alerts_type]
                );
                AppSettings::updateOrCreate(
                    ['setting_name' => 'sweet_alerts_position'],
                    ['setting_value' => $request->sweet_alerts_position]
                );
                AppSettings::updateOrCreate(
                    ['setting_name' => 'sweet_alerts_timer'],
                    ['setting_value' => $request->sweet_alerts_timer]
                );
                AppSettings::updateOrCreate(
                    ['setting_name' => 'sweet_alerts_timer_progress_bar'],
                    ['setting_value' => $request->sweet_alerts_timer_progress_bar]
                );
                AppSettings::updateOrCreate(
                    ['setting_name' => 'sweet_alerts_animation'],
                    ['setting_value' => $request->sweet_alerts_animation]
                );
                AppSettings::updateOrCreate(
                    ['setting_name' => 'sweet_alerts_icon_color'],
                    ['setting_value' => $request->sweet_alerts_icon_color]
                );
                AppSettings::updateOrCreate(
                    ['setting_name' => 'sweet_alerts_text_color'],
                    ['setting_value' => $request->sweet_alerts_text_color]
                );
                AppSettings::updateOrCreate(
                    ['setting_name' => 'sweet_alerts_background_color'],
                    ['setting_value' => $request->sweet_alerts_background_color]
                );
                AppSettings::updateOrCreate(
                    ['setting_name' => 'sweet_alerts_confirm_button'],
                    ['setting_value' => $request->sweet_alerts_confirm_button]
                );
                AppSettings::updateOrCreate(
                    ['setting_name' => 'sweet_alerts_cancel_button'],
                    ['setting_value' => $request->sweet_alerts_cancel_button]
                );
                AppSettings::updateOrCreate(
                    ['setting_name' => 'sweet_alerts_show_confirm_button'],
                    ['setting_value' => $request->sweet_alerts_show_confirm_button]
                );

                Session::flash('message', [
                    'type' => 'success',
                    'text' => 'In App Notification Settings Updated'
                ]);
                LogActivity::addToLog($request, 'Update Notification visibility basic app settings');
                return redirect()->back();
            }
        }
    }


    /**
     * Brand Settings
     * Show
     * Store
     */
    public function BrandSettings()
    {

        global $request;
        $logo_small = AppSettings::where('setting_name', 'logo_small')->value('setting_value');
        $site_logo = AppSettings::where('setting_name', 'site_logo')->value('setting_value');

        $dataSet = [
            'logo_small' => $logo_small,
            'site_logo' => $site_logo
        ];
        LogActivity::addToLog($request, 'Viewed Brand app settings');
        return view($this->view . 'brand.index', compact('dataSet'));
    }
    public function BrandSettingsUpdate(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'logo_small' => 'required|image|mimes:jpeg,png,jpg|max:1024',
                'site_logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ],
            [
                'logo_small.required' => 'Small Logo is required',
                'logo_small.mimes' => 'Small Logo must be in (jpeg, jpg and png format)',
                'logo_small.max' => 'Small Logo is too large (max size: 1MB)',
                'site_logo.required' => 'Logo is required',
                'site_logo.mimes' => 'Logo must be in (jpeg, jpg and png format)',
                'site_logo.max' => 'Logo is too large (max size: 2MB)',
            ],
        );

        if ($validator->fails()) {
            Session::flash('error', [
                'text' => $validator->errors()->first(),
            ]);
            return redirect()->back()->withInput();
        } else {

            $move_path = public_path() . $this->directory;

            $logo_small_file = $request->logo_small;
            $ext = $request->file('logo_small')->getClientOriginalExtension();
            $logo_small = $request->file('logo_small')->storeAs($this->directory, 'logo_small' . '.' . $ext);
            $logo_small_file->move($move_path, $logo_small);

            $site_logo_file = $request->site_logo;
            $ext = $request->file('site_logo')->getClientOriginalExtension();
            $site_logo = $request->file('site_logo')->storeAs($this->directory, 'site_logo' . '.' . $ext);
            $site_logo_file->move($move_path, $site_logo);

            Session::flash('message', [
                'text' => "Brand Setting Saved",
                'type' => 'success'
            ]);

            // Update or create the Google reCaptcha Settings
            AppSettings::updateOrCreate(
                ['setting_name' => 'logo_small'],
                ['setting_value' => $logo_small]
            );

            AppSettings::updateOrCreate(
                ['setting_name' => 'site_logo'],
                ['setting_value' => $site_logo]
            );
            LogActivity::addToLog($request, 'Update Brand app settings');

            return redirect()->back();
        }
    }

    /**
     * Bank Account Settings
     * Show
     * Store
     */
    public function GoogleRecaptchaSettings()
    {

        global $request;
        $google_site_key = AppSettings::where('setting_name', 'google_site_key')->value('setting_value');
        $google_secret_key = AppSettings::where('setting_name', 'google_secret_key')->value('setting_value');
        $google_recaptcha = AppSettings::where('setting_name', 'google_recaptcha')->value('setting_value');

        $dataSet = [
            'google_site_key' => $google_site_key,
            'google_secret_key' => $google_secret_key,
            'google_recaptcha' => $google_recaptcha,
        ];
        LogActivity::addToLog($request, 'Viewed Google reCaptcha app settings');
        return view($this->view . 'google-recaptcha.index', compact('dataSet'));
    }
    public function GoogleRecaptchaSettingsUpdate(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'google_site_key' => 'required|max:255',
                'google_secret_key' => 'required|max:255',
                'google_recaptcha' => 'required|boolean',
            ],
            [
                'google_recaptcha.boolean' => 'Unknown error, try refresh page and resubmit',
            ],
        );

        if ($validator->fails()) {
            Session::flash('error', [
                'text' => $validator->errors()->first(),
            ]);
            return redirect()->back()->withInput();
        } else {
            // Update or create the Google reCaptcha Settings
            AppSettings::updateOrCreate(
                ['setting_name' => 'google_site_key'],
                ['setting_value' => $request->google_site_key]
            );

            AppSettings::updateOrCreate(
                ['setting_name' => 'google_secret_key'],
                ['setting_value' => $request->google_secret_key]
            );

            AppSettings::updateOrCreate(
                ['setting_name' => 'google_recaptcha'],
                ['setting_value' => $request->google_recaptcha]
            );

            Session::flash('message', [
                'type' => 'success',
                'text' => 'Google Settings updated.'
            ]);
            LogActivity::addToLog($request, 'Update google reCaptcha app settings');

            return redirect()->back();
        }
    }
}
