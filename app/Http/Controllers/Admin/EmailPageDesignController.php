<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Models\EmailPageDesign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class EmailPageDesignController extends Controller
{
    // View & Route
    protected $view = "admin.mail-settings.";
    protected $route = "admin/email-design/";

    // Brand Logo Directory
    protected $directory = '/email-page-design';

    public function view()
    {
        $header_image = EmailPageDesign::where('setting_name', 'header_image')->value('setting_value');
        $footer_text_color = EmailPageDesign::where('setting_name', 'footer_text_color')->value('setting_value');
        $footer_background_color = EmailPageDesign::where('setting_name', 'footer_background_color')->value('setting_value');
        $footer_text = EmailPageDesign::where('setting_name', 'footer_text')->value('setting_value');

        $dataSet = [
            'header_image' => $header_image,
            'footer_text_color' => $footer_text_color,
            'footer_background_color' => $footer_background_color,
            'footer_text' => $footer_text,
        ];

        return view(
            $this->view . 'email-page-design',
            compact(
                'dataSet'
            )
        );
    }

    public function postData(Request $request)
    {
        if ($request->has('header_image')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'header_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                ],
                [
                    'header_image.required' => 'Header image is required',
                    'header_image.mimes' => 'Header image must be in (jpeg, jpg and png format)',
                    'header_image.max' => 'Header image is too large (max size: 2MB)',
                ],
            );

            if ($validator->fails()) {
                Session::flash('error', [
                    'text' => $validator->errors()->first(),
                ]);
                return redirect()->back()->withInput();
            } else {
                $move_path = public_path() . $this->directory;

                $header_image_file = $request->header_image;
                $ext = $request->file('header_image')->getClientOriginalExtension();
                $header_image = $request->file('header_image')->storeAs($this->directory, 'header_image' . '.' . $ext);
                $header_image_file->move($move_path, $header_image);

                EmailPageDesign::updateOrCreate(
                    ['setting_name' => 'header_image'],
                    ['setting_value' => $header_image]
                );
                LogActivity::addToLog($request, 'email header image update');
                Session::flash('message', [
                    'text' => "Email Template Setting Saved",
                    'type' => 'success'
                ]);

                return redirect()->back();
            }
        } else {
            $validator = Validator::make(
                $request->all(),
                [
                    'footer_text_color' => ['nullable', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
                    'footer_background_color' => ['nullable', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
                ],
                [
                    'footer_text_color.regex' => 'Only hex code is allowed.',
                    'footer_background_color.regex' => 'Only hex code is allowed.',
                ]
            );

            if ($validator->fails()) {
                Session::flash('error', [
                    'text' => $validator->errors()->first(),
                ]);
                return redirect()->back()->withInput();
            }
            EmailPageDesign::updateOrCreate(
                ['setting_name' => 'footer_text_color'],
                ['setting_value' => $request->footer_text_color]
            );
            EmailPageDesign::updateOrCreate(
                ['setting_name' => 'footer_background_color'],
                ['setting_value' => $request->footer_background_color]
            );
            EmailPageDesign::updateOrCreate(
                ['setting_name' => 'footer_text'],
                ['setting_value' => $request->footer_text]
            );
            LogActivity::addToLog($request, 'email design updated');
            Session::flash('message', [
                'text' => "Email Template Setting Saved",
                'type' => 'success'
            ]);

            return redirect()->back();
        }
    }
}
