<?php

namespace App\Http\Controllers;

use App\Models\AdmissionApplication;
use App\Models\EnquiryFollowUp;
use App\Models\ImmigrationApplication;
use App\Models\Role;
use App\Notifications\FollowUpAlert;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }


    public function getDownload($file)
    {
        $file_location = public_path("/uploads/" . base64_decode($file));
        // dd($file_location);
        return response()->file($file_location);
    }

    public function work()
    {

        foreach (AdmissionApplication::all() as $app) {
        	
            $pro = $app->applicationProcesses()->orderby('application_status_id', 'desc')->first();
            if ($pro) {
                $app->application_status_id =  $pro->application_status_id;
            }

            if (!$app->student_name) {
                $app->student_name = optional($app->client)->full_name ?? "-";
            }

            $app->save();
        }
        foreach (ImmigrationApplication::all() as $app) {
            $pro = $app->applicationProcesses()->orderby('application_status_id', 'desc')->first();
            if ($pro) {
                $app->application_status_id =  $pro->application_status_id;
                $app->save();
            }

            if (!$app->student_name) {
                $app->student_name = optional($app->client)->full_name ?? "-";
            }
        }

        return response()->json("done");
    }

   
}
