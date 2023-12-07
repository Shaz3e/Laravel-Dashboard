<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('app_settings')->truncate();

        $app_settings = [
            // Email Settings
            ['setting_name' => 'to_email', 'setting_value' => null, 'created_at' => now(), 'updated_at' => now(),],
            ['setting_name' => 'smtp_host', 'setting_value' => null, 'created_at' => now(), 'updated_at' => now(),],
            ['setting_name' => 'smtp_email', 'setting_value' => null, 'created_at' => now(), 'updated_at' => now(),],
            ['setting_name' => 'smtp_password', 'setting_value' => null, 'created_at' => now(), 'updated_at' => now(),],
            ['setting_name' => 'smtp_port', 'setting_value' => null, 'created_at' => now(), 'updated_at' => now(),],
            ['setting_name' => 'smtp_secure', 'setting_value' => null, 'created_at' => now(), 'updated_at' => now(),],
            ['setting_name' => 'from_name', 'setting_value' => null, 'created_at' => now(), 'updated_at' => now(),],
            ['setting_name' => 'from_email', 'setting_value' => null, 'created_at' => now(), 'updated_at' => now(),],
            ['setting_name' => 'bcc_email', 'setting_value' => null, 'created_at' => now(), 'updated_at' => now(),],

            // Site Name, LOGO & URL Settings
            ['setting_name' => 'site_name', 'setting_value' => 'Forex Back Office', 'created_at' => now(), 'updated_at' => now(),],
            ['setting_name' => 'site_url', 'setting_value' => 'https://backofficefx.com', 'created_at' => now(), 'updated_at' => now(),],
            ['setting_name' => 'dashboard_url', 'setting_value' => null, 'created_at' => now(), 'updated_at' => now(),],
            ['setting_name' => 'site_logo', 'setting_value' => 'logos/site_logo.png', 'created_at' => now(), 'updated_at' => now(),],
            ['setting_name' => 'logo_small', 'setting_value' => 'logos/logo_small.png', 'created_at' => now(), 'updated_at' => now(),],
            ['setting_name' => 'site_timezone', 'setting_value' => null, 'created_at' => now(), 'updated_at' => now(),],

            // Theme Settings
            ['setting_name' => 'dark_mode', 'setting_value' => '0', 'created_at' => now(), 'updated_at' => now(),],
            ['setting_name' => 'theme_color', 'setting_value' => 'primary', 'created_at' => now(), 'updated_at' => now(),],
            ['setting_name' => 'theme_settings_is_active', 'setting_value' => 1, 'created_at' => now(), 'updated_at' => now(),],

            // Google reCaptcha Settings
            ['setting_name' => 'google_recaptcha', 'setting_value' => null, 'created_at' => now(), 'updated_at' => now(),],
            ['setting_name' => 'google_site_key', 'setting_value' => null, 'created_at' => now(), 'updated_at' => now(),],
            ['setting_name' => 'google_secret_key', 'setting_value' => null, 'created_at' => now(), 'updated_at' => now(),],

            // State and City
            ['setting_name' => 'enable_state', 'setting_value' => 0, 'created_at' => now(), 'updated_at' => now(),],
            ['setting_name' => 'enable_city', 'setting_value' => 0, 'created_at' => now(), 'updated_at' => now(),],

            // Age Limit
            ['setting_name' => 'age_limit', 'setting_value' => 0, 'created_at' => now(), 'updated_at' => now(),],

            // Date Of Birth
            ['setting_name' => 'dob_is_active', 'setting_value' => 0, 'created_at' => now(), 'updated_at' => now(),],

            // Notification Type
            ['setting_name' => 'notification_type', 'setting_value' => 'toastr', 'created_at' => now(), 'updated_at' => now(),],

            // Toastr Notification Visibility Settings
            ['setting_name' => 'toastr_notification_position_class', 'setting_value' => 'bottom-right', 'created_at' => now(), 'updated_at' => now(),],
            ['setting_name' => 'toastr_notification_close_button', 'setting_value' => 'true', 'created_at' => now(), 'updated_at' => now(),],
            ['setting_name' => 'toastr_notification_progress_bar', 'setting_value' => 'true', 'created_at' => now(), 'updated_at' => now(),],
            ['setting_name' => 'toastr_notification_time_out', 'setting_value' => 3000, 'created_at' => now(), 'updated_at' => now(),],

            // Sweet Alert Notification Visibility Settings
            ['setting_name' => 'sweet_alerts_type', 'setting_value' => 'true', 'created_at' => now(), 'updated_at' => now(),],
            ['setting_name' => 'sweet_alerts_position', 'setting_value' => 'top-end', 'created_at' => now(), 'updated_at' => now(),],
            ['setting_name' => 'sweet_alerts_timer', 'setting_value' => '3000', 'created_at' => now(), 'updated_at' => now(),],
            ['setting_name' => 'sweet_alerts_timer_progress_bar', 'setting_value' => 'true', 'created_at' => now(), 'updated_at' => now(),],
            ['setting_name' => 'sweet_alerts_animation', 'setting_value' => 'true', 'created_at' => now(), 'updated_at' => now(),],
            ['setting_name' => 'sweet_alerts_icon_color', 'setting_value' => '', 'created_at' => now(), 'updated_at' => now(),],
            ['setting_name' => 'sweet_alerts_text_color', 'setting_value' => '', 'created_at' => now(), 'updated_at' => now(),],
            ['setting_name' => 'sweet_alerts_background_color', 'setting_value' => '', 'created_at' => now(), 'updated_at' => now(),],
            ['setting_name' => 'sweet_alerts_confirm_button', 'setting_value' => 'success', 'created_at' => now(), 'updated_at' => now(),],
            ['setting_name' => 'sweet_alerts_cancel_button', 'setting_value' => 'danger', 'created_at' => now(), 'updated_at' => now(),],
            ['setting_name' => 'sweet_alerts_show_confirm_button', 'setting_value' => 'false', 'created_at' => now(), 'updated_at' => now(),],
        ];

        DB::table('app_settings')->insert($app_settings);
    }
}
