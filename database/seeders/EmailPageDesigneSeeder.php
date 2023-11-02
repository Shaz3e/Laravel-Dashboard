<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmailPageDesigneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('email_page_designs')->truncate();

        $email_page_designs = [
            ['setting_name' => 'header_image', 'setting_value' => null, 'created_at' => now(), 'updated_at' => now(),],
            ['setting_name' => 'footer_text_color', 'setting_value' => '#000000', 'created_at' => now(), 'updated_at' => now(),],
            ['setting_name' => 'footer_background_color', 'setting_value' => '#b0adc5', 'created_at' => now(), 'updated_at' => now(),],
            ['setting_name' => 'footer_text', 'setting_value' => null, 'created_at' => now(), 'updated_at' => now(),],
        ];

        DB::table('email_page_designs')->insert($email_page_designs);
    }
}
