<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\NotificationDataTable;
use App\Models\EnquiryFollowUp;
use App\Models\Visa;
use App\Notifications\EmployeeVisaExpiryAlert;
use App\Notifications\ClientVisaExpiryAlert;
use Illuminate\Support\Facades\Schema;
use App\Notifications\FollowUpAlert;
use App\Notifications\NewEnquiryAlert;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class NotificationController extends BaseController
{
    //
    public function show($id)
    {
        $user = auth()->user();

        if ($notif = $user->notifications()->find($id)) {
            $notif->markAsRead();

            if($notif->type == EmployeeVisaExpiryAlert::class){
                return redirect()->route('employee.show',$notif->data['employee_id']);
            }
            if($notif->type == ClientVisaExpiryAlert::class){
                $id = optional($notif->data)['client_id']??$notif->data['Client_id'];
                return redirect()->route('client.show',$id);
            }

            if($notif->type == NewEnquiryAlert::class){
                $id = optional($notif->data)['enquiry_id']??$notif->data['Enquiry_id'];
                return redirect()->route('rawenquiry.show',$id);

            }

            return redirect()->route('enquiry.log', $notif->data['enquiry_id']);
        }
    }



    public function prepareNotifications()
{
    $start = Carbon::today();
    $end = Carbon::today()->addDays(env("constant.followup_notification_days", 1));

    if (Schema::hasTable('enquiry_followups')) {
        $followups = EnquiryFollowUp::whereHas('enquiry_activity')
            ->where('date', '>=', $start)
            ->where('date', '<=', $end)
            ->whereNull('followup_status')
            ->get();

        foreach ($followups as $followup) {
            $user_id = $followup->enquiry_activity->enquiry->enquiry_assigned_to;
            $users = User::where('role_id', 1)->orWhere('id', $user_id)->get();
            Notification::send($users, new FollowUpAlert($followup));
            $followup->followup_status = 1;
            $followup->save();
        }
    }

    $this->employeeVisaAlert(); // यो चाहिँ Visa टेबल check गर्न सकिन्छ चाहे
    return "done";
}



    public function deleteNotification($id)
    {
        optional(auth()->user()->notifications()->where('id', $id)->first())->delete();
        return back()->with("success", "Deleted notification");
    }


 public function employeeVisaAlert()
        {
            if (!Schema::hasTable('current_visas')) {
                return; // टेबल नभए query नगर
            }

            $start = Carbon::today();
            $end = Carbon::today()->addDays(config("constant.employee_visa_expiry_days", 60));

            $currentVisas = Visa::where('status', 'Active')
                ->whereNull('notified')
                ->where("employee_id", "!=", null)
                ->where("expiry_date", ">=", $start)
                ->where("expiry_date", "<=", $end)
                ->get();

            foreach ($currentVisas as $visa) {
                $users = User::where('role_id', 1)->get();
                Notification::send($users, new EmployeeVisaExpiryAlert($visa));
                $visa->notified = 1;
                $visa->save();
            }
        }



    public function index(){
        $data['notifications']=auth()->user()->notifications()->latest()->paginate(10);
        return view('admin.notification.index',compact('data'));
    }
}
