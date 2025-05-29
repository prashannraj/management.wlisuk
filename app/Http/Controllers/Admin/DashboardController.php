<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdmissionApplication;
use App\Models\Enquiry;
use App\Models\ImmigrationApplication;
use App\Models\Invoice;
use App\Models\Visa;



use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
// Remove this line if it does not exist in your project

// If you are using an external Setting package, import its facade correctly, for example:
use anlutro\LaravelSettings\Facade as Setting;

class DashboardController extends Controller

{
    public function main()
    {
        $data = [];
        $currentMonth = date('m');
        $latestEnquiry = count(Enquiry::whereRaw('MONTH(created) = ?', [$currentMonth])->orderBy('created', 'desc')->get());
        $data['grid'] = [
            'latest' => [
                [
                    'title' => 'New Enquiry', 'count' => $latestEnquiry, 'link' => route('enquiry.list')
                ],
            ],
        ];

        $enquiry[] = Enquiry::where("created",'>',Carbon::now()->subDays(30))->count();
        $enquiry[] = Enquiry::where("created",'>',Carbon::now()->subMonths(3))->count();
        $enquiry[] = Enquiry::where("created",'>',Carbon::now()->subMonths(6))->count();
        $enquiry[] = Enquiry::where("created",'>',Carbon::now()->subYear(1))->count();
        $data['enquiry_data'] = collect($enquiry);


        $application[] = ImmigrationApplication::where("application_status_id","!=",5)->count();
        $application[] = AdmissionApplication::count();

        $data['application_data'] = collect($application);

        
        $visaapp[] = Visa::whereStatus('Active')->where("basic_info_id","!=",null)->where("expiry_date",">=",Carbon::now())->where("expiry_date","<=",Carbon::now()->addMonths(6))->count();
        

        $visaapp[] = Visa::whereStatus('Active')->where("basic_info_id","!=",null)->where("expiry_date",">=",Carbon::now())->where("expiry_date","<=",Carbon::now()->addMonths(3))->count();
        

        $visaapp[] = Visa::whereStatus('Active')->where("basic_info_id","!=",null)->where("expiry_date",">=",Carbon::now())->where("expiry_date","<=",Carbon::now()->addMonths(1))->count();
        

        $visaapp[] = Visa::whereStatus('Active')->where("basic_info_id","!=",null)->where("expiry_date",">=",Carbon::now())->where("expiry_date","<=",Carbon::now()->addWeeks(1))->count();
        
        
        $visaapp[] = Visa::whereStatus('Active')->where("basic_info_id","!=",null)->where("expiry_date","=",Carbon::now())->count();

        $d = DB::table('immigration_application_processes')
                ->select('reason', DB::raw('count(*) as count')) // ✅ सही
                ->where('application_status_id', 5)
                ->groupBy('reason')
                ->get();
        $data['fileData'] = array();
        $data['fileLabels'] = array();

       


        foreach($d as $key=>$value){
            $data['fileData'][]  = $value->count;
            $data['fileLabels'][] = $key==""?"Unknown":$key;
        }
        $data['visa_data']=collect($visaapp);

        // $invoice_data = Invoice::get()->groupBy('balance');
        // $data['invoiceData'] = array();
        // $data['invoiceLabels'] = array();
        // foreach($invoice_data as $key=>$inv){
        //     $data['invoiceLabels'][] = $key;
        //     $data['invoiceData'][] = $inv->count();
        // }

        $invoice_data = Invoice::where('balance',">",0)->orderBy('balance')->get()->groupBy('balance');
        $data['invoiceDataLabels'] = array();
        foreach($invoice_data as $key=>$inv){
            $data['invoiceDataLabels'][$key] = $inv->count();
        }


        // dd($data['enquiry_data']);
        // dd($data);
    	return view('admin.dashboard',compact('data'));
    }

    public function blank()
    {
    	return view('admin.blank');
    }

    public function test(){
        $inv = Invoice::all();
        foreach($inv as $i){
           $i->recalculateTotals(); 
        }

        $invoice_data = Invoice::where('balance',">",0)->get()->groupBy('balance');
        $data['invoiceDataLabels'] = array();
        foreach($invoice_data as $key=>$inv){
            $data['invoiceDataLabels'][$key] = $inv->count();
        }
        dd($data);
    }


    public function settings(){
        return view("admin.settings");
    }

    public function saveSettings(Request $request){
       $input = $request->all();
    
       foreach($input as $key=>$value){
        if ($key != "_token") {
            Setting::set($key,$value);
            
            
        }
        Setting::save();
       }

       return back()->with("success","Successfully updated settings");
    }
}
