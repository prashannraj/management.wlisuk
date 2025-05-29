<?php

use App\Models\CompanyInfo;
use App\Models\EmailSender;
use App\Models\EnquiryFollowUp;
use App\Models\Visa;
use App\Notifications\ClientVisaExpiryAlert;
use App\Notifications\EmployeeVisaExpiryAlert;
use App\Notifications\FollowUpAlert;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schema;

if (!function_exists('isError')) {
    function isError($errors, $name, $message = null)
    {
        if ($errors->has($name)) {
            if ($message != null) {
                return '<span class="text-danger mt-1"><small>' . $message . '</small></span>';
            }
            return '<span class="text-danger mt-1"><small>' . ucfirst($errors->first($name)) . '</small></span>';
        }
    }
}

if (!function_exists('showErrors')) {
    function showErrors($errors)
    {
        $msg = "";
        foreach ($errors->all() as $error) {
            $msg .= '<span class="text-danger mt-1"><small>' . $error . '</small></span><br>';
        }

        return $msg;
    }
}

if (!function_exists('getTitle')) {
    function getTitle()
    {
        return ['Mr', 'Mrs', 'Ms', 'Miss', 'Dr', 'Prof', 'Sir'];
    }
}

if (!function_exists('getStatuses')) {
    function getStatuses()
    {
        return ["Active"=>"Active","Inactive"=>"Inactive"];
    }
}


if (!function_exists('getJobTypes')) {
    function getJobTypes()
    {
        return ['part time', 'full time'];
    }
}

if (!function_exists('getMonthStr')) {
    function getMonthStr($num)
    {
        return date_create_from_format("m", $num)->format('F');
    }
}


if (!function_exists('getYears')) {
    function getYears()
    {
        $year = date("Y");
        $years = [];
        for ($initial = 2013; $initial < $year + 5; $initial++) {
            array_push($years, $initial);
        }
        return $years;
    }
}


if (!function_exists('getEmailSender')) {
    function getEmailSender($id)
    {
       $em = EmailSender::find($id);

       if($em){
           return $em;
       }else{
           $em = new EmailSender;
           $em->name =config('mail.from.name');
           $em->email = config('mail.from.email');
           return $em;
       }

    }
}


if (!function_exists('find_location')) {
    function find_location($ip)
    {
        if ($ip == null || $ip == "") {
            $ip = "UNKNOWN";
            return "Unknown";
        }
        try {
            $json     = file_get_contents("http://ipinfo.io/$ip/geo");
            if (!$json) return '';
            $json     = json_decode($json, true);
            if (array_key_exists("error", $json)) {
                return "Unknown";
            }
            $country  = $json['country'];
            $region   = $json['region'];
            $city     = $json['city'];
            return $city . ", " . $region . ", " . $country;
        } catch (Exception $e) {
            return "Unknown";
        }
    }
}


if (!function_exists("get_client_ip")) {
    function get_client_ip()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } else if (isset($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipaddress = 'UNKNOWN';
        }

        return $ipaddress;
    }
}


if (!function_exists('enquiryAlerts')) {
    function enquiryAlerts()
    {
        if (!Schema::hasTable('enquiry_followups')) {
            return; // टेबल नभए function return गर्छ, query गर्दैन
        }

        $start = Carbon::today();
        $end = Carbon::today()->addDays(env("constant.followup_notification_days", 1));

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
}


if (!function_exists("employeeVisaAlerts")) {
    function employeeVisaAlerts()
    {
        $start = Carbon::today();
        $end = Carbon::today()->addDays(config("constant.employee_visa_expiry_days", 60));
        $currentVisas = Visa::whereStatus('Active')->where('notified', null)->where("employee_id", "!=", null)->where("expiry_date", ">=", $start)->where("expiry_date", "<=", $end)->get();
        foreach ($currentVisas as $visa) {
            $users = User::where('role_id', 1)->get();
            Notification::send($users, new EmployeeVisaExpiryAlert($visa));
            $visa->notified = 1;
            $visa->save();
        }
    }
}


if (!function_exists("clientVisaAlerts")) {
    function clientVisaAlerts()
    {
        $start = Carbon::today();
        $end = Carbon::today()->addDays(config("constant.client_visa_expiry_days", 60));
        $currentVisas = Visa::whereStatus('Active')->where('notified', null)->where("basic_info_id", "!=", null)->where("expiry_date", ">=", $start)->where("expiry_date", "<=", $end)->get();
        foreach ($currentVisas as $visa) {
            $users = User::where('role_id', 1)->get();
            Notification::send($users, new ClientVisaExpiryAlert($visa));
            $visa->notified = 1;
            $visa->save();
        }
    }
}

function companyLogo() {
    $companyInfo = CompanyInfo::first();
    return $companyInfo->logo_url;
}
