<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Mail\Admin\NewSupportTicketNotification;
use App\Mail\Admin\ReplySupportTicket as AdminReplySupportTicket;
use App\Mail\User\NewSupportTicketNotificationUser;
use App\Mail\User\ReplySupportTicket;
use App\Models\Admin;
use App\Models\SupportTicketPriority;
use App\Models\SupportTicketReply;
use App\Models\SupportTicket;
use App\Models\TicketStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SupportTicketController extends Controller
{
    // View & Route
    protected $view = "admin.support-tickets.";
    protected $route = "admin/support-tickets";

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $dataSet = SupportTicket::query();


        if ($request->status != null) {
            $dataSet->where('ticket_status_id', $request->status);
        }

        if ($request->priority != null) {
            $dataSet->where('support_ticket_priority_id', $request->priority);
        }

        if ($request->search != null) {
            $dataSet->where('message', 'like', '%' . $request->search . '%')
                ->orWhere('title', 'like', '%' . $request->search . '%')
                ->orWhere('ticket_number', 'like', '%' . $request->search . '%');
        }
        $dataSet->orderBy('created_at', 'desc');
        $dataSet = $dataSet->paginate(10);

        $ticketStatus = TicketStatus::all();
        $ticketPriority = SupportTicketPriority::all();

        LogActivity::addToLog($request, 'Viewed ticket priority list');
        return view(
            $this->view . 'index',
            compact(
                'dataSet',
                'ticketStatus',
                'ticketPriority'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ticketStatusData = TicketStatus::where('is_active', 1)->get();
        $ticketPriorityData = SupportTicketPriority::where('is_active', 1)->get();
        $usersDataSet = User::all();

        return view($this->view . 'create', compact(
            'ticketStatusData',
            'ticketPriorityData',
            'usersDataSet'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => 'required|numeric',
                'ticket_status_id' => 'required|numeric',
                'support_ticket_priority_id' => 'required|numeric',
                'is_locked' => 'required|boolean',
                'title' => 'required|max:100',
                'message' => 'required',
                'attachments' => [
                    'nullable',
                    'array', // Ensure 'attachments' is an array
                    'max:10', // Set a maximum limit for the number of attachments (adjust as needed)
                ],
                'attachments.*' => [
                    'file', // Ensure each element in the 'attachments' array is a file
                    'mimetypes:image/jpeg,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,image/png,image/jpeg', // Mime types allowed
                    'max:5120', // Maximum file size in KB (5MB)
                ],
            ],
            [
                'user_id.required' => 'User is required',
                'user_id.numeric' => 'Invalid User',

                'ticket_status_id.required' => 'Ticket status is required',
                'ticket_status_id.numeric' => 'Invalid Ticket status',

                'support_ticket_priority_id.required' => 'Ticket priority is required',
                'support_ticket_priority_id.numeric' => 'Invalid Ticket priority',

                'is_locked.required' => "Please select lock option",
                'is_locked.boolean'    => 'Invalid lock option.',

                'title.required' => 'Ticket subject is required',
                'title.max' => 'Ticket subject should not be greater than 100 character long',

                'message.required' => 'Message is required',

                'attachments.array' => 'Attachments must be an array',
                'attachments.max' => 'Too many attachments (max: 10)',
                'attachments.*.file' => 'Invalid attachment format',
                'attachments.*.mimetypes' => 'Attachment must be in (.doc, .docx, .pdf, .jpeg, .jpg, .png) format',
                'attachments.*.max' => 'Attachment is too large (max size: 5MB)',
            ],
        );

        if ($validator->fails()) {
            Session::flash('error', [
                'text' => $validator->errors()->first(),
            ]);
            return redirect()->back()->withInput();
        } else {
            $data = new SupportTicket();
            $data->ticket_number = generateSupportTicketNumber();
            $data->user_id = $request->user_id;
            $data->ticket_status_id = $request->ticket_status_id;
            $data->support_ticket_priority_id = $request->support_ticket_priority_id;
            $data->assigned_to = Auth::guard('admin')->user()->id;
            $data->is_locked = $request->is_locked;

            $data->title = $request->title;
            $data->message = $request->message;

            // Handle attachments uploads
            if ($request->hasFile('attachments')) {
                $attachmentData = [];

                foreach ($request->file('attachments') as $attachment) {
                    // Get the original file name
                    $originalName = $attachment->getClientOriginalName();

                    // Generate a unique name for the file to prevent overwrites
                    $fileName = uniqid() . '_' . $originalName;

                    // Store the file with the generated unique name
                    $path = $attachment->storeAs('support-ticket-attachments', $fileName, 'public');

                    // Create an attachment object with "name" and "value" keys
                    $attachmentObject = [
                        'name' => $originalName,
                        'value' => $path,
                    ];

                    $attachmentData[] = $attachmentObject;
                }

                $data->attachments = json_encode($attachmentData);
            }

            // Save data
            $result = $data->save();

            if ($result) {
                // Check if ticket is not locked
                if ($request->is_locked == 0) {
                    $mailData = [
                        'customer_support_ticket_url' => config('app.url') . '/customer-support/' . $data->id,
                        'admin_support_ticket_url' => config('app.url') . '/admin/support-tickets/' . $data->id,
                        'ticket_number' => $data->ticket_number,
                        'name' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
                        'email' => auth()->user()->email,
                        'status' => getSupportTicketStatus($data->ticket_status_id),
                        'priority' => getSupportTicketByPriority($data->support_ticket_priority_id),
                        'title' => $request->title,
                        'message' => $request->message,
                    ];

                    $emailSent = Mail::to($mailData['email'])->send(new NewSupportTicketNotificationUser($mailData));
                    $adminEmail = Mail::to(DiligentCreators('to_email'))->send(new NewSupportTicketNotification($mailData));

                    if ($emailSent) {
                        LogActivity::addToLog($request, $mailData['name'] . ' Opened a new ticket# ' . $data->ticket_number . ' and information has also sent to client');
                    }
                    if ($adminEmail) {
                        LogActivity::addToLog($request, $mailData['name'] . ' Opened a new ticket# ' . $data->ticket_number . ' and information has also sent to backoffice staff');
                    }
                    LogActivity::addToLog($request, 'New Ticket created by client');
                }

                Session::flash('message', [
                    'text' => "Support Ticket Created",
                ]);
                
            } else {
                Session::flash('errors', [
                    'text' => "Something went wrong, please try again",
                ]);
                return redirect()->back()->withInput();
            }
        }

        return redirect($this->route);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $data = SupportTicket::where('id', $id)->exists();
        $attachments = null; // Initialize attachments to null

        if ($data) {
            $data = SupportTicket::select(
                'support_tickets.*',
                'users.first_name',
                'users.last_name',
                'users.email'
            )
                ->leftJoin('users', 'users.id', '=', 'support_tickets.user_id')
                ->where('support_tickets.id', $id)
                ->first();

            if ($data->attachments) {
                $attachments = json_decode($data->attachments);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    Session::flash('error', [
                        'text' => "Error decoding attachments data",
                    ]);
                }
            }

            $adminData = Admin::where('is_active', 1)->where('id', '!=', 1)->get();
            $ticketStatus = TicketStatus::all();
            $ticketPriority = SupportTicketPriority::all();
            $supportTicketReply = SupportTicketReply::where('support_ticket_id', $id)->get();

            return view($this->view . 'show', compact(
                'data',
                'attachments',
                'adminData',
                'ticketStatus',
                'ticketPriority',
                'supportTicketReply'
            ));
        } else {
            Session::flash('error', [
                'text' => "Ticket not found"
            ]);
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(string $id)
    // {
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        if ($request->assign_form === 'assign_form') {
            $validator = Validator::make(
                $request->all(),
                [
                    'assigned_to' => 'required',
                    'ticket_status_id' => 'required',
                    'support_ticket_priority_id' => 'required',
                ],
                [
                    'assigned_to.required' => 'Please assign ticket first',
                    'ticket_status_id.required' => 'Please select ticket status',
                    'support_ticket_priority_id.required' => 'Please select ticket priority',
                ]
            );
            if ($validator->fails()) {
                Session::flash('error', [
                    'text' => $validator->errors()->first()
                ]);
            } else {
                $data = SupportTicket::find($id);
                $data->assigned_to = $request->assigned_to;
                $data->ticket_status_id = $request->ticket_status_id;
                $data->support_ticket_priority_id = $request->support_ticket_priority_id;

                if ($data->save()) {
                    Session::flash('message', [
                        'text' => "Ticket has been updated",
                    ]);
                } else {
                    Session::flash('error', [
                        'text' => "Something went wrong"
                    ]);
                }
            }
            return redirect()->back();
        } else {
            $validator = Validator::make(
                $request->all(),
                [
                    'message' => 'required',
                    'ticket_status_id' => 'required|numeric',
                    'attachments' => [
                        'nullable',
                        'array', // Ensure 'attachments' is an array
                        'max:10', // Set a maximum limit for the number of attachments (adjust as needed)
                    ],
                    'attachments.*' => [
                        'file', // Ensure each element in the 'attachments' array is a file
                        'mimetypes:image/jpeg,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,image/png,image/jpeg', // Mime types allowed
                        'max:5120', // Maximum file size in KB (5MB)
                    ],
                ],
                [
                    'message.required' => 'Message is required',
                    'ticket_status_id.required' => 'Status is Required',

                    'attachments.array' => 'Attachments must be an array',
                    'attachments.max' => 'Too many attachments (max: 10)',
                    'attachments.*.file' => 'Invalid attachment format',
                    'attachments.*.mimetypes' => 'Attachment must be in (.doc, .docx, .pdf, .jpeg, .jpg, .png) format',
                    'attachments.*.max' => 'Attachment is too large (max size: 5MB)',
                ],
            );
            if ($validator->fails()) {
                Session::flash('error', [
                    'text' => $validator->errors()->first()
                ]);
            } else {
                $user_id = SupportTicket::find($id)->user_id;

                SupportTicket::where('id', $id)->update([
                    'ticket_status_id' => $request->ticket_status_id,
                ]);

                $data = new SupportTicketReply();
                $data->user_id = $user_id;
                $data->support_ticket_id = $id;
                $data->reply_by = Auth::guard('admin')->user()->id;
                $data->message = $request->message;

                // Handle attachments uploads
                if ($request->hasFile('attachments')) {
                    $attachmentData = [];

                    foreach ($request->file('attachments') as $attachment) {
                        // Get the original file name
                        $originalName = $attachment->getClientOriginalName();

                        // Generate a unique name for the file to prevent overwrites
                        $fileName = uniqid() . '_' . $originalName;

                        // Store the file with the generated unique name
                        $path = $attachment->storeAs('support-ticket-attachments', $fileName, 'public');

                        // Create an attachment object with "name" and "value" keys
                        $attachmentObject = [
                            'name' => $originalName,
                            'value' => $path,
                        ];

                        $attachmentData[] = $attachmentObject;
                    }

                    $data->attachments = json_encode($attachmentData);
                }

                $result = $data->save();

                if ($result) {
                    // Check if ticket is not locked
                    if ($request->is_locked == 0) {
                        // Get current ticket data by id
                        $data = SupportTicket::find($id);

                        // prepare mail data
                        $mailData = [
                            'customer_support_ticket_url' => config('app.url') . '/customer-support/' . $data->id,
                            'admin_support_ticket_url' => config('app.url') . '/admin/support-tickets/' . $data->id,
                            'ticket_number' => $data->ticket_number,
                            'name' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
                            'email' => auth()->user()->email,
                            'status' => getSupportTicketStatus($data->ticket_status_id),
                            'priority' => getSupportTicketByPriority($data->support_ticket_priority_id),
                            'title' => $data->title,
                        ];

                        $emailSent = Mail::to($mailData['email'])->send(new ReplySupportTicket($mailData));
                        $adminEmail = Mail::to(DiligentCreators('to_email'))->send(new AdminReplySupportTicket($mailData));

                        if ($emailSent) {
                            LogActivity::addToLog($request, $mailData['name'] . ' Opened a new ticket# ' . $data->ticket_number . ' and information has also sent to client');
                        }
                        if ($adminEmail) {
                            LogActivity::addToLog($request, $mailData['name'] . ' Opened a new ticket# ' . $data->ticket_number . ' and information has also sent to backoffice staff');
                        }
                    }
                    Session::flash('message', [
                        'text' => "Ticket reply is updated",
                    ]);
                } else {
                    Session::flash('error', [
                        'text' => "Something went wrong, please try again"
                    ]);
                }
            }
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Request $request, string $id)
    // {
    // }
}
