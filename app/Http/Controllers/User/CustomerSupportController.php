<?php

namespace App\Http\Controllers\User;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Mail\Admin\NewSupportTicketNotification;
use App\Mail\Admin\ReplySupportTicket as AdminReplySupportTicket;
use App\Mail\User\NewSupportTicketNotificationUser;
use App\Mail\User\ReplySupportTicket;
use App\Models\SupportTicketPriority;
use App\Models\SupportTicketReply;
use App\Models\SupportTicket;
use App\Models\TicketStatus;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Validation\Rules\File;

class CustomerSupportController extends Controller
{
    // View folder name
    protected $view = "user.customer-support.";

    // route name
    protected $route = "customer-support";

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataSet = SupportTicket::select(
            'support_tickets.*',
            'ticket_statuses.name as ticketStatus'
        )
            ->leftJoin('ticket_statuses', 'ticket_statuses.id', 'support_tickets.ticket_status_id')
            ->where('support_tickets.user_id', auth()->user()->id)
            ->where('is_locked', 0)
            ->orderBy('support_tickets.created_at', 'desc')
            ->get();
        return view($this->view . 'index', compact('dataSet'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view($this->view . 'create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
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
                'title.required' => 'Ticket subject is required',
                'title.max' => 'Ticket subject should not be greater than 100 characters long',

                'message.required' => 'Message is required',

                'attachments.array' => 'Attachments must be an array',
                'attachments.max' => 'Too many attachments (max: 10)',
                'attachments.*.file' => 'Invalid attachment format',
                'attachments.*.mimetypes' => 'Attachment must be in (.doc, .docx, .pdf, .jpeg, .jpg, .png) format',
                'attachments.*.max' => 'Attachment is too large (max size: 5MB)',
            ]
        );


        if ($validator->fails()) {
            Session::flash('error', [
                'text' => $validator->errors()->first(),
            ]);
            return redirect()->back()->withInput();
        } else {
            $data = new SupportTickets();
            $data->ticket_number = generateSupportTicketNumber();
            $data->user_id = auth()->user()->id;
            $data->ticket_status_id = 1;
            $data->support_ticket_priority_id = 2;

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

                LogActivity::addToLog($request, 'New Ticket created by '.$mailData['name']);
                Session::flash('message', [
                    'text' => "Support Ticket is created",
                ]);
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
    public function show(Request $request, string $id)
    {
        // All Ticket Status
        $ticketStatusData = TicketStatus::where('is_active', 1)->get();
        // All Ticket Priority
        $ticketPriorityData = SupportTicketPriority::where('is_active', 1)->get();

        if ($request->status != null && $request->priority != null) {
            $changeStatusPriority = SupportTicket::where('id', $id)->update([
                'ticket_status_id' => $request->status,
                'support_ticket_priority_id' => $request->priority,
            ]);

            if ($changeStatusPriority) {
                Session::flash('message', [
                    'text' => "Record has been updated",
                ]);
                return redirect()->back();
            } else {
                Session::flash('error', [
                    'text' => "Cannot save records at this time, please try again",
                ]);
            }
        }

        $data = SupportTicket::find($id);
        $attachments = null; // Initialize attachments to null

        if ($data->user_id == Auth::user()->id) {

            if ($data->attachments) {
                $attachments = json_decode($data->attachments);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    Session::flash('error', [
                        'text' => "Error decoding attachments data",
                    ]);
                }
            }

            $supportTicketReply = SupportTicketReply::where('support_ticket_id', $id)->get();

            LogActivity::addToLog($request, 'view ticket #' . $data->ticket_number);
            return view($this->view . 'show', compact(
                'data',
                'attachments',
                'ticketStatusData',
                'ticketPriorityData',
                'supportTicketReply',
            ));
        } else {
            Session::flash('error', [
                'text' => "Ticket does not exists",
            ]);
            return redirect($this->route);
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
                'message.required' => 'Message is required.',

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
            // Update Ticket Data
            $updateSupportTicket = SupportTicket::where('id', $id)->update([
                'ticket_status_id' => 1,
                'updated_at' => now(),
            ]);

            // Store new reply
            $data = new SupportTicketReply();
            $data->user_id = Auth::user()->id;
            $data->support_ticket_id = $request->support_ticket_id;
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

            if ($result && $updateSupportTicket) {
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

                LogActivity::addToLog($request, 'New Ticket created by '.$mailData['name']);
                Session::flash('message', [
                    'text' => "Ticket reply is updated",
                ]);
            } else {
                Session::flash('errors', [
                    'text' => "Something went wrong, please try again",
                ]);
            }
            return redirect()->back()->withInput();
        }
    }
}
